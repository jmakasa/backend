<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;

class HomeController extends Controller
{

    protected $category;
    protected $lang;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //   $this->middleware('auth', ['except' => ["index"]]);
        $this->category = Category::whereStatus("Active")->whereNull('parent_id')->get()->sortBy('seq');
        $this->lang = [
            "en" => "English",
            "tw" => "繁體中文",
            "cn" => "简体中文",
            "fr" => "French",
            "de" => "German",
            "es" => "Spanish",
            "pt" => "Portuguese",
        ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        logger()->debug(" Home ");
        return view('home');
    }

    public function landing()
    {
        // $category
        $category = $this->category;
        //$category = [];
        $lang = $this->lang;

        return view('frontend.landing', compact('category', 'lang'));
    }

    public function aboutus()
    {
        // $category
        $category = $this->category;
        //$category = [];
        $lang = $this->lang;

        return view('frontend.pages.aboutus', compact('category', 'lang'));
    }

    public function switchLang(Request $request)
    {
        logger()->debug(" switch " . var_export($request->input("locale"), true));

        logger()->debug(" URL " . var_export(url()->previous(), true));
        $newLocale = $request->input("locale");
        $currentLocale = app()->getLocale();
        if (in_array($newLocale, config("app.locales"))) {
            session()->put('locale', $newLocale);
            app()->setLocale($newLocale);
            logger()->debug(" switchLang assigned to session  new :　$newLocale, old: $currentLocale ,  Session :" . session()->get('locale'));
        } else {
            // redirect to home
            return redirect()->to('/' . config("app.locale"));
        }
        $preUrl =  url()->previous();
        foreach (config("app.locales") as $appLocate) {
            logger()->debug(" returnUrl " . app()->getLocale() . "," . $appLocate . ", - " . var_export($preUrl, true));
            $preUrl = str_replace('/' . $appLocate, '/NewLocate', $preUrl);
            logger()->debug(" check all locates " . app()->getLocale() . "," . $currentLocale . "," . $newLocale . " - " . var_export($preUrl, true));
        }
        logger()->debug(" returnUrl " . $preUrl);
        $preUrl = str_replace('/NewLocate', '/' . $newLocale, $preUrl);
        logger()->debug(" returnUrl " . app()->getLocale() . "," . $currentLocale . "," . $newLocale . " - " . var_export($preUrl, true));
        return redirect()->to($preUrl);
    }
}
