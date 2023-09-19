<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\WebProducts;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;


class MigrateController extends Controller
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
        ini_set('max_execution_time', 300);
        $this->middleware('auth', ['except' => ["index"]]);
        $this->category = Category::whereStatus("Active")->whereNull('parent_id')->get()->sortBy('seq');
        $this->lang = [
            "en" => "English",
            //"tw" => "繁體中文",
            "cn" => "简体中文",
            "fr" => "French",
            "de" => "German",
            "es" => "Spanish",
            "pt" => "Portuguese",
        ];
    }


    public function doProducts($partno = null)
    {
        
        logger()->debug(" doProducts ");
        // get all products group by partno
        // get products details
        //$oldProducts = Products::select('partno')->groupBy('partno')->limit(5)->having(DB::raw('count(1)'), '>', 1)->get()->toArray();
        if ($partno) {
            $oldProducts = Products::select('partno')->first();
        } else {
            $oldProducts = Products::select('partno')->groupBy('partno')->get()->toArray();
        }


        Logger()->debug(" doProducts : oldProducts " . var_export($oldProducts, true));
        //  Logger()->debug(" doProducts : ". var_export(count($oldProducts), true));
        $elements = ['keywords', 'fankeywords', 'extrakeywords', 'name', 'title', 'shortdesc', 'shortdesc1', 'shortdesc2', 'longdesc', 'introduction'];
        //  $elements = ['keywords', 'fankeywords', 'extrakeywords', 'name'];
        $web_available = ['eol', 'eol_date', 'eol_date', 'active', 'pstatus'];
        $web_settings = ['iscooler', 'newproduct', 'upcoming', 'specialtemplate', 'detailtoppanel', 'detailtoppanelbgl',  'detailtoppanelbgr', 'plistflag',  'pdetailflag', 'displaypartnoline'];

        foreach ($oldProducts as $p) {
            foreach ($this->lang as $lang => $value) {
                Logger()->debug(" doProducts : lang >> " . var_export($lang, true));
                $dataInLang = Products::where([
                    ["partno", $p],
                    ["lang", $lang]
                ])->first();
                if ($dataInLang) {

                    $aryData = $dataInLang->toArray();

                    foreach ($elements as $e) {
                        //     Logger()->debug(" doProducts : e " . var_export($e, true));
                        $aryNewDataForm[$e][$lang] = $aryData[$e];
                    }
                    //   Logger()->debug(" doProducts : aryData >> " . var_export($aryNewDataForm, true));
                }
            }


            // get one record
            $insertData = Products::where([
                ["partno", $p],
            ])->first()->toArray();
            foreach ($aryNewDataForm as $key => $newData) {
                $insertData[$key] = json_encode($newData, true);
            }
            $webSettings = [];
            foreach ($web_settings as $setting) {
                $webSettings[$setting] = $insertData[$setting];
            }
            $webAvailable = [];
            foreach ($web_available as $available) {
                $webAvailable[$available] = $insertData[$available];
            }
            $insertData['web_settings'] = json_encode($webSettings);
            $insertData['web_available'] = json_encode($webAvailable);
            $insertData['type'] = "Main";
            $insertData['status'] = 'Active';

            $checkProduct = WebProducts::where('partno', $insertData['partno'])->first();

            if ($checkProduct !== null) {
                $checkProduct->update($insertData);
            } else {
                $newWebProduct = (new WebProducts)->fill($insertData);
                $newWebProduct->save();
            }


            //  
            // $newWebProduct = WebProducts::updateOrCreate(
            //     $insertData
            // );
        }
    }
}
