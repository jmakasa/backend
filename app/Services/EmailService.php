<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Exception;

class EmailService
{
    protected $host;
    protected $port;
    protected $smtpUsername;
    protected $smtpPassword;
    protected $isHTML;
    protected $SMTPAuth;
    protected $CharSet;
    protected $filesizeLimit;
    protected $SMTPDebug;
    protected $SMTPSecure;

    const TYPE_PRODUCT = "product";
    const TYPE_CONFIG = "config";
    const TYPE_NAVIMENU = "navimenu";
    const TYPE_MARKETING_TPL = "marketing_tpl";
    const FILE_TYPE_FEATURE = "feature";
    const FILE_TYPE_GALLERY = "gallery";
    const FILE_TYPE_CONTENT = "content";
    const FILE_TYPE_REVIEWS = "Reviews";
    const FILE_TYPE_CPY = "compatibility";
    const FILE_TYPE_MANUAL = "manual";
    const FILE_TYPE_MOVIE = "movie";
    const FILE_TYPE_SOFTWARE = "software";

    public function __construct()
    {
        $this->host = "mailgate.akasa.co.uk";
        $this->port = 25;
        $this->smtpUsername = "justin";
        $this->smtpPassword = "akasa2001";
        $this->isHTML = true;
        $this->SMTPAuth = false;
        $this->CharSet = "UTF-8";
        $this->filesizeLimit = "3072"; //3MB
        $this->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
        $this->SMTPSecure = false;
    }

    public function composeThread($emailContent)
    {
        try {
            Logger()->debug(" FileService - composeThread ");
            Logger()->debug(" EmailService - composeThread : emailContent - " . var_export($emailContent, true));
            // attachment
            if (isset($emailContent['attached_files']) && $emailContent['attached_files']) {
                foreach ($emailContent['attached_files'] as $attachedFile) {
                    if (!file_exists($attachedFile)){
                        Logger()->debug(" EmailService - composeThread : attachedFile - not exist" . var_export($attachedFile, true));
                        return false;
                    }
                }
            }
            Mail::send(['html'=>'email_templates.thread'], ['content'=>$emailContent['content']], function ($message) use ($emailContent) {
                
                $toEmail = json_decode($emailContent['to_email'],true);
                Logger()->debug(" EmailService - composeThread : toEmail - " . var_export($toEmail, true));
                $message->to($toEmail['email'], $toEmail['firstname']." ".$toEmail['lastname'])
                    ->subject($emailContent['subject']);
                // from email
                // system default email customer-success@akasa.co.uk
                // if (isset($emailContent['from_email']) && $emailContent['from_email']) {
                //     $message->from($emailContent['from_email'], $emailContent['from_firstname'] . " " . $emailContent['from_lastname']);
                // }
               // test justin
                $message->from('customer-success@akasa.co.uk',"Customer Success | AKASA ");

                // cc email
                if (isset($emailContent['to_cc']) && $emailContent['to_cc']) {
                    foreach (explode(",",$emailContent['to_cc']) as $cc) {
                        //$message->cc($cc['email'], $cc['firstname'] . " " . $cc['lastname']);
                        $message->cc($cc,$cc);
                    }
                }

                // bcc email
                if (isset($emailContent['to_bcc']) && $emailContent['to_bcc']) {
                    foreach (explode(",",$emailContent['to_bcc']) as $bcc) {
                        //$message->bcc($bcc['email'], $bcc['firstname'] . " " . $bcc['lastname']);
                        $message->cc($bcc,$bcc);
                    }
                }

                // attachment
                if (isset($emailContent['attached_files']) && $emailContent['attached_files']) {
                    foreach ($emailContent['attached_files'] as $attachedFile) {
                        Logger()->debug(" EmailService - composeThread : attachedFile - " . var_export($attachedFile, true));
                        $message->attach($attachedFile);
                    }
                }
                return true;
            });
            return true;
        } catch (Exception $e) {
            Logger()->debug(" EmailService - composeThread : error - " . var_export($e, true));
            return false;
        }
    }

