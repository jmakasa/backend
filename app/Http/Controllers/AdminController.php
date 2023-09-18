<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
          //  $this->projects = Auth::user()->projects;

            return $next($request);
        });
    }
    
    //
    public function dashboard(){
      
        return view('admin.dashboard');
    }
}
