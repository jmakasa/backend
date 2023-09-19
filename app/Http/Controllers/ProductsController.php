<?php

namespace App\Http\Controllers;

//use App\Models\Category;
use App\Http\Controllers\ProductBoxesController as productBoxesCtrl;
use App\Http\Controllers\KeywordsController as keywordsCtrl;
use App\Models\Products;
use App\Models\ProdSpec;
use App\Models\WebProducts;
use App\Models\ProdlistBoxes;
use App\Models\Images;
use App\Models\Downloads;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Services\FileService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redirect;

class ProductsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['apiProductLists']]);
        // check login session key : username



    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = WebProducts::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * product detail page
     */
    public function view_detail($locale, Request $request)
    {
       //   dd($_SESSION);

        if (!$this->hasLoginFromMarketing()) {
            // redirect to login
            $currenturl = $request->url();

         //   dd($currenturl);
            $host = request()->getHttpHost();
            $url = "http://" . $host . "/marketing/login.php?returnUrl=" . $currenturl;
            return Redirect::to($url);
        }
        $request->merge(['partno' => $request->route('partno')]);

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


            $product = Products::where('partno', $request->get('partno'))->whereLang($locale)->get()->first();
            $img = Images::where('partno', $request->get('partno'))->listpic()->get()->first();
            $keywordsCtrl = new keywordsCtrl;
            $socketType =$keywordsCtrl->getSocketList($locale);
            
            if ($product){
                return view('backend.products.detail', compact('product','img','socketType'));
            } else {
                // TODO:: return and said no this partno
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }


    /**
     * get product basic info
     * return json 
     */
    public function getProductDetailsById($locale, Request $request){
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                ],
                [
                    'id.required' => 'Partno is required.',
                ]
            );
            $product = Products::select("id","partno","title","name","related","iscooler","keywords","longdesc","active","newproduct","updated_by","updated_at","lang","introduction","intro_display_type","note","updated_at","updated_by","pstatus","eol","eol_date","eol_comment","moddate")->whereId($request->get('id'))->whereLang($locale)->get()->first();
            Logger()->debug(" getProductDetailsById : data " . var_export($product,true));

            if ($product){
                $data = $product->toArray();
                $data['available_lang'] = Products::where('partno',$product['partno'])->pluck("lang");
                return response()->json($data);
            } else {
                // TODO:: return and said no this partno
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }

    }

    public function updateIntro($locale, Request $request){
        try {
            $this->validate(
                $request,
                [
                    'partno' => 'required',
                    'introduction' => 'required',
                    'intro_display_type' => 'required',

                ],
                [
                    'partno.required' => 'Partno is required.',
                    'introduction.required' => 'Introduction is required.',
                    'intro_display_type.required' => 'Intro display type is required.',
                ]
            );
            Logger()->debug(" updateIntro : request " . var_export($request->all(),true));
            $product = Products::whereLang($locale)->where("partno",$request->get('partno'))
                        ->update(['introduction'=>$request->get('introduction'),'intro_display_type'=>$request->get('intro_display_type')]);

            if ($product){
                return response()->json($product);
            } else {
                // TODO:: return and said no this partno
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function updateProductDetails($locale, Request $request){
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
            Logger()->debug(" updateProductDetails : locale " . var_export($locale,true));
            Logger()->debug(" updateProductDetails : request " . var_export($request->all(),true));
            $eol = 0;
            if ($request->get('pstatus') == PRODUCTS::PSTATUS_EOL){
                $eol = 1;
                $active = false;
                $newproduct = false;
            } else if ($request->get('pstatus') == PRODUCTS::PSTATUS_HIDDEN){
                $active = false;
                $newproduct = false;
            } else if ($request->get('pstatus') == PRODUCTS::PSTATUS_NEW){
                $active = true;
                $newproduct = true;
            } else {
                $active = true;
                $newproduct = false;
            }


            $product = Products::whereLang($locale)->where("partno",$request->get('partno'))
                        ->update([
                            'name'=>$request->get('name'),
                            'title'=>$request->get('title'),
                            'related'=>$request->get('related'),
                            'longdesc'=>$request->get('longdesc'),
                            'keywords'=>$request->get('keywords'),
                            'newproduct'=> ($newproduct? 1:0),
                            'upcoming'=>($request->get('upcoming')? 1:0),
                            'iscooler'=>($request->get('iscooler')? 1:0),
                            'active'=>($active? 1:0),
                            'eol'=>$eol,
                            'pstatus'=>$request->get('pstatus'),
                        ]);

            if ($product){
                return response()->json($product);
            } else {
                // TODO:: return and said no this partno
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }



    public function create(Request $request)
    {
        // tags
        //   $tags = Tags::whereStatus("Active")->get();
        // categorys
        $categories = Category::whereStatus("Active")->get();
        // keywords
        //    $keywords = Keywords::whereStatus("Active")->get();
        // blogs
        //   $blogs = Blogs::whereStatus("Active")->get();
        // products
        // blogs
        $products = WebProducts::whereStatus("Active")->get();


        // return view('admin.products.create', compact('products', 'tags', 'categories', 'keywords', 'blogs'));
        return view('admin.products.create', compact('products', 'categories'));
    }
    public function store(Request $request)
    {
        //
        logger()->debug(" category - Store : " . var_export($request->all(), true));
        $product = (new Products)
            ->validateAndFill($request->all())
            ->setAttribute('status', Products::STATUS_ACTIVE)
            ->setAttribute('type', Products::TYPE_MAIN);

        // set default value 
        $product->name = $this->assignDefaultValue($request->input("name")['en'], $request->input('name'));
        $product->desc = $this->assignDefaultValue($request->input("desc")['en'], $request->input('desc'));
        $product->intro = $this->assignDefaultValue($request->input("intro")['en'], $request->input('intro'));
        $product->spec = $this->assignDefaultValue($request->input("spec")['en'], $request->input('spec'));
        logger()->debug(" product - Store data : " . var_export($product, true));
        // store relationship 

        if ($product->save()) {
            logger()->debug(" product - Store data : SAVED" . var_export($request->all(), true));
            return redirect()->route('admin.products_list', [config('app.locale')])->with('status', 'Product is added');
        } else {
            logger()->debug(" product - Store data : NO inserted" . var_export($request->all(), true));
            return back()->with('autofocus', true);
        }

        //  return view('admin.products.index', compact('products'));
    }
    public function update(Request $request)
    {
        return view('admin.products.index', compact('products'));
    }
    public function delete(Request $request)
    {
        return view('admin.products.index', compact('products'));
    }

    /**
     * list all products listing
     * return json 
     * 
     */
    public function apiProductLists($locale, Request $request)
    {
        Logger()->debug("apiProductLists " . var_export($request->all(), true));
        
        $sort = $request->has('sort') ? $request->get('sort') : 'moddate';
        $order = $request->has('order') ? $request->get('order') : 'desc';
        $page = $request->has('page') ? $request->get('page') : 1;
        $rows = $request->has('rows') ? $request->get('rows') : 50;
        $lang = $request->has('lang') ? $request->get('lang') : 'en';
        if ($rows != 'all'){
            $skip = ($page - 1) * $rows;
        }
        
        $products = Products::select('id', 'partno', 'title', 'name', 'active', 'pstatus', 'modauthor', 'moddate', 'eol', 'newproduct', 'iscooler', 'longdesc')
            ->where('lang', $lang);
        if ($request->get('partno')) {
            $aryPartno = explode(" ", $request->get('partno'));
            if (count($aryPartno) > 1) {
                // more than 1
                $products->whereIn("partno", $aryPartno);
            } else {
                $products->where("partno", 'like', '%' . $request->get('partno') . '%');
            }
        }

        $aryPstatus = [];
        if ($request->get('new') == 'true') {
            $aryPstatus[]=Products::PSTATUS_NEW;
        }

        if ($request->get('upcoming') == 'true') {
            $aryPstatus[]=Products::PSTATUS_UP;
        }

        if ($request->get('eol') == 'true') {
            $aryPstatus[]=Products::PSTATUS_EOL;
        }

        if (!empty($aryPstatus)){
            $products->whereIn("pstatus", $aryPstatus);
        }

        if ($request->get('iscooler') == 'true') {
            $products->where("iscooler", 1);
        }
        $data['total']= $products->count();

        $products->orderBy($sort, $order);
        
        if ($rows != 'all'){
            $products->skip($skip)->take($rows);
        }
        $data['rows']=$products->get();
        

        return response()->json($data);
    }

    /**
     * 
     */
    public function getProductByCategory()
    {
    }

    public function edit(Request $request)
    {
        // tags
        //  $tags = Tags::whereStatus("Active")->get();
        // categorys
        $categories = Category::whereStatus("Active")->get();
        // keywords
        //  $keywords = Keywords::whereStatus("Active")->get();
        // blogs
        //  $blogs = Blogs::whereStatus("Active")->get();
        // products
        // blogs
        $products = WebProducts::whereStatus("Active")->whereId($request->get('id'))->get();


        // return view('admin.products.create', compact('product', 'tags', 'categories', 'keywords', 'blogs'));
        return view('admin.products.create', compact('product'));
    }
    public function listProductWithImage($locale, Request $request)
    {
        Logger()->debug("listProductWithImage " . var_export($request->all(), true));
        //    $sql = 'SELECT p.id as product_id, p.partno AS partno, i.docname AS docname, i.docdir AS dir, p.pstatus as pstatus, p.lang as lang  FROM products p LEFT JOIN images i ON i.partno = p.partno  ';
        $listProducts = DB::table('products AS p')
            ->selectRaw("p.id as product_id, p.partno AS partno, p.pstatus as pstatus, p.lang as lang,  i.docname, i.ctype as itype, i.docdir as dir");

        //     ->leftJoin('images AS i', 'p.partno', '=', 'i.partno');
        //      ->leftJoin('prodlist_boxes AS pb', 'p.partno', '=', 'pb.productcode');
        $listProducts->leftJoin(
            DB::raw('(select listpic, docname, ctype,docdir, partno FROM images WHERE listpic = 1 AND ctype="gallery") as i'),
            function ($join) {
                $join->on('p.partno', '=', 'i.partno');
            }
        );

        /* mutilple partno */
        if ($request->input('partno')) {
            $aryPartno = explode(",",$request->input('partno'));
            $aryPartnoSpace =explode(" ",$request->input('partno'));
            if (count($aryPartno) > 1){
                $listProducts->where("p.partno", $aryPartno);
            } else if (count($aryPartnoSpace) > 1){ 

              $listProducts->where("p.partno", $aryPartnoSpace);
            } else {
                $listProducts->where("p.partno", 'like', '%' . $request->input('partno') . '%');
            }
        }
        //       $listProducts->where("i.ctype", 'gallery');
        //        $listProducts->where("i.listpic", 1);
        $listProducts->where("p.lang", $request->input('lang'));

        $aryPstatus = [];
        if ($request->input('new') == 'true') {
            $aryPstatus[]=Products::PSTATUS_NEW;
        }

        if ($request->input('upcoming') == 'true') {
            $aryPstatus[]=Products::PSTATUS_UP;
        }

        if ($request->input('eol') == 'true') {
            $aryPstatus[]=Products::PSTATUS_EOL;
        }

        if (!empty($aryPstatus)){
            $listProducts->whereIn("p.pstatus", $aryPstatus);
        }

        if ($request->input('iscooler') == 'true') {
            Logger()->debug("listProductWithImage  in iscooler");
            $listProducts->where("p.iscooler", 1);
        }

        
        if ($request->input('rows')) {
            Logger()->debug("listProductWithImage  in rows");
            if ($request->input('rows') != 'all'){
                $listProducts->limit($request->input('rows'));
            }
            
            
        } else {
            $listProducts->limit('5');
        }

        $listProducts->orderBy("partno");
        $listProducts->groupBy("partno");
        return response()->json($listProducts->get());
    }

    public function generateConfByMenucat($locale, Request $request, FileService $fileService)
    {

        if ($request->get('menucat')) {
            Logger()->debug("generateConfByMenucat : DONE  : " . var_export($request->get('menucat'), true));
            $boxes = ProdlistBoxes::where('menucat', strval(sprintf("%04d", $request->get('menucat'))))->get();
            $aryPartno = [];
            Logger()->debug("generateConfByMenucat : DONE  : " . var_export($boxes, true));
            foreach ($boxes as $box) {
                $jsonProduct = $this->showOne($locale, $box->productcode);
                $aryPartno[] = $box->productcode;
                $result = $fileService->createConf('product', $box->productcode . '.conf', $locale,  "[product]\ndetails=" . json_encode($jsonProduct));
            }
            Logger()->debug("generateConfByMenucat : DONE  : " . var_export($aryPartno, true));
            return response()->json(['result' => $result]);
        } else {
            return  response()->json(['result' => false]);
        }
    }

    public function generateSingleConf($locale, Request $request, FileService $fileService)
    {
        $result = false;
        if ($request->has('batch') && $request->has('partnos') ) {
            Logger()->debug("generateSingleConf : batch :  result : " . var_export($request->all(), true));
            $aryPartno = explode(",", $request->get('partnos'));
            foreach ($aryPartno as $partno) {
                $jsonProduct = $this->showOne($locale, $partno);
                $result = $fileService->createConf('product', $partno . '.conf', $locale,  "[product]\ndetails=" . json_encode($jsonProduct), $partno);
               // Logger()->debug("generateSingleConf : partno : " . $partno . ", result : " . var_export($result, true));
                // export files
                //
                //export images from backend to akasa2206 front end
                //
                $images = Images::where('partno', $partno)->get();
                foreach ($images as $image) {
                    if ($image->docname) {
                        $fileService->exportFiles($image->ctype, $image->docname, $image->partno, $locale);
                    }
                }
                //
                //export download from backend to akasa2206 front end
                //
                $downloads = Downloads::where('partno', $partno)->get();
                foreach ($downloads as $dl) {
                    if ($dl->docname) {
                        $fileService->exportFiles($dl->ftype, $dl->docname, $dl->partno, $locale);
                    }
                }
            }
        } else {
            $partno = $request->get('partno');
            $jsonProduct = $this->showOne($locale, $partno);

            $result = $fileService->createConf('product', $partno . '.conf', $locale,  "[product]\ndetails=" . json_encode($jsonProduct), $partno);
            Logger()->debug("generateSingleConf : partno : " . $partno . ", result : " . var_export($result, true));

            // export files
            //
            //export images from backend to akasa2206 front end
            //
            $images = Images::where('partno', $partno)->get();
            foreach ($images as $image) {
                if ($image->docname) {
                    $fileService->exportFiles($image->ctype, $image->docname, $image->partno, $locale);
                }
            }

            //
            //export download from backend to akasa2206 front end
            //
            $downloads = Downloads::where('partno', $partno)->get();
            foreach ($downloads as $dl) {
                if ($dl->docname) {
                    $fileService->exportFiles($dl->ftype, $dl->docname, $dl->partno, $locale);
                }
            }
        }

        return response()->json(['result' => $result]);
        // $partno = $request->get('partno');
        // $jsonProduct = $this->showOne($locale, $partno);

        // $result = $fileService->createConf('product', $partno . '.conf', $locale,  "[product]\ndetails=" . json_encode($jsonProduct));
        // Logger()->debug("generateSingleConf : partno : " . $partno . ", result : " . var_export($result, true));

        // // export files
        // //
        // //export images from backend to akasa2206 front end
        // //
        // $images = Images::where('partno', $partno)->get();
        // foreach ($images as $image) {
        //     if ($image->docname) {
        //         $fileService->exportFiles($image->ctype, $image->docname, $image->partno, $locale);
        //     }
        // }

        // //
        // //export download from backend to akasa2206 front end
        // //
        // $downloads = Downloads::where('partno', $partno)->get();
        // foreach ($downloads as $dl) {
        //     if ($dl->docname) {
        //         $fileService->exportFiles($dl->ftype, $dl->docname, $dl->partno, $locale);
        //     }
        // }

        // return response()->json(['result' => $result]);
    }

    //public function showOne ($locale, $partno){

    public function showOne($locale, $partno)
    {
        Logger()->debug("showOne " . var_export($partno, true));
        //$partno ="AK-CC7139HP01";
        if ($partno) {
            $product = Products::with('download:partno,lang,subject,docname,docdir,ftype,comment,filesize,filetype,releasedate')
                ->with('activeReviews')
                ->with('activeRelatedBoxes')
                ->with(['spec' => function ($query) {
                    $query->select("prod_spec.partno", "prod_spec.specname", "prod_spec.specdesc", "prod_spec.group_id", DB::raw('MIN(prod_spec.seqno) as min_seqno'))->leftJoin('prod_spec_groups as pg', 'pg.id', '=', 'prod_spec.group_id')->groupBy('group_id')->orderBy("pg.seqno")->with('specGroup');
                    //  ->orderBy("min_seqno")

                    // $query->groupBy('group_id');,DB::raw('MAX(prod_spec.seqno) as max_seqno')->orderBy("max_seqno")
                    //$query->select('prod_spec.group_id')->leftJoin('prod_spec_groups as pg', 'pg.id', '=', 'prod_spec.group_id')->groupBy('prod_spec.group_id')->orderBy("pg.seqno");
                    //   $query->groupBy('parent_id');
                }])
                ->with(['productInBox' => function ($query) use ($locale) {
                    $query->where('lang', $locale);
                }])
                ->with(['faqs' => function ($query) use ($locale) {
                    $query->select("question", "answer", "partno")->where('lang', $locale);
                }])
                ->with('feature_images:docdir,docname,partno')
                ->with('gallery:docdir,docname,partno')
                ->with(['content_images' => function ($query) {
                    $query->select("docdir", "docname", "partno")->orderBy('seqno');
                }])
                ->with('spec_images:docdir,docname,partno')
                ->where('partno', $partno)->where('lang', $locale)->first()->toArray();
        }
        
        // find spec
        foreach ($product['spec'] as $key => $spec) {
            $product['spec'][$key]['children'] =  ProdSpec::select("prod_spec.partno", "prod_spec.specname", "prod_spec.specdesc", "prod_spec.group_id", 'pg.group_name', 'pg.group_name_en', 'pg.group_name_cn')->leftJoin('prod_spec_groups as pg', 'pg.id', '=', 'prod_spec.group_id')
            ->where('prod_spec.group_id', $spec['group_id'])->where('prod_spec.partno', $partno)->where('prod_spec.lang', $locale)->orderBy("pg.seqno")->orderBy("prod_spec.seqno")->get()->toArray();
        }

        // find boxes [boxes][menucat_name]

        $boxes = ProdlistBoxes::select('boxno', 'menucat')->where('productcode', $partno)->groupBy("boxno")->get()->toArray();
        if ($boxes) {
            // call productBoxController
            $ProductBoxesCtrl = new productBoxesCtrl;
            $product['boxes'] = $ProductBoxesCtrl->getBoxDataWithImage($locale, $boxes);
        }
        // end boxes

        if ($product['related']) {
            $product['related_products'] = $this->getRelatedProduct($product['related'], $locale);
        }

        // $navmenus = ProdlistBoxes::select('prodlist_boxes.productcode', 'prodlist_boxes.menucat', 'prodlist_boxes.boxno', 'p_nav.parent as group_cat', 'p_nav.submenu as main_cat', 'nav.submenu as sub_cat')
        //     ->leftJoin('2022_navmenu as nav', 'nav.id', '=', 'prodlist_boxes.menucat')
        //     ->leftJoin('2022_navmenu as p_nav', 'nav.parent_id', '=', 'p_nav.id')
        //     ->where('nav.id', ">", 100)->where('prodlist_boxes.productcode', $partno)->where('prodlist_boxes.lang', $locale)
        //     ->first();
        // if ($navmenus) {
        //     $product['navmenus'] = $navmenus->toArray();
        // } else {
        //     $navmenus = ProdlistBoxes::select('prodlist_boxes.productcode', 'prodlist_boxes.menucat', 'prodlist_boxes.boxno', 'p_nav.parent as group_cat', 'p_nav.submenu as main_cat', 'nav.submenu as sub_cat')
        //     ->leftJoin('2022_navmenu as nav', 'nav.id', '=', 'prodlist_boxes.menucat')
        //     ->leftJoin('2022_navmenu as p_nav', 'nav.parent_id', '=', 'p_nav.id')
        //   //  ->where('nav.id', ">", 100)
        //     ->where('prodlist_boxes.productcode', $partno)->where('prodlist_boxes.lang', $locale)
        //     ->first();
        //     if ($navmenus) {
        //     $product['navmenus'] = $navmenus->toArray();
        //     $product['navmenus']['group_cat'] = $product['navmenus']['main_cat'];
        //     }
        // }
        // prodlist_boxes is_selected added
        $navmenus =  ProdlistBoxes::select('prodlist_boxes.productcode', 'prodlist_boxes.menucat', 'prodlist_boxes.boxno', 'p_nav.parent as group_cat', 'p_nav.submenu as main_cat', 'nav.submenu as sub_cat', 'p_nav.display_name as main_cat_display_name', 'group_nav.display_name as group_cat_display_name', 'nav.display_name as sub_cat_display_name', 'nav.json as nav_json', 'p_nav.json as p_nav_json', 'group_nav.json as group_nav_json')
        ->leftJoin('2022_navmenu as nav', 'nav.id', '=', 'prodlist_boxes.menucat')
        ->leftJoin('2022_navmenu as p_nav', 'nav.parent_id', '=', 'p_nav.id')
        ->leftJoin('2022_navmenu as group_nav', 'group_nav.id', '=', 'p_nav.parent_id')
        ->where('prodlist_boxes.productcode', $partno)->where('prodlist_boxes.lang', $locale)
        ->get()->toArray();

        $aryNavmenu = [];


        foreach ($navmenus as $nKey => $navmenu) {

            foreach ($navmenu as $nk => $nav) {
                Logger()->debug("showOne navmenus NK $nk : json : " . $nav);
                if ($nk == 'nav_json' && $nav) { // sub
                    foreach (json_decode($nav) as $key => $txt) {
                        $navmenus[$nKey]['sub_cat_' . $key] = $txt;
                    }
                } else if ($nk == 'p_nav_json' && $nav) { // main
                    foreach (json_decode($nav) as $key => $txt) {
                        $navmenus[$nKey]['main_cat_' . $key] = $txt;
                    }
                } else if ($nk == 'group_nav_json' && $nav) { // group
                    foreach (json_decode($nav) as $key => $txt) {
                        $navmenus[$nKey]['group_cat_' . $key] = $txt;
                    }
                }
            }
        }
        $product['navmenus'] = $navmenus;

        // $product['navmenus'] = ProdlistBoxes::select('prodlist_boxes.productcode', 'prodlist_boxes.menucat', 'prodlist_boxes.boxno', 'p_nav.parent as group_cat', 'p_nav.submenu as main_cat', 'nav.submenu as sub_cat','p_nav.display_name as main_cat_display_name','group_nav.display_name as group_cat_display_name','nav.display_name as sub_cat_display_name', 'nav.json as nav_json', 'p_nav.json as p_nav_json', 'group_nav.json as group_nav_json')
        //     ->leftJoin('2022_navmenu as nav', 'nav.id', '=', 'prodlist_boxes.menucat')
        //     ->leftJoin('2022_navmenu as p_nav', 'nav.parent_id', '=', 'p_nav.id')
        //     ->leftJoin('2022_navmenu as group_nav', 'group_nav.id', '=', 'p_nav.parent_id')
        //     ->where('prodlist_boxes.productcode', $partno)->where('prodlist_boxes.lang', $locale)
        //     ->get();
        $selectedCat = ProdlistBoxes::select('prodlist_boxes.productcode', 'prodlist_boxes.menucat', 'prodlist_boxes.boxno', 'p_nav.parent as group_cat', 'p_nav.submenu as main_cat', 'nav.submenu as sub_cat','p_nav.display_name as main_cat_display_name','group_nav.display_name as group_cat_display_name','nav.display_name as sub_cat_display_name', 'nav.json as nav_json', 'p_nav.json as p_nav_json', 'group_nav.json as group_nav_json')
        ->leftJoin('2022_navmenu as nav', 'nav.id', '=', 'prodlist_boxes.menucat')
        ->leftJoin('2022_navmenu as p_nav', 'nav.parent_id', '=', 'p_nav.id')
        ->leftJoin('2022_navmenu as group_nav', 'group_nav.id', '=', 'p_nav.parent_id')
        ->where('prodlist_boxes.is_selected', ProdlistBoxes::ISSELECT_ACTIVE)->where('prodlist_boxes.productcode', $partno)->where('prodlist_boxes.lang', $locale)
        ->first()->toArray();
        foreach ($selectedCat as $sKey => $scat) {
            
            if ($sKey == 'nav_json' && $scat) { // sub
                foreach (json_decode($scat) as $key => $txt) {
                    $selectedCat['sub_cat_' . $key] = $txt;
                }
            } else if ($sKey == 'p_nav_json' && $scat) { // main
                foreach (json_decode($scat) as $key => $txt) {
                    $selectedCat['main_cat_' . $key] = $txt;
                }
            } else if ($sKey == 'group_nav_json' && $scat) { // group
                foreach (json_decode($scat) as $key => $txt) {
                    $selectedCat['group_cat_' . $key] = $txt;
                }
            }
        }

        Logger()->debug("showOne navmenus NK $sKey : json : " . var_export($selectedCat,true));
        $product['selected_category'] = $selectedCat;


        return json_encode($product);
        //return response()->json($product);
    }

    public function getRelatedProduct($partnos, $locale)
    {
        $aryPartnos = explode(",", $partnos);
        $return = [];
        Logger()->debug("getRelatedProduct - " . var_export($partnos, true));
        foreach ($aryPartnos as $partno) {
            // partno, name, title, first gallery pic and menucat (child), pstatus

            $result =  Products::select('id', 'partno', 'name', 'title', 'pstatus', 'active')

                ->with(['gallery' => function ($query) use ($locale) {
                    $query->select("docdir", "docname", "partno")->where('lang', $locale)
                        ->where('docname', 'not like', "%g00%")
                        ->where('docname', 'like', "%g0%")
                        ->orderBy('docname')->first();
                }])
                ->with(['productInBox' => function ($query) use ($locale) {
                    $query->where('lang', $locale);
                }])
                ->where('partno', $partno)->where('lang', $locale)->first();
            if ($result) {
                $return[] = $result->toArray();
            }
        }
        return $return;
    }

    public function generateAllConf($locale,  FileService $fileService)
    {
        // ini_set('max_execution_time', 6000);
        // set_time_limit(6000);
        $cnt = 1;
        $allProduct = Products::select('partno', 'exported')->where("lang", '=', $locale)->where('exported', '=', 0)->limit(20)->get();
        foreach ($allProduct as $product) {
            $cnt++;

            $jsonProduct = $this->showOne($locale, $product->partno);
            $fileService->createConf('product', $product->partno . '.conf', $locale,   "[product]\ndetails=" . json_encode($jsonProduct));
            Products::where('partno', $product->partno)->where("lang", '=', $locale)
                ->update(['exported' => 1]);
        }
        echo $cnt;
    }

    public function generateAllConfWithFiles($locale,  FileService $fileService)
    {
        // ini_set('max_execution_time', 6000);
        // set_time_limit(6000);
        $cnt = 1;
        $allProduct = Products::select('partno', 'exported')->where("lang", '=', $locale)->where('exported', '=', 0)->limit(20)->get();
        foreach ($allProduct as $product) {
            $cnt++;

            $jsonProduct = $this->showOne($locale, $product->partno);
            $fileService->createConf('product', $product->partno . '.conf', $locale,   "[product]\ndetails=" . json_encode($jsonProduct));
            Products::where('partno', $product->partno)->where("lang", '=', $locale)
                ->update(['exported' => 1]);

            // export files
            //
            //export images from backend to akasa2206 front end
            //
            $images = Images::where('partno', $product->partno)->get();
            foreach ($images as $image) {
                if ($image->docname) {
                    $fileService->exportFiles($image->ctype, $image->docname, $image->partno);
                }
            }

            //
            //export download from backend to akasa2206 front end
            //
            $downloads = Downloads::where('partno', $product->partno)->get();
            foreach ($downloads as $dl) {
                if ($dl->docname) {
                    $fileService->exportFiles($dl->ftype, $dl->docname, $dl->partno);
                }
            }
        }
        echo $cnt;
    }

    public function getProductListByMenucat($locale, Request $request)
    {
        logger()->debug(" getProductListByMenucat : " . var_export($request->all(), true));
        $page = ($request->get('page') ? $request->get('page') : 1);
        $rows = ($request->get('rows') ? $request->get('rows') : 0);
        $offset = ($page - 1) * $rows;
        $menucat = strval(sprintf("%04d", $request->get('menucat')));
        $ProductBoxesCtrl = new productBoxesCtrl;
        $products = $ProductBoxesCtrl->getBoxDataByMenucat($menucat, $locale, $offset, $rows);

        //     logger()->debug(" getProductListByMenucat : aryData " . var_export($products, true));
        if ($products) {
            //total_products , total boxes
            $cntBoxes = $products->pluck("boxno");
            $aryData['total_boxes'] = $cntBoxes->unique()->count();
            $aryData['total'] = $products->count();
            $aryData['rows'] = $products->toArray();
            $aryData['result'] = true;
        } else {
            $aryData['total'] = 0;
            $aryData['rows'] = [];
            $aryData['result'] = false;
        }

        return response()->json($aryData);
    }


    /****
     * request the partno and get the related boxes then fetch the boxes 
     */
    public function getProductListByPartno($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'partno' => 'required',
                ],
                [
                    'partno.required' => 'partno is required.',

                ]
            );

            // first get the related boxes by partno
            $ProductBoxesCtrl = new productBoxesCtrl;
            $relatedBoxes = $ProductBoxesCtrl->getRelatedBoxesByPartno($locale, $request->get("partno"));

            if ($relatedBoxes['menucat'] && $relatedBoxes['boxno']) {

                $page = ($request->get('page') ? $request->get('page') : 1);
                $rows = ($request->get('rows') ? $request->get('rows') : 0);
                $offset = ($page - 1) * $rows;
                logger()->debug(" getProductListByPartno : relatedBoxes " . var_export($relatedBoxes['menucat'], true));
                $aryMenu = [];
                if ($relatedBoxes['menucat']) {

                    foreach ($relatedBoxes['menucat'] as $key => $value) {
                        $aryMenu[] = sprintf("%04d", $value);
                    }
                    logger()->debug(" getProductListByPartno : menucat aryMenu " . var_export($aryMenu, true));
                }

                $ProductBoxesCtrl = new productBoxesCtrl;
                $products = $ProductBoxesCtrl->getBoxDataByBoxno($aryMenu, $relatedBoxes['boxno'], $locale, $offset, $rows);


                if ($products) {
                    //  logger()->debug(" getProductListByPartno : menucat products " . var_export($products->toArray(), true));
                    //total_products , total boxes
                    $aryData['rows'] = $products->toArray();
                    $cntBoxes = $products->pluck("boxno");
                    $aryData['total_boxes'] = $cntBoxes->unique()->count();
                    $aryData['total'] = $products->count();

                    $aryData['result'] = true;
                    //  logger()->debug(" getProductListByPartno : aryData " . var_export($aryData, true));
                } else {
                    $aryData['total'] = 0;
                    $aryData['rows'] = [];
                    $aryData['result'] = false;
                }
                return response()->json($aryData);
            } else {
                Logger()->debug(" getProductListByPartno no result");
                return false;
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }
}
