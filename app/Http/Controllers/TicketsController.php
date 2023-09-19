<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Models\Tickets;
use App\Models\WebEmailContactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\EmailService;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\EmployeesController as EmployeesCtrl;

use Exception;
use Redirect;


class TicketsController extends Controller
{
    public function __construct()
    {
        //     $this->middleware('auth', ['except' => ['getTicketFormSettings','getTicketList']]);
    }

    public function addTicket($locale, Request $request)
    {
    }

    public function fetchEmailContactus($locale)
    {

        // get WebEmailContactus tickets_id = 0
        $getEmailContactus = WebEmailContactus::where("tickets_id", WebEmailContactus::TICKETS_AWAIT)->get();

        /***
         * insert into tickets and update tickets_id WebEmailContactus
         */
        foreach ($getEmailContactus as $emailContactus) {

            // new ticket
            // $loginUser = $this->loginUser();
            $newTicket = Tickets::firstOrNew(['email_id' => $emailContactus->id]);
            // if ($emailContactus->get('parent_ticket_id') != 'NULL') {
            //     $newTicket->parent_ticket_id = $emailContactus->get('parent_ticket_id');
            // }

            $newTicket->subject = $this->shortenSubject($emailContactus->subject);
            $newTicket->content = $this->shortenContent($emailContactus->description);
            $newTicket->attachment = $emailContactus->attachments;
            $newTicket->start_datetime = $emailContactus->start_datetime;
            $newTicket->due_datetime = $emailContactus->due_datetime;
            $newTicket->ticket_desc = $emailContactus->ticket_desc;
            //  $newTicket->remarks = $request->get('remarks');
            // the email which from client request or enquire
            $newTicket->from_firstname = $emailContactus->firstname;
            $newTicket->from_lastname = $emailContactus->lastname;
            $newTicket->from_email = $emailContactus->email;

            // $newTicket->assignor = $loginUser['username'];
            // $arAssignee = $request->get('assignee');
            // $newTicket->assignee = $arAssignee['email'];
            $newTicket->type = $this->shortenSubject($emailContactus->contact_reason);
            $newTicket->status = Tickets::STATUS_OPEN;

            // TODO :: get account_contact_id the id assoicate to account table
            //  $newTicket->account_contact_id = $request->get('account_contact_id');

            if ($newTicket->save()) {
                logger()->debug(" newTicket - Store data : SAVED " . var_export($newTicket, true));
                $emailContactus->tickets_id = $newTicket->id;
                $emailContactus->save();
            }
        }
    }


    /**
     *  return json of Tickets status
     */
    public function getFormSettings(EmployeesCtrl $employeesCtrl)
    {
        $arySetting['status'] = [
            ['value' => Tickets::STATUS_OPEN,'text' => Tickets::STATUS_OPEN],
            ['value' => Tickets::STATUS_PRIOR,'text' => Tickets::STATUS_PRIOR],
            ['value' => Tickets::STATUS_IN_PROGRESS,'text' => Tickets::STATUS_IN_PROGRESS],
            ['value' => Tickets::STATUS_REVIEW,'text' => Tickets::STATUS_REVIEW],
            ['value' => Tickets::STATUS_CLOSED,'text' => Tickets::STATUS_CLOSED],
            ['value' => Tickets::STATUS_REOPEN,'text' => Tickets::STATUS_REOPEN]
        ];
        $arySetting['optStatus'] = array_merge([['text' => 'ALL','value'=> 'ALL']], $arySetting['status']);

        $arySetting['type'] = [
            ['text' => 'RMA Related','value' => 'RR'],
            ['text' => 'Technical Support','value' => 'TS'],
            ['text' => 'Press Inquiries','value' => 'PI'],
            ['text' => 'Reseller and Distribution','value' => 'RAD'],
            ['text' => 'Others','value' => 'OT']
        ];
        $arySetting['optType'] = array_merge([['text' => 'ALL','value'=> 'ALL']], $arySetting['type']);

        // $arySetting['assignees'] = [
        //     ['text' => 'David Tai', 'value' => 'wmtai@akasa.co.uk'],
        //     ['text' => 'Yitsen Chen', 'value' => 'yitsen@akasa.co.uk'],
        //     ['text' => 'Ivan', 'value' => 'ivan@akasa.co.uk'],
        //     ['text' => 'Bernardo Costa', 'value' => 'bernardo@akasa.co.uk'],
        //     ['text' => 'Phoebe', 'value' => 'phoebe@akasa.co.uk'],
        //     ['text' => 'Ashley Wang', 'value' => 'ashleywang@akasa.co.uk'],
        //     ['text' => 'Tony', 'value' => 'tony@akasa.co.uk'],
        //     ['text' => 'Charya Long', 'value' => 'maggie@akasa.co.uk'],
        //     ['text' => 'Justin Mak', 'value' => 'jmtest2211@outlook.com'],
        //     // ['text' => 'Justin Mak','value'=> 'justin@akasa.co.uk'],

        //     //     ['text' => 'Calvin','value'=> 'calvin@akasa.co.uk'],
        // ];
        $arySetting['assignees'] = $employeesCtrl->aryEmployeeList();

        $arySetting['contact_reason']  = [
            ['text' => 'RMA Related','value' => 'RR'],
            ['text' => 'Technical Support','value' => 'TS'],
            ['text' => 'Press Inquiries','value' => 'PI'],
            ['text' => 'Reseller and Distribution','value' => 'RAD' ],
            ['text' => 'Others','value' => 'OT'],

        ];

        $arySetting['optAssignees'] = array_merge([['name' => 'ALL','id'=> 'ALL']], $arySetting['assignees']);

        return response()->json($arySetting);
    }

