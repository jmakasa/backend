<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\OldprodlistBox;
use App\Models\ProdlistBoxes;

use App\Services\ProductService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use Illuminate\Validation\ValidationException;

class ProductRelatedBoxesController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['apiProductLists']]);
    }


    public function getBoxDataByBoxno($boxno, $locale, $offset, $rows, $returnType = 'JSON')
    {
        $boxData = DB::table('prodlist_boxes as pb')
            ->select('pb.productcode AS partno', 'pb.boxno', 'm.submenu')
            ->leftJoin('2022_navmenu as m', function ($join) {
                $join->on('m.id', '=', 'pb.menucat');
            })
            ->where('pb.boxno', $boxno)
            ->where('pb.lang', $locale)
            ->orderBy("pb.seqno");
            
            if ($offset){
                $boxData->skip($offset);
            }
            if ($rows){
                $boxData->limit($rows);
            }

            $boxData->get();
        if ($returnType == 'ARRAY') {
            return $boxData->toArray();
        } else {
            return response()->json(['result' => true, 'data' => $boxData]);
        }
    }

    public function getBoxDataByMenucat($menucat, $locale, $offset, $rows, $returnType="DATA")
    {
        Logger()->error(" apiBoxData : request DATA - $menucat, $locale, $offset, $rows, $returnType");
        $boxData = DB::table('prodlist_boxes as b')
            ->select('b.id as bId', 'b.boxno' ,  'b.menucat as menucat','p.id as product_id', 'p.partno as text','b.seqno as seqno','b.box_seqno as box_seqno', 
            'p.partno AS partno','b.box_name', 'b.status', 'p.lang', 'p.title', 'p.longdesc', 'p.name' , 'p.pstatus as pstatus', 'p.eol_comment')
            ->leftJoin('2022_navmenu as m', function ($join) {
                
                $join->whereRaw('m.id = b.menucat COLLATE utf8mb4_unicode_ci');
            })
            ->leftJoin('products as p', function ($join) {
                $join->whereRaw('p.partno = b.productcode COLLATE utf8mb4_unicode_ci');
            })
            ->whereRaw("b.menucat = '".$menucat."' COLLATE utf8mb4_unicode_ci")
            
            ->where('p.lang', $locale)
            ->orderBy("b.seqno");

            if ($offset){
                $boxData->skip($offset);
            }
            if ($rows){
                $boxData->limit($rows);
            }

        if ($returnType == 'ARRAY') {
            return $boxData->get()->toArray();
        } else if ($returnType == 'JSON') {
            return response()->json(['result' => true, 'data' => $boxData->get()]);
        } else {
            return $boxData->get();
        }
    }

    public function apiBoxData(Request $request)
    {

        Logger()->error(" apiBoxData : request DATA - " . var_export($request->all(), true));
        if ($request->get('boxno') && $request->get('lang')) {
            if ($request->get('webmenu') == "old") {
                // insert into oldprodlist_box 
                //   $pl_table = " oldprodlist_box ";
                $boxData = OldprodlistBox::where('boxno', $request->get('boxno'))
                    ->where('lang', $request->get('lang'))
                    ->where('menucat', strval(sprintf("%04d", $request->get('menucat'))))
                    ->groupBy("boxno")
                    ->first();
            } else {
                // insert into new prodlist_box 
                //    $pl_table = " prodlist_boxes ";
                $boxData = ProdlistBoxes::where('boxno', $request->get('boxno'))->where('lang', $request->get('lang'))
                    ->where('menucat', strval(sprintf("%04d", $request->get('menucat'))))
                    ->groupBy("boxno")
                    ->first();
            }
            return response()->json(['result' => true, 'data' => $boxData]);
        } else {
            Logger()->error(" apiBoxData : FAILED : request DATA - " . var_export($request->all(), true));
            return response()->json(['result' => false]);
        }
    }

    public function apiUpdateBox(Request $request)
    {
        Logger()->error(" apiBoxData : request DATA - " . var_export($request->all(), true));
        if ($request->get('boxno') && $request->get('lang')) {
            if ($request->get('webmenu') == "old") {
                // insert into oldprodlist_box 
                //   $pl_table = " oldprodlist_box ";
                $boxData = OldprodlistBox::whereId($request->get('id'))->first();
            } else {
                // insert into new prodlist_box 
                //    $pl_table = " prodlist_boxes ";
                $boxData = ProdlistBoxes::whereId($request->get('id'))->first();
            }
            $boxData->box_name = $request->input("box_name");

            $boxData->box_seqno = $request->input("box_seqno");
            if ($boxData->status != $request->input("status")) {
                $boxData->status = $request->input("status");
                // and update all boxes
                if ($request->get('webmenu') == "old") {
                    //Post::where('id',3)->update(['title'=>'Updated title']);
                    OldprodlistBox::where('boxno', $request->get('boxno'))->update(['status' => $request->input("status")]);
                } else {
                    ProdlistBoxes::where('boxno', $request->get('boxno'))->update(['status' => $request->input("status")]);
                }
            }
            if ($boxData->save()) {
                logger()->debug(" boxData - update data : SAVED" . var_export($request->all(), true));
                return response()->json(['result' => true, 'data' => $boxData]);
            } else {
                logger()->error(" boxData - update data : NO inserted" . var_export($request->all(), true));
                return response()->json(['result' => false]);
            }
        } else {
            Logger()->error(" apiUpdateBox : FAILED : request DATA - " . var_export($request->all(), true));
            return response()->json(['result' => false]);
        }
    }

    public function apiUpdateProductStatus(Request $request, ProductService $producService)
    {
        Logger()->debug("apiUpdateProductStatus " . var_export($request->all(), true));

        if ($request->get('webmenu') == "old") {
            // insert into oldprodlist_box 
            //   $pl_table = " oldprodlist_box ";
            $box = OldprodlistBox::whereId($request->get('boxid'))->first();
        } else {
            // insert into new prodlist_box 
            //    $pl_table = " prodlist_boxes ";
            $box = ProdlistBoxes::whereId($request->get('boxid'))->first();
        }
        $box->status = $request->get('status');
        $box->seqno = $request->get('seqno');


        // call productsCtrl to update pstatus
        $updatePstatus = $producService->updatePstatus($request->get('id'), $request->get('pstatus'), $request->get('new_pstatus'), $request->get('eol_comment'));

        if ($box->save() && $updatePstatus) {
            logger()->debug(" apiUpdateProductStatus - update data : SAVED" . var_export($request->all(), true));
            return response()->json(['result' => true, 'data' => $box]);
        } else {
            logger()->error(" apiUpdateProductStatus - update data : NO inserted" . var_export($request->all(), true));
            return response()->json(['result' => false]);
        }
    }

    public function addProductToBox(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'product_id' => 'required',
                    'target_boxno' => 'required',
                    'menucat' => "required",
                    'webmenu' => "required"
                ],
                [
                    'partno.required' => 'partno is required.',
                    'product_id.required' => 'product_id is required.',
                    'menucat.required' => 'menucat is required.',
                    'webmenu.required' => 'webmenu is required.',
                ]
            );
            Logger()->debug("addProductToBox : start " . var_export($request->all(), true));
            //if ($_POST['product_id'] && $_POST['target_boxno']) {
            if ($request->get('webmenu') == "old") {
                // insert into oldprodlist_box 
                //   $pl_table = " oldprodlist_box ";
                $newBox = new OldprodlistBox;
                $boxData = OldprodlistBox::where('lang', $request->get('lang'))
                    ->where('menucat', strval(sprintf("%04d", $request->get('menucat'))));
            } else {
                // insert into new prodlist_box 
                //    $pl_table = " prodlist_boxes ";
                $newBox = new ProdlistBoxes;
                $boxData = ProdlistBoxes::where('lang', $request->get('lang'))
                    ->where('menucat', strval(sprintf("%04d", $request->get('menucat'))));
                // find the max seqno in this menucat
                $getMaxBoxSeqno = ProdlistBoxes::where('menucat', strval(sprintf("%04d", $request->get('menucat'))))->max("box_seqno");
                $newBoxSeqno = strval(sprintf("%04d", $getMaxBoxSeqno + 1));
                logger()->debug(" addProductToBox - getMaxId : " . var_export($newBoxSeqno, true));
            }
            if ($request->get('target_boxno') == 'NEW') {
                //where('boxno', $request->get('boxno'))->
                // create new record
                $newBox->boxno = mt_rand(1, 999);
                $newBox->product_id = $request->get('product_id');
                $newBox->productcode = $request->get('partno');
                $newBox->lang = $request->get('lang');
                $newBox->menucat = sprintf("%04d", $request->get('menucat'));
                $newBox->box_seqno = $newBoxSeqno;
                $newBox->seqno = '0000';
            } else {
                //where('boxno', $request->get('boxno'))->
                // duplicate record
                $targetBox = $boxData->where('boxno', $request->get('target_boxno'))->first();
                logger()->debug(" addProductToBox - duplicate record" . var_export($targetBox, true));
                $newBox = $targetBox->replicate();
                $newBox->product_id = $request->get('product_id');
                $newBox->productcode = $request->get('partno');
                $newBox->seqno = sprintf("%04d", (int)$newBox->seqno + 1);
                $newBox->created_at = Carbon::now();
            }
            if ($newBox->save()) {
                logger()->debug(" addProductToBox - insert data : SAVED" . var_export($request->all(), true));
                return response()->json(['result' => true, 'data' => $newBox]);
            } else {
                logger()->error(" addProductToBox - insert data : NO inserted" . var_export($request->all(), true));
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function removeProductFromBox(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                    'webmenu' => 'required',
                ],
                [
                    'id.required' => 'id is required.',
                    'webmenu.required' => 'webmenu is required.',
                ]
            );
            Logger()->debug("removeFromBox : start " . var_export($request->all(), true));
            if ($request->get('webmenu') == "old") {
                return response()->json(['result' => OldprodlistBox::whereId($request->get('id'))->firstOrfail()->delete()]);
            } else {
                return response()->json(['result' => ProdlistBoxes::whereId($request->get('id'))->firstOrfail()->delete()]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }
}
