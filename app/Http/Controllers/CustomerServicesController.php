<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use PHPMailer\PHPMailer\Exception;

use Redirect;

class CustomerServicesController extends Controller
{
    protected $title;

    public function __construct()
    {
        $this->title = "Customer Service Portal";
    }

    public function viewlist($locale, Request $request)
    {
        if (!$this->hasLoginFromMarketing()) {
            // redirect to login
            $currenturl = $request->url();

            //   dd($currenturl);
            $host = request()->getHttpHost();
            $url = "http://" . $host . "/marketing/login.php?returnUrl=" . $currenturl;
            return Redirect::to($url);
        }
        
        Logger()->debug(" getList : session " . var_export($_SESSION, true));

        return view('backend.customerServices.list',['title' => $this->title,'userId'=>$_SESSION['userid']]);
    }

    
}
