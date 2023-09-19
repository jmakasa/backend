<?php

namespace App\Http\Controllers;

use App\Models\TicketThreads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;
use App\Services\EmailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Webklex\IMAP\Facades\Client;
use File;

class TicketThreadsController extends Controller
{

    public function __construct()
    {
        //   $this->middleware('auth', ['except' => ['getBlogsList']]);
        ini_set('memory_limit', '2048M');
    }


    /**
     * add threads
     * return json 
     * 
     */
    public function addThread($locale, Request $request, EmailService $emailService)
    {
        $result = ['result' => false];
        if (!$this->hasLoginFromMarketing()) {
            return response()->json($result);
        }
        logger()->debug(" addThread : " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'to_email' => 'required',
                    'content' => 'required',
                ],
                [
                    'to_email.required' => 'To Email is required.',
                    'content.required' => 'Content is required.',
                ]
            );

            logger()->debug(" addThread : " . var_export($request->all(), true));

            $ticketsId = $request->get('tickets_id');

            $content = $request->get('content');

            $dom = new \DomDocument();

            $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $imageFile = $dom->getElementsByTagName('img');

            $movePath = public_path() . "/ticket_threads_attachments/" . $ticketsId . "/";
            // check folder 
            //  File::ensureDirectoryExists($movePath);
            logger()->debug(" movePath : " . var_export($movePath, true));
            if (!File::isDirectory($movePath)) {
                logger()->debug(" addThread : isDirectory folder need to be created " . var_export($movePath, true));
                File::makeDirectory($movePath, 0777, true, true);
            }


            foreach ($imageFile as $key => $image) {
                $filename = $image->getAttribute('data-filename');
                $data = $image->getAttribute('src');

                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);

                $img_data = base64_decode($data);

                $webPath = "/ticket_threads_attachments/" . $ticketsId . "/";
                $webPathFilename = $webPath . $filename;
                //     // check folder 
                // //  File::ensureDirectoryExists($movePath);
                // logger()->debug(" movePath : " . var_export($movePath, true));
                // if (!File::isDirectory($movePath)) {
                //     File::makeDirectory($movePath, 0777, true, true);
                // }

                $fileFullPathWithName = $movePath . $filename;
                logger()->debug(" fileFullPathWithName " . var_export($fileFullPathWithName, true));
                //file_put_contents($fileFullPathWithName, $img_data);
                if (file_put_contents($fileFullPathWithName, $img_data)){
                    logger()->debug(" file_put_contents " . var_export($fileFullPathWithName, true));
                } else {
                    logger()->error(" FAILED file_put_contents " . var_export($fileFullPathWithName, true));
                }

