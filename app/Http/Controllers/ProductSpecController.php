<?php

namespace App\Http\Controllers;

use App\Models\ProdSpec;
use App\Models\ProdSpecGroups;

use App\Services\ProductService;

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

                
            if ($group->save()) {
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

        $group = ProdSpecGroups::select("id","group_name")->where("lang", $locale)->get()->toArray();
        if ($group){
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
            if ($request->get('group_id') == 'all'){
                $data = ProdSpec::select('prod_spec.*','pg.group_name')->leftJoin('prod_spec_groups as pg', 'pg.id', '=', 'prod_spec.group_id')
            ->where('prod_spec.partno', $request->get('partno'))->where('prod_spec.lang', $locale)->get()->toArray();
            } else {
                $data = ProdSpec::select('prod_spec.*','pg.group_name')->leftJoin('prod_spec_groups as pg', 'pg.id', '=', 'prod_spec.group_id')
            ->where('prod_spec.group_id', $request->get('group_id'))->where('prod_spec.partno', $request->get('partno'))->where('prod_spec.lang', $locale)->get()->toArray();
            }
            Logger()->debug("getChild : start " . var_export($data, true));
            if ($data){
                
                return response()->json($data);
            } else {
                return response()->json(false);
            }
            
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function getTreeList($locale,  $partno){
        $group = ProdSpec::select('pg.id', 'pg.group_name as text')
        ->leftJoin('prod_spec_groups as pg', 'pg.id', '=', 'prod_spec.group_id')
        ->where("prod_spec.partno",$partno)
        ->where("prod_spec.lang",$locale)->whereNotNull('pg.group_name')->groupBy('text')->get()->toArray();
        $aryMenu = [
            '0'=> [
              'text' => "Content",
            ],
            '1' => [
              'text' => "Spec Html",
            ],
            '2' => [
              'text' => "ALL Spec",
              'id'=>'all'
            ]
            ];
        if ($group){
            $aryMenu[2]['children'] = $group;
            
            return  response()->json($aryMenu);
        } else {
            return  response()->json($aryMenu);
        }
        

    }
}