    public function taskNotification($emailContent){
        try {
            Logger()->debug(" EmailService - taskNotification ");
            Logger()->debug(" EmailService - taskNotification : emailContent - " . var_export($emailContent, true));
            // need to name,link, email, subject
            // to_cc,to_bcc
            Mail::send(['html'=>'email_templates.task_notice'], [
                'name'=>$emailContent['name'],
                'link'=>$emailContent['link'],
            ], function ($message) use ($emailContent) {
                // from email
                // system default email customer-success@akasa.co.uk
                $message->from('customer-success@akasa.co.uk',"Customer Success | AKASA ");
                
                // email
                $message->to($emailContent['email'], $emailContent['name']);

                // subject
                $message->subject($emailContent['subject']);
                
                // cc email
                if (isset($emailContent['to_cc']) && $emailContent['to_cc']) {
                    foreach (explode(",",$emailContent['to_cc']) as $cc) {
                        //$message->cc($cc['email'], $cc['firstname'] . " " . $cc['lastname']);
                        $message->cc($cc,$cc);
                    }
                }

                // bcc email
                if (isset($emailContent['to_bcc']) && $emailContent['to_bcc']) {
                    foreach (explode(",",$emailContent['to_bcc']) as $bcc) {
                        //$message->bcc($bcc['email'], $bcc['firstname'] . " " . $bcc['lastname']);
                        $message->cc($bcc,$bcc);
                    }
                }

                // no attachment for task notification
                // if (isset($emailContent['attached_files']) && $emailContent['attached_files']) {
                //     foreach ($emailContent['attached_files'] as $attachedFile) {
                //         $message->attach($attachedFile);
                //     }
                // }
                return true;
            });
            Logger()->debug(" EmailService - composeThread : check failures - " . var_export(Mail::failures(), true));
            return Mail::failures();
          //  return true;
        } catch (Exception $e) {
            Logger()->debug(" EmailService - composeThread : error - " . var_export($e, true));
            return false;
        }
    }

    public function ticketNotification($emailContent){
        try {
            Logger()->debug(" EmailService - ticketNotification ");
            Logger()->debug(" EmailService - ticketNotification : emailContent - " . var_export($emailContent, true));
            // need to name,link, email, subject
            // to_cc,to_bcc
            Mail::send(['html'=>'email_templates.ticket_notice'], [
                'name'=>$emailContent['name'],
                'link'=>$emailContent['link'],
            ], function ($message) use ($emailContent) {
                // from email
                // system default email customer-success@akasa.co.uk
                $message->from('customer-success@akasa.co.uk',"Customer Success | AKASA ");
                
                // email
                $message->to($emailContent['email'], $emailContent['name']);

                // subject
                $message->subject($emailContent['subject']);
                
                // cc email
                if (isset($emailContent['to_cc']) && $emailContent['to_cc']) {
                    foreach (explode(",",$emailContent['to_cc']) as $cc) {
                        //$message->cc($cc['email'], $cc['firstname'] . " " . $cc['lastname']);
                        $message->cc($cc,$cc);
                    }
                }

                // bcc email
                if (isset($emailContent['to_bcc']) && $emailContent['to_bcc']) {
                    foreach (explode(",",$emailContent['to_bcc']) as $bcc) {
                        //$message->bcc($bcc['email'], $bcc['firstname'] . " " . $bcc['lastname']);
                        $message->cc($bcc,$bcc);
                    }
                }

                // no attachment for task notification
                // if (isset($emailContent['attached_files']) && $emailContent['attached_files']) {
                //     foreach ($emailContent['attached_files'] as $attachedFile) {
                //         $message->attach($attachedFile);
                //     }
                // }
                return true;
            });
            Logger()->debug(" EmailService - composeThread : check failures - " . var_export(Mail::failures(), true));
            return Mail::failures();
          //  return true;
        } catch (Exception $e) {
            Logger()->debug(" EmailService - composeThread : error - " . var_export($e, true));
            return false;
        }
    }

    public function mailTest()
    {


        try {
            Logger()->debug(" mailTest ");

            $data = array('name' => "Virat Gandhi");
            Mail::send('email.temp', $data, function ($message) {
                $message->to('makjustin@protonmail.com', 'Tutorials Point')
                    ->subject('Laravel HTML Testing Mail');
                $message->attach(public_path('uploads/AK-PCCE25-01_g05.jpg'));
                // Logger()->debug(" mailTest : ".var_export($message,true));
            });
            Logger()->debug(" mailTest : sent?");
        } catch (Exception $e) {
            Logger()->debug(" compose : error - " . var_export($e, true));
            //    dd($mail->ErrorInfo);
            //      exit;
            //  return back()->with('error','Message could not be sent.');
        }
    }
}