                $image->removeAttribute('src');
                $image->setAttribute('src', $webPathFilename);
                //  $request->merge(['attachment'])

            }

            if (!empty($request->get('file'))) {
                // logger()->debug(" addThread : has attachments " . var_export($request->get('file'), true));
                $threadAttachedFile = [];
                $threadAttachedFileData = [];
                foreach ($request->get('file') as $file) {
                    $threadAttachedFile[] = $movePath . $file;
                    $threadAttachedFileData[] = $file;
                }
                 logger()->debug(" addThread : push attachments " . var_export($threadAttachedFile, true));
                $request->merge(['attached_files' => $threadAttachedFile]);
                $request->merge(['attachment' => implode(",", $threadAttachedFileData)]);
                $request->merge(['attachment_cnt' => count($threadAttachedFileData)]);
            }


            // from email from user login 
            // get it from session 
            $request->request->add(['from_email' => $_SESSION['email']]);

            $toEmail['email'] = $request->get('to_email');
            $toEmail['firstname'] = $request->get('to_firstname');
            $toEmail['lastname'] = $request->get('to_lastname');
            $request->merge(['to_email' => json_encode($toEmail, true)]);


            logger()->debug(" addThread : new TicketThreads " . var_export($request->all(), true));
            $thread = (new TicketThreads)
                ->validateAndFill($request->all())
                ->setAttribute('status', TicketThreads::STATUS_PENDING);

            if ($thread->save()) {
                logger()->debug(" addThread - composeThread data " . var_export($thread, true));
                if (isset($threadAttachedFile) && !empty($threadAttachedFile)) {
                    $request->merge(['attached_files' => $threadAttachedFile]);
                }
                //$sendThread = $emailService->composeThread($thread->toArray());
                $sendThread = $emailService->composeThread($request->all());
                logger()->debug(" addThread -send request return : " . var_export($sendThread, true));

                if ($sendThread) {
                    // sent update status
                    $thread->status = TicketThreads::STATUS_SENT;
                    $thread->save();
                    return true;
                } else {
                    return false;
                }
            } else {
                logger()->debug(" addThread - Store data : NO inserted" . var_export($request->all(), true));
                //   return back()->with('autofocus', true);
            }
        } catch (ValidationException $ex) {
            logger()->error(" addThread " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    /**
     * update thread status
     * return json 
     * 
     */
    public function updateThreadStatus($locale, Request $request)
    {
    }

    /**
     * send thread
     * return json 
     * 
     */
    public function sendThread($locale, Request $request)
    {
    }

    public function imapFetch()
    {


        // $oClient = new Client([
        //     'host'          => '192.168.8.18',
        //     'port'          => 143,
        //     'encryption'    => false,
        //     'validate_cert' => false,
        //     'username'      => 'justin',
        //     'password'      => 'akasa2001',
        //     'protocol'      => 'imap'
        // ]);
        $client = Client::account('default');
        $client->connect();

        $aFolder = $client->getFolderByName('INBOX');

        $aMessage = $aFolder->messages()->all()->fetchOrderDesc()->limit(1, 0)->get();
        $insertData = [];
        foreach ($aMessage as $oMessage) {

            // subject get the search the REFNO#
            if (!is_null($oMessage->getSubject()->first())) {
                $insertData['subject'] = $oMessage->getSubject()->first();
                //
            }

            // for testing only 
            // $insertData['subject'] = '6 | [RR] TESTING (REFNO#15) From 6';
            // if there is  REFNO#
            $checkRefNo = preg_match('/(TICKETNO#\\d*)/', $insertData['subject'], $matches);

            if ($checkRefNo) {

                $aryRefno = explode("#", $matches[0]);
                $ticketId = $aryRefno[1];
                $insertData['tickets_id'] = $ticketId;
                // header || for reference
                $header = $oMessage->getHeader();
                // to address >> array
                $arrToAddressData = [];
                $aryToAddress = $oMessage->getTo()->toArray();
                foreach ($aryToAddress as $key => $toAdd) {
                    $fullname = $toAdd->personal . "<" . $toAdd->mail . ">";
                    $arrToAddressData[] = $fullname;
                }
                $insertData['to_email'] = implode(",", $arrToAddressData);

                // from address >> array
                $arrFromAddressData = [];
                $aryFromAddress = $oMessage->getFrom()->toArray();
                foreach ($aryFromAddress as $key => $fromAdd) {
                    $fullname = $fromAdd->personal . "<" . $fromAdd->mail . ">";
                    $arrFromAddressData[] = $fullname;
                }
                $insertData['from_email'] = implode(",", $arrFromAddressData);

                // CC address >> array
                if (!is_null($oMessage->getCc())) {
                    $arrCCAddressData = [];
                    $aryCCAddress = $oMessage->getCc()->toArray();
                    foreach ($aryCCAddress as $key => $ccAdd) {
                        $fullname = $ccAdd->personal . "< " . $ccAdd->mail . " >";
                        $arrCCAddressData[] = $fullname;
                    }
                    $insertData['to_cc'] = implode(",", $arrCCAddressData);
                }

                // BCC address >> array
                if (!is_null($oMessage->getBcc())) {
                    $arrBCCAddressData = [];
                    $aryBCCAddress = $oMessage->getBcc()->toArray();
                    foreach ($aryBCCAddress as $key => $bccAdd) {
                        $fullname = $bccAdd->personal . "< " . $bccAdd->mail . " >";
                        $arrBCCAddressData[] = $fullname;
                    }
                    $insertData['to_bcc'] = implode(",", $arrCCAddressData);
                }


                // content
                $bodyContent = "";
                if ($oMessage->hasHTMLBody()) {
                    $bodyContent =  $oMessage->getHTMLBody(true);
                } else {
                    $bodyContent =  $oMessage->getTextBody();
                }
                $insertData['content'] = $bodyContent;

                // content_language
                $insertData['content_language'] = $oMessage->getContentLanguage();

                // content_type
                $insertData['content_type'] = $oMessage->getContentType()->first();

                // message id message_id
                $insertData['message_id'] = $oMessage->getMessageId()->first();

                // date
                $date = $oMessage->getDate()->first()->toArray();
                $insertData['sent_datetime'] = $date['formatted'];

                //  attachment 
                // check hasAttachments()
                $cntAttachments = $oMessage->hasAttachments();
                $insertData['attachment_cnt'] = $cntAttachments;

                $getAttachments = $oMessage->getAttachments();
                //     $mime = $attachments->getMimeType();
                // attachment handling
                if ($cntAttachments > 0) {
                    $aryAttachments = [];
                    foreach ($getAttachments->toArray() as $objAttachment) {
                        $movePath = public_path() . "/ticket_threads_attachments/" . $ticketId . "/";
                        // check folder 
                        //  File::ensureDirectoryExists($movePath);
                        logger()->debug(" movePath : " . var_export($movePath, true));
                        if (!File::isDirectory($movePath)) {
                            File::makeDirectory($movePath, 0777, true, true);
                        }
                        $filename = $objAttachment->getName();
                        $objAttachment->save($movePath, $filename);
                        $aryAttachments[] = $filename;
                    }
                    $insertData['attachment'] = implode(",", $aryAttachments);
                }
                // insert into threads with ticket id 
                $newThread = TicketThreads::firstOrCreate($insertData);

                if ($newThread) {
                    logger()->debug(" fetch inserted : " . var_export($insertData, true));
                    // move the email to fetched
                    if ($oMessage->move('INBOX.fetched') == true) {
                        echo 'Message has been moved';
                    } else {
                        echo 'Message could not be moved';
                    }
                } else {
                    logger()->error(" fetch error : " . var_export($insertData, true));
                }
            }
        }
    }

    public function getThreadsByTicketId($locale, Request $request)
    {
        $result = ['result' => false];
        if (!$this->hasLoginFromMarketing()) {
            return response()->json($result);
        }
        logger()->debug(" getThreadsByTicketId : " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                ],
                [
                    'id.required' => 'Ticket ID is required.',
                ]
            );
            $ticketThreads = TicketThreads::where('tickets_id', $request->get('id'))->orderBy("created_at", "asc")->get()->toArray();

            return response()->json($ticketThreads);
        } catch (ValidationException $ex) {
            logger()->error(" getThreadsByTicketId " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    public function uploadAttachment($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'file' => 'required',
                    'id' => 'required',
                ],
                [
                    'id.required' => 'Ticket ID is required.',
                    'file.required' => 'File is required.',
                ]
            );
            $rFiles = $request->file('file');
            $filename = $rFiles->getClientOriginalName();

            $movePath = public_path() . "/ticket_threads_attachments/" . $request->get('id') . "/";

            // check folder 
            //  File::ensureDirectoryExists($movePath);
            logger()->debug(" movePath : " . var_export($movePath, true));
            if (!File::isDirectory($movePath)) {
                File::makeDirectory($movePath, 0777, true, true);
            }
            //  move file
            $updated = $rFiles->move($movePath, $filename);
            logger()->debug(" uploadAttachment : " . var_export($updated, true));

            return response()->json($updated);
        } catch (ValidationException $ex) {
            logger()->error(" getThreadsByTicketId " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    public function sendingPendingThreads(EmailService $emailService){
        $pendingThread = TicketThreads::where("status",TicketThreads::STATUS_PENDING)->get()->toArray();
        foreach ($pendingThread as $thread){
            // logger()->debug(" sendingPendingThreads : " . var_export($thread, true));
            if ($thread['attachment']){
                $aryAttachments = explode(",", $thread['attachment']);
                $movePath = public_path() . "/ticket_threads_attachments/" . $thread['tickets_id'] . "/";
                $aryFile = [];
                foreach ($aryAttachments as $filename){
                    $aryFile[]=$movePath.$filename;
                }
                $thread['attached_files'] = $aryFile;
            }

            if ($emailService->composeThread($thread)){
                TicketThreads::whereId($thread['id'])->update(['status'=>TicketThreads::STATUS_SENT]);
            };
        }
    }
}
