<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\OldprodlistBox;
use App\Models\ProdlistBoxes;
use App\Models\ProductRelatedBoxes;
use App\Models\Images;

use App\Services\ProductService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use Illuminate\Validation\ValidationException;

class ProductBoxesController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['apiProductLists']]);
    }

    public function getBoxDataWithImage($locale, $boxes)
    {
        logger()->debug(" getBoxDataWithImage : all boxno " . var_export($boxes, true));
        $returnData['boxes'] = [];
        $hasImage = false;
        $cnt = 0;
        $aryPartno = [];
        foreach ($boxes as $boxno) {
            // get box with feature image
            // logger()->debug(" showOne : boxno " . var_export($boxno, true));
            $boxData = DB::table('prodlist_boxes as pb')
                ->select('pb.productcode AS partno', 'pb.boxno', 'm.submenu')
                ->leftJoin('2022_navmenu as m', function ($join) {
                    $join->on('m.id', '=', 'pb.menucat');
                })
                ->where('pb.boxno', $boxno['boxno'])
                ->where('pb.menucat', $boxno['menucat'])
                ->where('pb.lang', $locale)
                ->orderBy("pb.seqno")
                ->get()->toArray();
                
            foreach ($boxData as $key => $d) {
              //  $aryImage = Images::select('partno', 'docdir', 'docname', 'ctype')->where("partno", $d->partno)->where("ctype", "gallery")->where('docname', 'not like', "%_g00%")->where("docname", 'like', '%g0%')->orderBy("seqno")->first()->toArray();
              $aryImage = Images::select('partno', 'docdir', 'docname', 'ctype')->where("partno", $d->partno)->where("ctype", "gallery")->where('listpic',1)->first()->toArray();
if (!in_array($d->partno,$aryPartno)){
    $aryPartno[] = $d->partno;
                $returnData['boxes'][$cnt]['partno'] = $d->partno;
                $returnData['boxes'][$cnt]['boxno'] = $d->boxno;
                $returnData['boxes'][$cnt]['submenu'] = $d->submenu;
                if ($aryImage) {

                    $returnData['boxes'][$cnt]['docdir'] = $aryImage['docdir'];
                    $returnData['boxes'][$cnt]['docname'] = $aryImage['docname'];
                    $returnData['boxes'][$cnt]['ctype'] = $aryImage['ctype'];

                } 
            }
                $cnt++;
            }
        }

        logger()->debug(" getBoxDataWithImage : boxData  " . var_export($returnData, true));
        return $returnData['boxes'];
    }

    public function getRelatedBoxesCard($menucat, $boxno, $locale)
    {
        $hasImage = false;
        // get prodlist_boxes with menucat, boxno , locale
        $boxData = DB::table('prodlist_boxes as pb')
            ->select('pb.productcode AS partno', 'pb.boxno', 'm.submenu')
            ->leftJoin('product as p', function ($join) {
                $join->on('p.partno', '=', 'pb.productcode');
            })
            ->where('pb.menucat', $menucat)
            ->where('pb.boxno', $boxno)
            ->where('pb.lang', $locale)
            ->orderBy("pb.seqno")
            ->get()->toArray();
        foreach ($boxData as $key => $d) {
            
            //$aryImage = Images::select('partno', 'docdir', 'docname', 'ctype')->where("partno", $d->partno)->where("ctype", "gallery")->where('docname', 'not like', "%_g00%")->where("docname", 'like', '%g0%')->first();
            $aryImage = Images::select('partno', 'docdir', 'docname', 'ctype')->where("partno", $d->partno)->where("ctype", "gallery")->where('listpic',1)->first();
           
            if ($aryImage) {
                $hasImage = true;
                $image = $aryImage->toArray();
                if (!$image['docdir']){
                    $image['docdir'] = 'img/product/common/gallery/00/';
                }
                $boxData[$key]->image = $image;
            } else {

                $boxData[$key]->image = [];
            }
        }
        logger()->debug(" getRelatedBoxesCard : boxData " . var_export($boxData, true));
        return $boxData;
    }


    public function getBoxDataByBoxno($menucat, $boxno, $locale, $offset, $rows, $returnType = 'DATA')
    {
        // Logger()->error(" getBoxDataByBoxno : request DATA - $menucat,$boxno, $locale, $offset, $rows, $returnType");
        $boxData = $this->getBoxData(
            [
                'menucat' => $menucat,
                'boxno' => $boxno,
                'locale' => $locale,
                'offset' => $offset,
                'rows' => $rows,
            ]
        );

        if ($returnType == 'ARRAY') {
            return $boxData->get()->toArray();
        } else if ($returnType == 'JSON') {
            return response()->json(['result' => true, 'data' => $boxData->get()]);
        } else {

            return $boxData->get();
        }
    }

    public function getBoxDataByMenucat($menucat, $locale, $offset, $rows, $returnType = "DATA")
    {
        Logger()->error(" getBoxDataByMenucat : request DATA - $menucat, $locale, $offset, $rows, $returnType");
        $boxData = $this->getBoxData(
            [
                'menucat' => $menucat,
                'locale' => $locale,
                'offset' => $offset,
                'rows' => $rows,
            ]
        );

        if ($returnType == 'ARRAY') {
            return $boxData->get()->toArray();
        } else if ($returnType == 'JSON') {
            return response()->json(['result' => true, 'data' => $boxData->get()]);
        } else {
            return $boxData->get();
        }
    }

    private function getBoxData(array $selector)
    {
        //$menucat, $locale, $offset, $rows,$partno
        $boxData = DB::table('prodlist_boxes as b')
            ->select(
                'b.id as bId',
                'b.boxno',
                'b.menucat as menucat',
                'p.id as product_id',
                'p.partno as text',
                'b.seqno as seqno',
                'b.box_seqno as box_seqno',
                'p.partno AS partno',
                'b.box_name',
                'b.status',
                'p.lang',
                'p.title',
                'p.longdesc',
                'p.name',
                'p.pstatus as pstatus',
                'p.eol_comment'
            )
            ->leftJoin('2022_navmenu as m', function ($join) {

                $join->whereRaw('m.id = b.menucat COLLATE utf8mb4_unicode_ci');
            })
            ->leftJoin('products as p', function ($join) {
                $join->whereRaw('p.partno = b.productcode COLLATE utf8mb4_unicode_ci');
            })
            ->where('p.lang', $selector['locale'])
            ->orderBy("b.seqno");

        // other selections
        if (isset($selector['menucat']) && $selector['menucat']) {
            if (is_array($selector['menucat'])) {
                // $collate = " COLLATE utf8mb4_unicode_ci ";
                $collate = "";
                $arry = implode(" $collate ,", $selector['menucat']);
                $boxData->whereRaw("b.menucat in ($arry $collate)");
                // $boxData->whereIn('b.menucat', [$selector['menucat']]);
            } else {
                $boxData->where('b.menucat', $selector['menucat']);
            }
        }
        if (isset($selector['partno']) && $selector['partno']) {
            $boxData->where('b.productcode', $selector['partno']);
        }
        if (isset($selector['boxno']) && $selector['boxno']) {
            if (is_array($selector['boxno'])) {
                Logger()->debug("getBoxData : is_array " . var_export($selector['boxno'], true));
                $boxData->whereIn('b.boxno', $selector['boxno']);
            } else {
                $boxData->where('b.boxno', $selector['boxno']);
            }
        }

        if (isset($selector['offset']) && $selector['offset']) {
            $boxData->skip($selector['offset']);
        }
        if (isset($selector['rows']) && $selector['rows']) {
            $boxData->limit($selector['rows']);
        }

        return $boxData;
    }

    public function addRelatedBoxes($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'partno' => 'required',
                    'menucat' => 'required',
                    'boxno' => "required"
                ],
                [
                    'partno.required' => 'partno is required.',
                    'menucat.required' => 'menucat is required.',
                    'boxno.required' => 'boxno is required.',
                ]
            );
            Logger()->debug("addRelatedBoxes : start " . var_export($request->all(), true));
            //if ($_POST['product_id'] && $_POST['target_boxno']) {
            // find the max seqno in this menucat
            $getMaxBoxSeqno = ProductRelatedBoxes::where('menucat', strval(sprintf("%04d", $request->get('menucat'))))->where("partno", $request->get('partno'))->max("seqno");
            $newBoxSeqno = strval(sprintf("%04d", $getMaxBoxSeqno + 10)); // handle seqno + 1

            // find record or create new record
            $newRelatedBoxes = ProductRelatedBoxes::firstOrNew(
                // find the record by this
                [
                    'boxno' => $request->get('boxno'),
                    'lang' => $locale,
                    'partno' => $request->get('partno'),
                    'menucat' => sprintf("%04d", $request->get('menucat')),
                ], // create with these attributes
                ['status' => 1, 'seqno' => $newBoxSeqno]
            );

            // create new record


            if ($newRelatedBoxes->save()) {
                logger()->debug(" addRelatedBoxes - insert data : SAVED" . var_export($request->all(), true));
                return response()->json(['result' => true, 'data' => $newRelatedBoxes]);
            } else {
                logger()->error(" addRelatedBoxes - insert data : NO inserted" . var_export($request->all(), true));
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function removeRelatedBoxes($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                ['boxno' => 'required', 'menucat' => 'required', 'lang' => 'required', 'partno' => 'required'],
                [
                    'boxno.required' => 'boxno is required.',
                    'menucat.required' => 'menucat is required.',
                    'lang.required' => 'lang is required.',
                    'partno.required' => 'partno is required.',
                ]
            );
            Logger()->debug("removeRelatedBoxes : start " . var_export($request->all(), true));

            return response()->json(['result' => ProductRelatedBoxes::where('boxno', $request->get('boxno'))->where('menucat', $request->get('menucat'))->where('lang', $request->get('lang'))->where('partno', $request->get('partno'))->firstOrfail()->delete()]);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }
    /***
     * get related boxes by partno/productcode 
     * return boxno menucat in array
     */
    public function getRelatedBoxesByPartno($locale, $partno)
    {
        if ($partno) {
            $aryData = [];
            if ($data = ProductRelatedBoxes::select("boxno", "menucat")->where("partno", $partno)->where("lang", $locale)->where("status", 1)->get()) {
                Logger()->debug("getRelatedBoxesByPartno : data " . var_export($data, true));
                $aryData['menucat'] = $data->pluck('menucat')->unique()->toArray();
                $aryData['boxno'] = $data->pluck('boxno')->unique()->toArray();
                Logger()->debug("getRelatedBoxesByPartno : aryData " . var_export($aryData, true));
                return $aryData;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function updateRelatedBoxes(Request $request)
    {
        Logger()->error(" updateRelatedBoxes : request DATA - " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'partno' => 'required',
                    'menucat' => 'required',
                    'boxno' => "required"
                ],
                [
                    'partno.required' => 'partno is required.',
                    'menucat.required' => 'product_id is required.',
                    'boxno.required' => 'menucat is required.',
                ]
            );
            Logger()->debug("updateRelatedBoxes : start " . var_export($request->all(), true));
            $getRelatedBox = ProductRelatedBoxes::whereId($request->get('id'))->first();
            $getRelatedBox->seqno = $request->get('seqno');
            $getRelatedBox->seqno = $request->get('status');

            if ($getRelatedBox->save()) {
                logger()->debug(" updateRelatedBoxes - update data : SAVED" . var_export($request->all(), true));
                return response()->json(['result' => true, 'data' => $getRelatedBox]);
            } else {
                logger()->error(" updateRelatedBoxes - update data : Failed to update" . var_export($request->all(), true));
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
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
                $boxData = ProdlistBoxes::whereId($request->get('bId'))
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
        if ($request->get('boxno') && $request->get('lang') && $request->get('menucat')) {
            // if ($request->get('webmenu') == "old") {
            //     // insert into oldprodlist_box 
            //     //   $pl_table = " oldprodlist_box ";
            //     $boxData = OldprodlistBox::whereId($request->get('id'))->first();
            // } else {
            //     // insert into new prodlist_box 
            //     //    $pl_table = " prodlist_boxes ";
            //     $boxData = ProdlistBoxes::whereId($request->get('id'))->first();
            // }

            // and update all boxes
            if ($request->get('webmenu') == "old") {
                //Post::where('id',3)->update(['title'=>'Updated title']);
                $update = OldprodlistBox::where('boxno', $request->get('boxno'))->where('menucat', $request->get('menucat'))
                ->update([
                    'status' => $request->input("status"),
                    'box_name' => $request->input("box_name"),
                    'box_seqno' => $request->input("box_seqno"),
                ]);
            } else {
                $update = ProdlistBoxes::whereId($request->get('id'))
                ->update([
                    'status' => $request->input("status"),
                    'box_name' => $request->input("box_name"),
                    'box_seqno' => $request->input("box_seqno"),

                ]);
            }

            if ($update) {
                logger()->debug(" boxData - update data : SAVED" . var_export($request->all(), true));
                return response()->json(['result' => true, 'data' => $update]);
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

    public function updateBoxSeqno($menucat, $type){
        if ($type == 'add'){
            // all box_seqno + 10
            //$getMaxBoxSeqno = ProdlistBoxes::where('menucat', strval(sprintf("%04d", $request->get('menucat'))))->max("box_seqno");

            $boxes = ProdlistBoxes::where('menucat', strval(sprintf("%04d", $menucat)))->get();
            foreach ($boxes as $box){
                $box->box_seqno = sprintf("%04d", (int)$box->box_seqno + 10);
                if ($box->save()){
                    Logger()->debug(' updateBoxSeqno : DONE ');
                } else {
                    return false;
                }
            }
            return true;

        }
    }

    public function updateBoxesIsSelected($locale,Request $request){
        try {
            Logger()->debug(" updateIsSelected : start " . var_export($request->all(), true));
            $this->validate(
                $request,
                [
                    'pb_id' => 'required',
                    'productcode' => 'required',
                ],
                [
                    'pb_id.required' => 'PB ID is required.',
                    'productcode.required' => 'productcode is required.',
                ]
            );
            

            $prodlistBoxes = ProdlistBoxes::where("productcode",$request->get('productcode'))
            ->update(['is_selected'=>ProdlistBoxes::ISSELECT_INACTIVE]);

            // update selected 
            $updateProdlistBoxes = ProdlistBoxes::whereId($request->get('pb_id'))->update(['is_selected'=>ProdlistBoxes::ISSELECT_ACTIVE]);

            if ($updateProdlistBoxes) {
                logger()->debug(" boxData - updateIsSelected data : SAVED" . var_export($request->all(), true));
                return response()->json(['result' => true, 'data' => $updateProdlistBoxes]);
            } else {
                logger()->error(" boxData - updateIsSelected data : NO inserted " . var_export($request->all(), true));
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }
}
