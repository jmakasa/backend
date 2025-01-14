<?php

namespace App\Http\Controllers;

use App\Models\TopSalesQty;
use App\Services\FileService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use Illuminate\Validation\ValidationException;


class SalesRecordsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['apiProductLists']]);
    }

    
    /***
     * receive the ecommerce url
     * acct name, acct id, name, url , img
     */
    public function updateTopSalesQty($locale, Request $request, FileService $fileService)
    {
        logger()->debug(" SalesRecordsController : updateTopSalesQty ");
        try {
            $aryQty =  json_decode($request->get('sales_qty'));
            $updated = [];
            $noChange = [];
            foreach ($aryQty as $data){
                logger()->debug(" SalesRecordsController : updateTopSalesQty data" . var_export($data, true));
                $updateOrCreate = TopSalesQty::updateOrCreate(
                    [
                        'account_ref' => $data->account_ref,
                        'productcode' => $data->productcode,
                    //    'year' => $data->year,
                    ],
                    [
                        'company_name' => $data->name,
                        'jan' => $data->jan,
                        'feb' => $data->feb,
                        'mar' => $data->mar,
                        'apr' => $data->apr,
                        'may' => $data->may,
                        'jun' => $data->jun,
                        'jul' => $data->jul,
                        'aug' => $data->aug,
                        'sept' => $data->sept,
                        'oct' => $data->oct,
                        'nov' => $data->nov,
                        'dec' => $data->dec,
                        'tot' => $data->tot,
                        'status' => $data->status,
                        // 'created_by' => $user['name'],
                        // 'updated_by' => $user['name'],
                    ]
                );
                if ($updateOrCreate){
                   // logger()->debug(" SalesRecordsController : updateTopSalesQty updateOrCreate" . var_export($updateOrCreate, true));
                    $updated[] = $updateOrCreate->productcode;
                } else {
                    $noChange[] = $data->productcode;
                }
            }
            

            
            
            return response()->json(['result'=> true,'updated'=> $updated,'noChange'=> $noChange ]);

        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function getQtyList($locale, Request $request)
    {
        try {
            Logger()->debug(" getQtyList : request - " . var_export($request->all(), true));
            $sort = $request->has('sort') ? $request->get('sort') : 'productcode';
            $order = $request->has('order') ? $request->get('order') : 'desc';
            $page = $request->has('page') ? $request->get('page') : 1;
            $rows = $request->has('rows') ? $request->get('rows') : 20;
            $skip = ($page - 1) * $rows;
            //invoice_item.
            $data = TopSalesQty::orderBy($sort, $order);

            if ($request->has('account_ref')) {
                $data->where("account_ref", $request->get('account_ref'));
            }

            if ($request->has('productcode') && $request->get('productcode')) {
                if ($request->has('match_case') && $request->get('match_case') == 'true') {
                    $data->where("productcode", $request->get('productcode'));
                } else {
                    $data->where("productcode", 'like', '%' . $request->get('productcode') . "%");
                }
            }

            $result['total'] = $data->get()->count();
            $result['rows'] = $data->skip($skip)->take($rows)->get()->toArray();
            // }
            return response()->json($result);
        } catch (Exception $e) {
            Logger()->error(" getQtyList : error - " . var_export($e->getMessage(), true));
            return response()->json($e->getMessage());
        }
    }

}
