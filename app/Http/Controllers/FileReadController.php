<?php

namespace App\Http\Controllers;

// use App\Models\CrmAccounts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Models\Mbcheck;
use App\Models\MbcheckProdlist;
use App\Models\OemDcfanList;

use App\Services\FileService;

use App\Imports\MbcheckImports;
use App\Imports\OemFan\OemFanlistImports;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Carbon\Carbon;


class FileReadController extends Controller
{

    protected $title;
    protected $module;
    public function __construct()
    {

        //   $this->middleware('auth', ['except' => ['getTaskFormSettings','getTaskList']]);
        $this->middleware('jwt.verify', ['except' => ['getContactList','exportOemDcfanJson','importOemFanlist']]);
        $this->title = "Amz Selling Partner API | Backend";
    }

    public function importOemFanlist($locale, $filename)
    {
        try {
            $file = public_path() . "/" . $filename;

            if (file_exists($file)) {
                ini_set('max_execution_time', 1800);
                ini_set('memory_limit', '256M');
                Logger()->debug(" importRMAData : has file - $file");

                $aryData = Excel::toArray(new MbcheckImports(), $file);
                //  dd($aryData);
                $arySheets = ['FAN', 'BLOWER', 'Micro Fan', 'Micro Blower'];
                foreach ($aryData as $key => $data) {

                    $type = $arySheets[$key];
                    foreach (array_slice($data, 1) as $d) {
                        OemDcfanList::firstOrCreate(
                            [
                                'type' =>     $type,
                                'model' =>     $d[1],
                            ],
                            [
                                'series' => $d[0],
                                'size' =>     $d[2],
                                'depth' =>     $d[3],
                                'bearing' => $d[4],
                                'voltage' => $d[5],
                                'current' => $d[6],
                                'power_consumption' => $d[7],
                                'rated_speed' =>     $d[8],
                                'airflow' => $d[9],
                                'air_pressure' => $d[10],
                                'noise_level' => $d[11],
                                'weight' => $d[12],
                                'created_by' => 'Justin'
                            ]
                        );
                    }
                }
            }
        } catch (Exception $e) {
            Logger()->error(" importOemFanlist : error - " . var_export($e->getMessage(), true));
            return response()->json($e->getMessage());
        } catch (ValidationException $ex) {
            Logger()->error(" importOemFanlist : ValidationException - " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    /***
     *  import file to be handle,
     * insert or update stock data
     */
    public function importMbcheckData($locale)
    {
        try {
            // $this->validate(
            //     $request,
            //     $this->validateImportFile()['rules'],
            //     $this->validateImportFile()['ruleMessages']
            // );
            // Logger()->debug(" importRMAData : request - " . var_export($request->all(), true));
            //       $user = $request->get('userInfo');
            $file = public_path() . '/mbcheck.xlsx';

            if (file_exists($file)) {
                ini_set('max_execution_time', 1800);
                ini_set('memory_limit', '256M');
                Logger()->debug(" importRMAData : has file - $file");

                // call collection to insert or update
                $aryData = Excel::toArray(new MbcheckImports(), $file);


                foreach (array_slice($aryData[0], 1) as $data) {

                    // dd($data);
                    $mbcheck = Mbcheck::where("plateform", $data[0])
                        ->where("processor", $data[1])
                        ->where("manufacturer", $data[2])
                        ->where("productline", $data[3])
                        ->where("productname", $data[4]);
                    if ($data[5]) {
                        $mbcheck->where("familyname", $data[5]);
                    }

                    if ($data[6]) {
                        $mbcheck->where("modelname", $data[6]);
                    }

                    $mb =    $mbcheck->first();

                    if ($mbcheck) {
                        for ($i = 7; $i < 14; $i++) {
                            if ($data[$i]) {
                                echo "<pre>";
                                print_r($mb->id);
                                echo "</pre>";

                                echo "<pre>";
                                print_r($data[$i]);
                                echo "</pre>";
                                $idata = [];
                                $idata['productcode'] = $data[$i];
                                $idata['mbcheck_id'] = $mb->id;
                                MbcheckProdlist::firstOrCreate(
                                    $idata,
                                    ['created_by' => 'Justin']
                                );
                            }
                        }
                    }
                }
                echo "DONE";
            } else {
                Logger()->error(" importRMAData : NO file - $file");
                return response()->json(['result' => false, 'data' => 'no file']);
            }
        } catch (Exception $e) {
            Logger()->error(" importRMAData : error - " . var_export($e->getMessage(), true));
            return response()->json($e->getMessage());
        } catch (ValidationException $ex) {
            Logger()->error(" importRMAData : ValidationException - " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    public function exportFanlessCaseCheckConf($locale, FileService $fileService)
    {
        //leftJoin('products as p', 'p.partno', '=', 'prodlist_boxes.productcode');
        $data = [];
        $data['productlist'] = MbcheckProdlist::leftJoin("mbcheck as m", "mbcheck_prodlist.mbcheck_id", "=", "m.id")
            ->leftJoin("products as p", "mbcheck_prodlist.productcode", "=", DB::raw('p.partno COLLATE utf8mb4_general_ci'))
            ->leftJoin("images as i", DB::raw('i.partno COLLATE utf8mb4_general_ci'), "=", DB::raw('p.partno COLLATE utf8mb4_general_ci'))
            ->select(
                "mbcheck_prodlist.productcode",
                "p.pstatus",
                "p.name",
                "p.title",
                "m.plateform",
                "m.processor",
                "m.manufacturer",
                "m.productline",
                "m.productname",
                "m.familyname",
                "m.modelname",
                "i.docname",
                "i.docdir",
            )
            ->where("p.lang", "en")->where("i.lang", "en")->where("i.listpic", 1)->where("i.ctype", 'gallery')->get();
        $data['plateform'] = Mbcheck::select("plateform")->groupBy('plateform')->get();
        $data['processor'] = Mbcheck::select("plateform", "processor")->groupBy('processor')->get();
        $data['mbchecklist'] = Mbcheck::select("plateform", "processor", "manufacturer", "productline", "productname", "familyname", "modelname")->get();
        //    $data['processor'] = Mbcheck::select("plateform","processor","manufacturer")->groupBy('processor')->get();
        // dd($data->toArray());

        return $fileService->createConf(FileService::TYPE_FCCHECK, 'fanless_case_check.conf', $locale,  "[mbcheck]\nmbcheckdata=" . json_encode($data));
        dd($result);
    }

    public function exportOemDcfanJson($locale, FileService $fileService)
    {
        //leftJoin('products as p', 'p.partno', '=', 'prodlist_boxes.productcode');
        $data = [];
        $data['fan_list'] = OemDcfanList::where("type","FAN")->orderBy("model","asc")->get();
        $data['blower_list'] = OemDcfanList::where("type","BLOWER")->orderBy("model","asc")->get();
        $data['micro_list'] = OemDcfanList::where("type","Micro Fan")->orWhere("type","Micro Blower")->orderBy("model","asc")->get();
// dd($data);

        return $fileService->createConf(FileService::TYPE_OEMDCFANLIST, 'oem_dcfan.json', $locale,  json_encode($data));
        dd($result);
    }
}
