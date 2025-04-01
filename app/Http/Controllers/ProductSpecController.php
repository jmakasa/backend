<?php

namespace App\Http\Controllers;

use App\Models\ProdSpec;
use App\Models\ProdSpecGroups;
use App\Models\CRM_818\ProdSpec818;
use App\Models\CRM_818\ProdSpecGroups818;

use App\Services\ProductService;
use App\Services\HistoryService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use Illuminate\Validation\ValidationException;


class ProductSpecController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['apiProductLists']]);
    }

    public function add_group($locale, Request $request)
    {
        Logger()->debug("add_group  : start " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'group_name_en' => 'required',
                    'group_name_cn' => 'required',
                ],
                [
                    'group_name_en.required' => 'Group name (EN) is required.',
                    'group_name_cn.required' => 'Group name (CN) is required.',
                ]
            );



            $group = (new ProdSpecGroups)
                ->validateAndFill($request->all())
                ->setAttribute('status', 1);

            $aryName['en'] = $request->get('group_name_en');
            $aryName['cn'] = $request->get('group_name_cn');
            $group->group_name_json = $aryName;
            $group->group_name = $request->get('group_name_en');

            // $group818 = (new ProdSpecGroups818)
            //     ->validateAndFill($request->all())
            //     ->setAttribute('status', 1);

            // $aryName['en'] = $request->get('group_name_en');
            // $aryName['cn'] = $request->get('group_name_cn');
            // $group818->group_name_json = $aryName;
            // $group818->group_name = $request->get('group_name_en');

            //if ($group->save() && $group818->save()) {
            if ($group->save()){

                // check 818
                $data818 = ProdSpecGroups818::whereLang($locale)->whereId($group->id)->first();
                if (!$data818) {
                    $data818 = $group->replicate();
                    $data818->setConnection('mysql_818'); 
                    $data818->setTable('akasaweb2021.prod_spec_groups');
                    $data818->id = $group->id;
                    if ($data818->save()) {
                        logger()->debug(" add to 818  : done" . var_export($data818, true));
                       // return true;
                    } else {
                        logger()->error(" FAILED add to 818 $data->id");
                        //return false;
                    }
                } 
                return response()->json(['result' => true, 'data' => $group]);
            } else {
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function getSpecGroupByPartno($locale,  $partno)
    {

        $group = ProdSpecGroups::select("id", "group_name")->where("lang", $locale)->get()->toArray();
        if ($group) {
            return  response()->json($group);
        } else {
            return  response()->json(false);
        }
    }

    public function getChild($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'group_id' => 'required',
                ],
                [
                    'group_id.required' => 'id is required.',
                ]
            );
            Logger()->debug("getChild : start " . var_export($request->all(), true));
            if ($request->get('group_id') == 'all') {
                $data = ProdSpec::select('prod_spec.*', 'pg.group_name')->leftJoin('prod_spec_groups as pg', 'pg.id', '=', 'prod_spec.group_id')
                    ->where('prod_spec.partno', $request->get('partno'))->where('prod_spec.lang', $locale)->get()->toArray();
            } else {
                $data = ProdSpec::select('prod_spec.*', 'pg.group_name')->leftJoin('prod_spec_groups as pg', 'pg.id', '=', 'prod_spec.group_id')
                    ->where('prod_spec.group_id', $request->get('group_id'))->where('prod_spec.partno', $request->get('partno'))->where('prod_spec.lang', $locale)->get()->toArray();
            }
            Logger()->debug("getChild : start " . var_export($data, true));
            if ($data) {

                return response()->json($data);
            } else {
                return response()->json(false);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function getTreeList($locale,  $partno)
    {
        $group = ProdSpec::select('pg.id', 'pg.group_name as text')
            ->leftJoin('prod_spec_groups as pg', 'pg.id', '=', 'prod_spec.group_id')
            ->where("prod_spec.partno", $partno)
            ->where("prod_spec.lang", $locale)->whereNotNull('pg.group_name')->groupBy('text')->get()->toArray();
        $aryMenu = [
            '0' => [
                'text' => "Content",
            ],
            '1' => [
                'text' => "Spec Html",
            ],
            '2' => [
                'text' => "ALL Spec",
                'id' => 'all'
            ]
        ];
        if ($group) {
            $aryMenu[2]['children'] = $group;

            return  response()->json($aryMenu);
        } else {
            return  response()->json($aryMenu);
        }
    }

    public function updateIsHighlight($locale, Request $request)
    {

        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                    'partno' => 'required',
                ],
                [
                    'partno.required' => 'Partno is required.',
                    'id.required' => 'ID is required.',
                ]
            );
            $historyService = new HistoryService;
            $data = ProdSpec::whereLang($locale)->where("partno", $request->get('partno'))->whereId($request->get('id'))->first();
            $data->is_highlight = $request->get('is_highlight');

            // $data818 = ProdSpec818::whereLang($locale)->where("partno", $request->get('partno'))->whereId($request->get('id'))->first();
            // $data818->is_highlight = $request->get('is_highlight');
            // log history if has been changed
            if ($data->isDirty()) {
                foreach ($data->getDirty() as $key => $value) {
                    $historyService->addProductsChangeLogs($data->id, $data->partno, $data->getTable(), $key, $data->getOriginal($key), $value, 'change', $request->get('username'));
                }
            }

           // if ($data->save() && $data818->save()) {
            if ($data->save() ) {
                return response()->json($data);
            } else {
                // TODO:: return and said no this partno
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function updateSpec($locale, Request $request)
    {

        try {
            $this->validate(
                $request,
                [
                    'partno' => 'required',
                ],
                [
                    'partno.required' => 'Partno is required.',
                ]
            );
            $historyService = new HistoryService;
            Logger()->debug(" updateSpec : locale " . var_export($locale, true));
            Logger()->debug(" updateSpec : request " . var_export($request->all(), true));

            $data = ProdSpec::whereLang($locale)->where("partno", $request->get('partno'))->whereId($request->get('id'))->first();
           // $data818 = ProdSpec818::whereLang($locale)->where("partno", $request->get('partno'))->whereId($request->get('id'))->first();
            
         //   if ($data && $data818) {
            if ($data) {
                Logger()->debug(" updateSpec : data " . var_export($data->id, true));
         //       Logger()->debug(" updateSpec : data818 " . var_export($data818->id, true));
                $data->group_id = $request->get('group_id');
                $data->specgroup = $request->get('group_name');
                $data->specname = $request->get('specname');
                $data->specdesc = $request->get('specdesc');
                $data->is_highlight = $request->get('is_highlight');
                $data->updated_by = $request->get('username');
                $data->seqno = $request->get('seqno');
                // $data818


                // log history if has been changed
                if ($data->isDirty()) {
                    foreach ($data->getDirty() as $key => $value) {
                        $historyService->addProductsChangeLogs($data->id, $data->partno, $data->getTable(), $key, $data->getOriginal($key), $value, 'change', $request->get('username'));
                    }
                }

                //if ($data->save() && $data818->save()) {
                if ($data->save()) {
                    Logger()->debug(" updateSpec : data save " . var_export($data, true));

                    // save copy to 818
                    // check 818
                    $data818 = ProdSpec818::whereLang($locale)->where("partno", $request->get('partno'))->whereId($request->get('id'))->first();
                    if (!$data818) {
                        $data818 = $data->replicate();
                        $data818->setConnection('mysql_818'); 
                        $data818->setTable('akasaweb2021.prod_spec');
                        $data818->id = $data->id;
                    } else {

                        $data818->group_id = $request->get('group_id');
                        $data818->specgroup = $request->get('group_name');
                        $data818->specname = $request->get('specname');
                        $data818->specdesc = $request->get('specdesc');
                        $data818->is_highlight = $request->get('is_highlight');
                        $data818->updated_by = $request->get('username');
                        $data818->seqno = $request->get('seqno');
                    }

                    if ($data818->save()) {
                        logger()->debug(" add to 818  : done" . var_export($data818, true));
                       // return true;
                    } else {
                        logger()->error(" FAILED add to 818 $data->id");
                        //return false;
                    }


                    return response()->json($data);
                } else {
                    // TODO:: return and said no this partno
                }
            } else {
                
                // create 
                $specData = $request->only('seqno','partno','group_id','specgroup','specname','specdesc','is_highlight');
                $specData['lang'] = $locale;
                $specData['created_by'] = ($request->has('username') ? $request->get('username') : 'SYSTEM');
                $specData['updated_by'] = ($request->has('username') ? $request->get('username') : 'SYSTEM');

                Logger()->debug(" updateSpec : create ".var_export($specData,true));

                if ($data = ProdSpec::create($specData) && ProdSpec818::create($specData)) {
                    return response()->json($data);
                } else {
                    // TODO:: return and said no this partno
                }
            } 
            
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    
    // $history = $data->replicate();
    // $history->setTable($historyTable);
    // $history->id = $id;
    // $history->log_action = $action;
    // $history->logged_by = $name;
    // $history->logged_at = $this->currentDatetime;

    // if ($history->save()) {
}
