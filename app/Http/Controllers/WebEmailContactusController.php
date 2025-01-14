<?php

namespace App\Http\Controllers;

use App\Models\WebEmailContactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Services\FileService;
use Illuminate\Validation\ValidationException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;

class WebEmailContactusController extends Controller
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

    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['apiProductLists']]);
        // $this->host = "5.102.89.91"; //mailgate.akasa.co.uk // 5.102.89.91
        //$this->host = "5.102.89.91"; //mailgate.akasa.co.uk // 5.102.89.91
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

    public function getList()
    {
        $emailContactus = WebEmailContactus::all()->toArray();
        return response()->json($emailContactus);
    }

    public function mailTest($locale, Request $request)
    {

        
        try{
            Logger()->debug(" mailTest ");

            $data = array('name' => "Virat Gandhi");
            Mail::send('email.temp', $data, function ($message) {
                $message->to('makjustin@protonmail.com', 'Tutorials Point')
                ->subject('Laravel HTML Testing Mail');
                $message->attach(public_path('uploads/AK-PCCE25-01_g05.jpg'));
               // Logger()->debug(" mailTest : ".var_export($message,true));
            });
            Logger()->debug(" mailTest : sent?");
        }  catch (Exception $e) {
            Logger()->debug(" compose : error - " . var_export($e, true));
        //    dd($mail->ErrorInfo);
      //      exit;
            //  return back()->with('error','Message could not be sent.');
        }
       
    }

    public function composeEmail($locale, Request $request)
    {
        try{
            Logger()->debug(" composeEmail sendmail ");

            // TODO ::  sender, sender name, cc, bcc, replyTo, from, to 
            //  email : subject, content, attachment
            // returnPath

            $data = array('name' => "Virat Gandhi");
            Mail::send('email.temp', $data, function ($message) {
                $message->to('makjustin@protonmail.com', 'Tutorials Point')
                ->subject('Laravel HTML Testing Mail');
                $message->attach(public_path('uploads/AK-PCCE25-01_g05.jpg'));
               // Logger()->debug(" mailTest : ".var_export($message,true));
            });
            Logger()->debug(" mailTest : sent?");
        }  catch (Exception $e) {
            Logger()->debug(" compose : error - " . var_export($e, true));
        //    dd($mail->ErrorInfo);
      //      exit;
            //  return back()->with('error','Message could not be sent.');
        }
    }
    
    public function composePhpmailerEmail($locale, Request $request)
    {
        try {
            $mail = new PHPMailer(true);     // Passing `true` enables exceptions
            Logger()->debug(" compose ");
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->isSMTP();
            $mail->SMTPDebug = $this->SMTPDebug; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
            $mail->Host = $this->host; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
            $mail->Port = $this->port; // TLS only
            $mail->Username = $this->smtpUsername;
            $mail->Password = $this->smtpPassword;
            $mail->isHTML($this->isHTML);
            $mail->SMTPAuth = $this->SMTPAuth;
            $mail->SMTPSecure = $this->SMTPSecure;

            $mail->CharSet = $this->CharSet;

            // assign email
            $emailFrom = 'justin@akasa.co.uk';
            //$emailFromName = $firstname . " " . $lastname;
            $emailFromName = "JM";
            $mail->setFrom($emailFrom, $emailFromName);

            $mail->addAddress('makjustin@protonmail.com', 'makjustin@protonmail.com');

            $mail->Subject = ' test email in 8.18';

            $emailContent = " in 8.18";
            $mail->msgHTML($emailContent);
            // end assign email 

            // // Email server settings
            // $mail->SMTPDebug = $this->SMTPDebug;
            // $mail->isSMTP();
            // $mail->Host = $this->SMTPDebug;             //  smtp host
            // $mail->SMTPAuth = true;
            // $mail->Username = 'user@example.com';   //  sender username
            // $mail->Password = '**********';       // sender password
            // $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            // $mail->Port = 587;                          // port - 587/465

            // $mail->setFrom('sender@example.com', 'SenderName');
            // $mail->addAddress($request->emailRecipient);
            // $mail->addCC($request->emailCc);
            // $mail->addBCC($request->emailBcc);

            // $mail->addReplyTo('sender@example.com', 'SenderReplyName');

            // if(isset($_FILES['emailAttachments'])) {
            //     for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
            //         $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
            //     }
            // }


            // $mail->isHTML(true);                // Set email content format to HTML

            // $mail->Subject = $request->emailSubject;
            // $mail->Body    = $request->emailBody;

            // $mail->AltBody = plain text version of email body;

            if (!$mail->send()) {
                // return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
                Logger()->debug(" compose : error - " . var_export($mail->ErrorInfo, true));
                dd($mail->ErrorInfo);
                exit;
            } else {
                Logger()->debug(" compose : sent - " . var_export($mail, true));
                exit;
                return back()->with("success", "Email has been sent.");
            }
        } catch (Exception $e) {
            Logger()->debug(" compose : error - " . var_export($mail->ErrorInfo, true));
            dd($mail->ErrorInfo);
            exit;
            //  return back()->with('error','Message could not be sent.');
        }
    }
}
