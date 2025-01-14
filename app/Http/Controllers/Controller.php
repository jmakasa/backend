<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    
    /**
     * assign default value if the value = null
     */
    public function assignDefaultValue($defaultValue, $data)
    {
        $collection = collect($data);
        return $collection->map(function ($value, $key) use ($defaultValue) {
            return ($value ? $value : $defaultValue);
        });
    }

    /**
     * map value show locale only
     */
    public function mapLocaleValues($filterKey, $data){
        // $data is collection
        $locale = app()->getLocale();
             return $data->map(function ($value, $key) use ($filterKey, $locale) {
              $aryDataReturn = [];
                 foreach ($filterKey as $fKey){
                     if (isset($value->$fKey[$locale])){
                         $aryDataReturn[$fKey] = $value->$fKey[$locale];
                     } else {
                         $aryDataReturn[$fKey] = $value->$fKey;
                     }
                 }
                 return $aryDataReturn;
             });
     
         }

         /**
          * for simple checking login
          */
          public function hasLoginFromMarketing(){
            if (isset($_SESSION["username"])) {
                return $_SESSION["username"];
            } else {
                return false;
            }
          }
          public function loginUser(){
            return [
                'username'=> (isset($_SESSION["username"]) ? $_SESSION["username"]: 'SYS'),
                'email'=>(isset($_SESSION["email"]) ? $_SESSION["email"]: 'EMAIL'),
                'userid'=>(isset($_SESSION["userid"]) ? $_SESSION["userid"]: 0),
            ];
          }

              /**
     * essential validation
     */
    public function validateId()
    {
        return [
            'rules' => [
                'id' => 'required',
            ],
            'ruleMessages' => [
                'id.required' => 'ID is required.',
            ],
        ];
    }
    public function cleanStr($string){
        // Replaces all spaces with hyphens.
        $string = str_replace(' ', '-', $string);
    
        // Removes special chars.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        // Replaces multiple hyphens with single one.
        $string = preg_replace('/-+/', '-', $string);
        
        return $string;
    }

    public function backupData($id,$bdata, $action, $tablename)
    {
        logger()->error(" Controller : backupData " . var_export($bdata, true));
        $bdata->bck_date = now();
        $bdata->action = $action;
        $bdata->setTable($tablename);
        $bdata->id = $id;
        return $bdata->save();
    }
}
