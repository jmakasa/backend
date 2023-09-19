<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;   
use Illuminate\Support\Facades\Log;


class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->segment(1)){
            $locale = $request->segment(1); 
        } else {
            return redirect()->to('/' . config("app.locale"));
        }
        
        // check the locale is on the list
        // else go to default locale - EN
        if (in_array($locale,config("app.locales"))) {
                session()->put('locale', $locale);
                app()->setLocale($locale);
        } else {
            // redirect to home
            return redirect()->to('/' . config("app.locale"));
        }
        return $next($request);
    }
}