    /**
     * add new tickets
     * post
     */
    public function addNewTicket($locale, Request $request, EmailService $emailService)
    {
        Logger()->debug(" addNewTicket : data " . var_export($request->all(), true));
        $result = ['result' => false];
        if (!$this->hasLoginFromMarketing()) {
            return response()->json($result);
        }
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                    'ticket_desc' => 'required',
                    'assignee' => 'required',
                    'start_datetime' => 'required',
                    'tstatus' => 'required',
                    'submitting' => 'required',
                ],
                [
                    'id.required' => 'ID is required.',
                    'ticket_desc.required' => 'Ticket Description is required.',
                    'assignee.required' => 'Assignee is required.',
                    'start_datetime.required' => 'Start date is required.',
                    'tstatus' => 'Status is required',
                    'submitting.required' => 'Form is not valid.',

                ]
            );
            $loginUser = $this->loginUser();
            $newTicket = Tickets::firstOrNew(['email_id' => $request->get('id')]);
            if ($request->get('parent_ticket_id')) {
                $newTicket->parent_ticket_id = $request->get('parent_ticket_id');
            }

            $newTicket->subject = $request->get('subject');
            $newTicket->content = $request->get('description');
            $newTicket->attachment = $request->get('attachments');
            $newTicket->start_datetime = $request->get('start_datetime');
            $newTicket->due_datetime = $request->get('due_datetime');
            $newTicket->ticket_desc = $request->get('ticket_desc');
            //  $newTicket->remarks = $request->get('remarks');
            // the email which from client request or enquire
            $newTicket->from_firstname = $request->get('firstname');
            $newTicket->from_lastname = $request->get('lastname');
            $newTicket->from_email = $request->get('email');

            $newTicket->assignor = $loginUser['username'];
            $arAssignee = $request->get('assignee');
            $newTicket->assignee_id = $arAssignee['id'];
            $newTicket->assignee = $arAssignee['email'];
            $newTicket->type = 'Email enquires';

            $aryStatus = $request->get('tstatus');
            $newTicket->status = $aryStatus['value'];

            // TODO :: get account_contact_id the id assoicate to account table
            $newTicket->account_contact_id = $request->get('account_contact_id');

            if ($newTicket->save()) {
                // send notification to assignee
                $aryNotice = [
                    'name' => $arAssignee['name'],
                    'email' => $arAssignee['email'],
                    'subject' => 'New Ticket is assigned - ' . $newTicket->subject,
                    'link' => route('cs.ticketDetail', ['locale' => $locale, 'id' => $newTicket->id]),
                ];
                $sendNotice = $emailService->ticketNotification($aryNotice);
                logger()->debug(" newTicket -send notice return : " . var_export($sendNotice, true));
                logger()->debug(" newTicket - Store data : SAVED " . var_export($request->all(), true));
                $result = ['result' => true, 'data' => $newTicket];
            } else {
                logger()->error(" newTicket - Store data : failed to save " . var_export($request->all(), true));
            }

            return response()->json($result);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    /**
     * update ticket_desc desc, status, due_datetime
     */
    public function updateDetail($locale, Request $request)
    {
        Logger()->debug(" updateDetail : data " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                    'ticket_desc' => 'required',
                    'tstatus' => 'required',
                ],
                [
                    'id.required' => 'ID is required.',
                    'ticket_desc.required' => 'Ticket Description is required.',
                    'tstatus' => 'Status is required',
                ]
            );
            $loginUser = $this->loginUser();
            $ticket = Tickets::whereId($request->get('id'))->first();

            $ticket->ticket_desc = $request->get('ticket_desc');
            $ticket->status = $request->get('tstatus')['value'];
            if (isset($request->get('assignee')['email']) && $request->get('assignee')['email']){
                $ticket->assignee =$request->get('assignee')['email'];
                $ticket->assignee_id =$request->get('assignee')['id'];
            }
            
            
            $ticket->start_datetime = ($request->get('start_datetime') != 'NULL' ? $request->get('start_datetime') : '');
            $ticket->due_datetime = ($request->get('due_datetime') != 'NULL' ? $request->get('due_datetime') : '');
            $ticket->updated_by = $loginUser['username'];
            if ($ticket->save()) {
                logger()->debug(" updateDetail - Store data : SAVED " . var_export($request->all(), true));
                $result = ['result' => true, 'data' => $ticket];
            } else {
                logger()->error(" updateDetail - Store data : failed to save " . var_export($request->all(), true));
            }
            return response()->json($result);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function getList($locale, Request $request)
    {
        $sort = $request->has('sort') ? $request->get('sort') : 'created_at';
        $order = $request->has('order') ? $request->get('order') : 'desc';
        $page = $request->has('page') ? $request->get('page') : 1;
        $rows = $request->has('rows') ? $request->get('rows') : 50;
        $lang = $request->has('lang') ? $request->get('lang') : 'en';
        $skip = ($page - 1) * $rows;


        Logger()->debug(" getList : request - " . var_export($request->all(), true));
        $tickets = Tickets::orderBy($sort, $order)->skip($skip)->take($rows);
        if ($request->get('type') && $request->get('type')  !='ALL'){
            $tickets->where("type",$request->get('type'));
        }
        if ($request->get('status') && $request->get('status')  !='ALL'){
            $tickets->where("status",$request->get('status'));
        }
        if ($request->get('assignee_id') && $request->get('assignee_id')  !='ALL'){
            $tickets->where("assignee_id",$request->get('assignee_id'));
        }
        $result['total'] = Tickets::all()->count();
        $result['rows'] = $tickets->get();

        return response()->json($result);
    }

    public function getRecentUpdated($locale, Request $request)
    {
        $sort = $request->has('sort') ? $request->get('sort') : 'updated_at';
        $order = $request->has('order') ? $request->get('order') : 'desc';
        $page = $request->has('page') ? $request->get('page') : 1;
        $rows = $request->has('rows') ? $request->get('rows') : 50;
        $lang = $request->has('lang') ? $request->get('lang') : 'en';
        $skip = ($page - 1) * $rows;
        $tickets = Tickets::orderBy($sort, $order)->skip($skip)->take($rows);

        $result['total'] = Tickets::all()->count();
        $result['rows'] = $tickets->get();

        return response()->json($result);
    }

    /**
     * view page of ticket detail
     */
    public function viewDetailById($locale, $id, Request $request)
    {
        $result = ['result' => false];
        if (!$this->hasLoginFromMarketing()) {
            // redirect to login
            $currenturl = $request->url();

            //   dd($currenturl);
            $host = request()->getHttpHost();
            $url = "http://" . $host . "/marketing/login.php?returnUrl=" . $currenturl;
            return Redirect::to($url);
        }
        try {
            $title = "Ticket";
            return view('backend.customerServices.ticketDetail', compact('id', 'title'));
        } catch (Exception $e) {
            Logger()->debug(" compose : error - " . var_export($e, true));
        }
    }

    /**
     * return json
     */
    public function getDetailById($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                ],
                [
                    'id.required' => 'email ID is required.',
                ]
            );
            $result['result'] = false;

            $ticket = Tickets::where('id', $request->get('id'))->first();
            if ($ticket) {
                $result['result'] = true;
                $result['data'] = $ticket;
            }

            return response()->json($result);
        } catch (Exception $e) {
            Logger()->debug(" compose : error - " . var_export($e, true));
        }
    }

    public function testNotice($locale, $id, EmailService $emailService)
    {
        // send notification to assignee
        $aryNotice = [
            'name' => 'Justin Mak',
            //'email' => 'justin@akasa.co.uk',
            'email' => 'jmtest2211@outlook.com',
            //'email' => 'makjustin@protonmail.com',


            'subject' => 'New Ticket is assigned - ',
            'link' => route('cs.ticketDetail', ['locale' => $locale, 'id' => $id]),
        ];
        return $emailService->ticketNotification($aryNotice);
    }

    /**
     * function to shorten subject
     */
    private function shortenSubject($subject)
    {
        //json_decode
        $aryStr = json_decode($this->getFormSettings());
        foreach ($aryStr['contact_reason'] as $str) {
            $subject = str_replace($str['value'], $str['text'], $subject);
        }
        return $subject;
    }

    private function shortenContent($content)
    {
        $aryContent = explode("Description :", $content);
        return $aryContent[1];
    }
}
