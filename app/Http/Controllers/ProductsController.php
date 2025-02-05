<?php

namespace App\Http\Controllers;

//use App\Models\Category;
use App\Http\Controllers\ProductBoxesController as productBoxesCtrl;
use App\Http\Controllers\KeywordsController as keywordsCtrl;
use App\Http\Controllers\NavmenuController as navmenuCtrl;

use App\Models\Products;
use App\Models\ProdSpec;
use App\Models\WebProducts;
use App\Models\ProdlistBoxes;
use App\Models\ProdKeywords;
use App\Models\Keywords;
use App\Models\Navmenu2022;
use App\Models\Images;
use App\Models\Downloads;
use App\Models\Category;
use App\Models\Settings;
use App\Models\UploadFiles;
use App\Models\Reviewsites;
use App\Models\ProductReviews;
use App\Models\ProductEcommerceUrls;
use App\Models\TopSalesQty;
use App\Models\SalesOffices;
use App\Models\ProductChangeLogs;

use App\Services\HistoryService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Services\FileService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{

    protected $listConfPath;
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['apiProductLists']]);
        // check login session key : username
        $this->listConfPath = DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "product" . DIRECTORY_SEPARATOR;
    }

    public function getFormSettings(navmenuCtrl $navmenuCtrl, keywordsCtrl $keywordsCtrl)
    {
        $arySettings = [];
        // pstatus
        $arySettings['pstatus'] = Settings::select("name", "value")->where('module', 'products')->where('type', "pstatus")->get()->keyBy('value');

        $arySettings['pstatus_style'] = Settings::select("name", "value")->where('module', 'products')->where('type', "pstatus_style")->get()->keyBy('name');

        $arySettings['status'] = [
            ['value' => 1, 'text' => 'Active'],
            ['value' => 0, 'text' => 'Inactive'],
        ];
        // navmenu activeAryNavmenu2022List
        $arySettings['category'] = $navmenuCtrl->activeAryNavmenu2022List();

        $arySettings['menucat_list'] = $navmenuCtrl->activeAryNavmenu2022ListOneLevel();
        $arySettings['socket_list'] = $keywordsCtrl->getSocketList('en');
        // $arySettings['socket_intel'] = Keywords::where("type",Keywords::TYPE_INTEL)->orderBy("seqno","asc")->get()->toArray();
        // $arySettings['socket_amd'] = Keywords::where("type",Keywords::TYPE_AMD)->orderBy("seqno","asc")->get()->toArray();

        // p status style
        return response()->json($arySettings);
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

    public function listBox()
    {
        return view('admin.products.list_box');
    }

    public function getProductInBoxes($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'menucat' => 'required',
                ],
                [
                    'menucat.required' => 'Menucat is required.',
                ]
            );

            //     $listProducts = DB::table('prodlist_boxes AS b')
            //     ->selectRaw("SELECT b.id as bId, b.boxno ,  b.menucat as menucat, p.id as product_id, p.partno as text,b.seqno as seqno,b.box_seqno as box_seqno, p.partno AS partno, b.box_name, b.status, p.lang, p.title, p.longdesc, p.name , p.pstatus as pstatus, p.eol_comment, i.docname  ")
            //     ->leftJoin('products as p', 'p.partno', '=', 'b.productcode');

            // $listProducts->leftJoin(
            //     DB::raw('(select listpic, docname, ctype,docdir, partno FROM images WHERE listpic = 1 AND ctype="gallery") as i'),
            //     function ($join) {
            //         $join->on('p.partno', '=', 'i.partno');
            //     }
            // );
            $listProducts = ProdlistBoxes::leftJoin('products as p', 'p.partno', '=', 'prodlist_boxes.productcode');
            $listProducts->select("prodlist_boxes.id as bId", "prodlist_boxes.boxno as boxno", "prodlist_boxes.menucat", "p.id as product_id", "p.partno", "prodlist_boxes.seqno", "prodlist_boxes.box_seqno as box_seqno", "prodlist_boxes.box_name", "prodlist_boxes.status", "prodlist_boxes.lang", "p.title", "p.longdesc", "p.name", "p.pstatus", "p.eol_comment", "i.docname");

            $listProducts->where("menucat", sprintf('%04d', $request->get('menucat')))
                ->where("prodlist_boxes.lang", $locale)
                ->where("p.lang", $locale);

            $listProducts->leftJoin(
                DB::raw('(select listpic, docname, ctype,docdir, partno FROM images WHERE listpic = 1 AND ctype="gallery") as i'),
                function ($join) {
                    $join->on('p.partno', '=', 'i.partno');
                }
            );
            $aryData['rows'] = $listProducts->orderBy('prodlist_boxes.box_seqno', 'asc')->orderBy('prodlist_boxes.seqno', 'asc')->get();
            $aryData['total_products'] = $listProducts->count();
            $groupBy = $listProducts->groupBy('boxno');
            $aryData['total_boxes'] = $groupBy->get()->count();


            //Logger()->debug(" getProductsBox : data " . var_export($aryData,true));
            return response()->json($aryData);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
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
            $socketType = $keywordsCtrl->getSocketList($locale);

            if ($product) {
                return view('admin.products.detail', compact('product', 'img', 'socketType'));
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
    public function getProductDetailsById($locale, Request $request)
    {
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
            $product = Products::select("id", "partno", "title", "name", "related", "iscooler", "keywords", "longdesc", "active", "publish_date", "newproduct", "updated_by", "updated_at", "lang", "introduction", "intro_display_type", "note", "updated_at", "updated_by", "pstatus", "eol", "eol_date", "eol_comment", "moddate")->whereId($request->get('id'))->whereLang($locale)->get()->first();
            Logger()->debug(" getProductDetailsById : data " . var_export($product, true));

            if ($product) {
                $data = $product->toArray();

                $uploadFiles = UploadFiles::leftJoin('upload_files_tasks', 'upload_files.id', '=', 'upload_files_tasks.upload_files_id')
                    ->where("upload_files.partno", $product['partno'])->where('upload_files.etype', UploadFiles::ETYPE_PROD)->orderBy('upload_files_tasks.launch_datetime', 'DESC')->first();

                // $data['published'] = $uploadFiles->launch_datetime;

                Logger()->debug(" getProductDetailsById : upload_files " . var_export($uploadFiles, true));
                $data['available_lang'] = Products::where('partno', $product['partno'])->pluck("lang");
                return response()->json($data);
            } else {
                // TODO:: return and said no this partno
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }

    }

    public function updateIntro($locale, Request $request)
    {
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
            $historyService = new HistoryService;
            //Logger()->debug(" updateIntro : request " . var_export($request->all(), true));

            $data = Products::whereLang($locale)->where("partno", $request->get('partno'))->first();
            $data->introduction = $request->get('introduction');
            $data->intro_display_type = $request->get('intro_display_type');


            // log history if has been changed
            if ($data->isDirty()) {
                foreach ($data->getDirty() as $key => $value) {
                    Logger()->debug(" updateIntro : fieldname " . $key);
                    Logger()->debug(" updateIntro : getOriginal " . var_export($data->getOriginal($key), true));
                    Logger()->debug(" updateIntro : new value " . var_export($value, true));
                    $historyService->addProductsChangeLogs($data->id, $data->partno, $data->getTable(), $key, $data->getOriginal($key), $value, 'change', $request->get('username'));
                }
            }


            if ($data->save()) {
                // add history
                //Logger()->debug(" updateIntro : product " . var_export($product, true));

                $historyService->addProductsHistory($data->id, "update", $request->get('username'));
                return response()->json($data);
            } else {
                // TODO:: return and said no this partno
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function updateProductDetails($locale, Request $request)
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
            Logger()->debug(" updateProductDetails : locale " . var_export($locale, true));
            Logger()->debug(" updateProductDetails : request " . var_export($request->all(), true));
            $eol = 0;
            if ($request->get('pstatus') == PRODUCTS::PSTATUS_EOL) {
                $eol = 1;
                $active = false;
                $newproduct = false;
            } else if ($request->get('pstatus') == PRODUCTS::PSTATUS_HIDDEN) {
                $active = false;
                $newproduct = false;
            } else if ($request->get('pstatus') == PRODUCTS::PSTATUS_NEW) {
                $active = true;
                $newproduct = true;
            } else {
                $active = true;
                $newproduct = false;
            }

            $data = Products::whereLang($locale)->where("partno", $request->get('partno'))->first();
            $data->name = $request->get('name');
            $data->title = $request->get('title');
            $data->related = $request->get('related');
            $data->longdesc = $request->get('longdesc');
            $data->keywords = $request->get('keywords');
            $data->newproduct = ($newproduct ? 1 : 0);
            $data->upcoming = ($request->get('upcoming') ? 1 : 0);
            $data->iscooler = ($request->get('iscooler') ? 1 : 0);
            $data->active = ($active ? 1 : 0);
            $data->eol = $eol;
            $data->pstatus = $request->get('pstatus');
            $data->publish_date = $request->get('publish_date');

            // log history if has been changed
            if ($data->isDirty()) {
                foreach ($data->getDirty() as $key => $value) {
                    Logger()->debug(" updateIntro : fieldname " . $key);
                    Logger()->debug(" updateIntro : getOriginal " . var_export($data->getOriginal($key), true));
                    Logger()->debug(" updateIntro : new value " . var_export($value, true));
                    $historyService->addProductsChangeLogs($data->id, $data->partno, $data->getTable(), $key, $data->getOriginal($key), $value, 'change', $request->get('username'));
                }
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

            if ($data->save()) {
                // update history
                $historyService->addProductsHistory($data->id, "update", $request->get('username'));
                return response()->json($data);
            } else {
                // TODO:: return and said no this partno
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    // return all productcode with pstatus
    public function allProducts($locale)
    {
        $products = Products::select("partno as name", "pstatus", "active")->where('lang', $locale)->get();

        return response()->json($products);
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
        if ($rows != 'all') {
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
            $aryPstatus[] = Products::PSTATUS_NEW;
        }

        if ($request->get('upcoming') == 'true') {
            $aryPstatus[] = Products::PSTATUS_UP;
        }

        if ($request->get('eol') == 'true') {
            $aryPstatus[] = Products::PSTATUS_EOL;
        }

        if (!empty($aryPstatus)) {
            $products->whereIn("pstatus", $aryPstatus);
        }

        if ($request->get('iscooler') == 'true') {
            $products->where("iscooler", 1);
        }
        $data['total'] = $products->count();

        $products->orderBy($sort, $order);

        if ($rows != 'all') {
            $products->skip($skip)->take($rows);
        }
        $data['rows'] = $products->get();


        return response()->json($data);
    }

    /**
     * 
     */
    public function getProductByCategory() {}

    public function getProductsTagList($locale, Request $request)
    {
        Logger()->debug(" getProductsTagList ");
        return response()->json(Products::select('id','partno')->where('lang', $locale)->orderBy('partno', 'asc')->get());
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
        Logger()->debug("listProductWithImage $locale " . var_export($request->all(), true));
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
            $aryPartno = explode(",", $request->input('partno'));
            $aryPartnoSpace = explode(" ", $request->input('partno'));
            if (count($aryPartno) > 1) {
                $listProducts->whereIn("p.partno", $aryPartno);
            } else if (count($aryPartnoSpace) > 1) {

                $listProducts->whereIn("p.partno", $aryPartnoSpace);
            } else {
                $listProducts->where("p.partno", 'like', '%' . $request->input('partno') . '%');
            }
        }

        $listProducts->where("p.lang", $locale);

        $aryPstatus = [];
        if ($request->input('new') == 'true') {
            $aryPstatus[] = Products::PSTATUS_NEW;
        }

        if ($request->input('upcoming') == 'true') {
            $aryPstatus[] = Products::PSTATUS_UP;
        }

        if ($request->input('eol') == 'true') {
            $aryPstatus[] = Products::PSTATUS_EOL;
        }

        if (!empty($aryPstatus)) {
            $listProducts->whereIn("p.pstatus", $aryPstatus);
        }

        if ($request->input('iscooler') == 'true') {
            Logger()->debug("listProductWithImage  in iscooler");
            $listProducts->where("p.iscooler", 1);
        }


        if ($request->input('rows')) {
            Logger()->debug("listProductWithImage  in rows $locale");
            if ($request->input('rows') != 'all') {
                $listProducts->limit($request->input('rows'));
            }
        } else {
            $listProducts->limit('5');
        }

        $listProducts->orderBy("updated_at",'desc')->orderBy("partno")->groupBy("partno");
        //Logger()->debug("listProductWithImage $locale listProducts " . var_export($listProducts->get(), true));
        return response()->json($listProducts->get());
    }

    /***
     * generate product conf file under menucat
     */
    public function generateConfByMenucat($locale, Request $request, FileService $fileService)
    {

        if ($request->get('menucat')) {
            $username = ($request->has('username') && $request->get('username') ? $request->get('username') : 'SYS');
            Logger()->debug("generateConfByMenucat : DONE  : " . var_export($request->get('menucat'), true));
            $boxes = ProdlistBoxes::where('menucat', strval(sprintf("%04d", $request->get('menucat'))))->get();
            $aryPartno = [];
            Logger()->debug("generateConfByMenucat : DONE  : " . var_export($boxes, true));
            foreach ($boxes as $box) {
                $jsonProduct = $this->showOne($locale, $box->productcode);
                $aryPartno[] = $box->productcode;
                $result = $fileService->createConf('product', $box->productcode . '.conf', $locale,  "[product]\ndetails=" . json_encode($jsonProduct), $username, Products::STATUS_ONE, $box->productcode);
            }
            Logger()->debug("generateConfByMenucat : DONE  : " . var_export($aryPartno, true));
            return response()->json(['result' => $result]);
        } else {
            return  response()->json(['result' => false]);
        }
    }

    /***
     * generate product single conf file 
     */
    public function generateSingleConf($locale, Request $request, FileService $fileService)
    {
        $result = false;
        $username = ($request->has('username') && $request->get('username') ? $request->get('username') : 'SYS');
        Logger()->debug("generateSingleConf : request : " . var_export($request->all(), true));
        if ($request->has('batch') && $request->has('partnos')) {
            Logger()->debug("generateSingleConf : batch :  result : " . var_export($request->all(), true));
            $aryPartno = explode(",", $request->get('partnos'));
            foreach ($aryPartno as $partno) {
                $jsonProduct = $this->showOne($locale, $partno);
                $result = $fileService->createConf('product', $partno . '.conf', $locale,  "[product]\ndetails=" . json_encode($jsonProduct), $username, Products::STATUS_ONE, $partno);
                $this->exportFilesToWeb($locale, $partno, $username);
            }
        } else {
            $partno = $request->get('partno');
            $jsonProduct = $this->showOne($locale, $partno);

            $result = $fileService->createConf('product', $partno . '.conf', $locale,  "[product]\ndetails=" . json_encode($jsonProduct), $username, Products::STATUS_ONE, $partno);
            Logger()->debug("generateSingleConf : partno : " . $partno . ", result : " . var_export($result, true));

            $this->exportFilesToWeb($locale, $partno, $username);
        }

        return response()->json(['result' => $result]);
    }

    /***
     * generate product single conf file 
     */
    public function generateConfOnly($locale, Request $request, FileService $fileService)
    {
        $result = false;
        $username = ($request->has('username') && $request->get('username') ? $request->get('username') : 'SYS');
        Logger()->debug("generateSingleConf : request : " . var_export($request->all(), true));
        if ($request->has('batch') && $request->has('partnos')) {
            Logger()->debug("generateSingleConf : batch :  result : " . var_export($request->all(), true));
            $aryPartno = explode(",", $request->get('partnos'));
            foreach ($aryPartno as $partno) {
                $jsonProduct = $this->showOne($locale, $partno);
                $result = $fileService->createConf('product', $partno . '.conf', $locale,  "[product]\ndetails=" . json_encode($jsonProduct), $username, Products::STATUS_ONE, $partno);
                //  $this->exportFilesToWeb($locale, $partno);
            }
        } else {
            $partno = $request->get('partno');
            $jsonProduct = $this->showOne($locale, $partno);

            $result = $fileService->createConf('product', $partno . '.conf', $locale,  "[product]\ndetails=" . json_encode($jsonProduct), $username, Products::STATUS_ONE, $partno);
            Logger()->debug("generateSingleConf : partno : " . $partno . ", result : " . var_export($result, true));

            //   $this->exportFilesToWeb($locale, $partno);
        }

        return response()->json(['result' => $result]);
    }

    /***
     * export image or file to web
     */
    public function exportFilesToWeb($locale, $partno,$username='system')
    {
        $fileService = new FileService;
        // export files
        //
        //export images from backend to akasa2206 front end
        //
        $images = Images::where('partno', $partno)->get();
        foreach ($images as $image) {
            if ($image->docname) {
                $fileService->exportFiles($image->ctype, $image->docname, $image->partno, $locale,$username);
            }
        }
        //
        //export reviews from backend to akasa2206 front end
        //
        $reviews = ProductReviews::where('partno', $partno)->whereNotNull('reviewsites_id')->get();
        Logger()->debug("exportFilesToWeb : reviews : " . var_export($reviews, true));
        foreach ($reviews as $review) {
            // review image
            if ($review->reviewsites_id) {
                $reviewsite = Reviewsites::whereId($review->reviewsites_id)->first();
                $fileService->exportFiles(FileService::FILE_TYPE_REVIEWSITELOGO, $reviewsite->sitelogo, $partno, $locale,$username);
            }
        }
        //

        //
        //export download from backend to akasa2206 front end
        //
        $downloads = Downloads::where('partno', $partno)->get();
        foreach ($downloads as $dl) {
            if ($dl->docname) {
                $fileService->exportFiles($dl->ftype, $dl->docname, $dl->partno, $locale,$username);
            }
        }
        //
        //export images from backend to akasa2206 front end
        //
        $eurls = ProductEcommerceUrls::where('productcode', $partno)->where("status", "Active")->get();
        foreach ($eurls as $url) {
            if ($url->imglogo) {
                $fileService->exportFiles(FileService::FILE_TYPE_ECOMMERCE_URLS_LOGO, $url->imglogo, $partno, $locale,$username);
            }
        }
    }

    /***
     * generate product list conf file by menucat 
     */
    public function generateProductListByMenucat($locale, Request $request, FileService $fileService)
    {
        try {
            $this->validate(
                $request,
                [
                    'menucat' => 'required',
                ],
                [
                    'menucat.required' => 'menucat is required.',
                ]
            );

            $aryFields = [
                'model',
                'title',
                'name',
                'pstatus',
                'img',
                'menucat',
                'boxitem',
                'filteritem',
                'subfilteritem'
            ];

            if ($request->get('menucat') == "ALL") {
                /** all conf, loading is high  */
                // set_time_limit(6000);
            } else {
                $menucat = strval(sprintf("%04d", $request->get('menucat')));
                /**
                 * filename << with path
                 * menucat
                 * 
                 */
                $category = Navmenu2022::whereId(intval($request->get('menucat')))->first();
                $foldername =   $category->parent;
                $confName = $category->submenu . ".conf";

                // delete the file before process the data of this menucat
                $fileService->deleteProductConf($locale, $confName, 'web2206', $foldername);


                $listProducts = ProdlistBoxes::leftJoin('products as p', 'p.partno', '=', 'prodlist_boxes.productcode');
                $listProducts->select(
                    "p.partno as model",
                    "p.title",
                    "p.name",
                    "p.pstatus",
                    "p.keywords",
                    "i.docname as img",
                    "prodlist_boxes.menucat",
                    "prodlist_boxes.boxno as boxno",
                    "prodlist_boxes.lang",
                    "p.lang"
                );

                $listProducts->where("menucat", $menucat)
                    ->where("prodlist_boxes.lang", $locale)
                    ->where("p.lang", $locale)
                    ->whereIn("p.pstatus", [
                        Products::PSTATUS_CURRENT,
                        Products::PSTATUS_NEW,
                        Products::PSTATUS_PREORDER,
                        Products::PSTATUS_UP
                    ])
                    ->where("p.active", Products::STATUS_ONE)
                    ->where("prodlist_boxes.status", Products::STATUS_ONE);

                $listProducts->leftJoin(
                    DB::raw('(select listpic, docname, ctype,docdir, partno FROM images WHERE listpic = 1 AND ctype="gallery") as i'),
                    function ($join) {
                        $join->on('p.partno', '=', 'i.partno');
                    }
                );
                $boxesData = $listProducts->orderBy('prodlist_boxes.box_seqno', 'asc')->orderBy('prodlist_boxes.seqno', 'asc')->get();
                $boxData = [];
                foreach ($boxesData as $box) {
                    $boxData[$box->boxno][] = $box->toArray();
                }

                foreach ($boxData as $box) {
                    // display in box style
                    $boxitem = count($box);
                    if ($boxitem  > 1) { // in box
                        $aryBoxData = [];
                        foreach ($box as $b) {
                            foreach ($b as $key => $val) {
                                $aryBoxData[$key][] = $val;
                            }
                        }

                        $filterItem = [];
                        for ($i = 0; $i < count($box); $i++) {
                            $prodKeys = ProdKeywords::leftJoin('keyword_list as k', 'prod_keywords.skey', '=', 'k.skey')
                                ->select('k.skey',  'k.display_name', 'k.type as ktype')
                                ->whereIn('prod_keywords.partno', $aryBoxData['model'])->get()->toArray();

                            //Logger()->debug(" generateProductListByMenucat prodKeys : " . var_export($prodKeys, true));

                            foreach ($prodKeys as $k) {
                                $aryKey = json_decode($k['display_name'], true);
                                if (!empty($aryKey[$locale])) {
                                    $k['display_name'] = $aryKey[$locale];
                                    $filterItem[] = $k['display_name'];
                                }
                            }

                            if ($aryBoxData['keywords'][$i]) {
                                $filterItem = array_merge($filterItem, array_map('trim', explode(":", implode(",", $aryBoxData['keywords']))));
                            }
                        }
                        $aryBoxData['filteritem'] = implode(",", $filterItem);

                        // sub subfilteritem
                        $subFilterItems = [];
                        $cntSubFilterItems = 0;
                        $subFilterText = [];
                        foreach ($aryBoxData['model'] as $partnoInBox) {
                            $prodKeys = ProdKeywords::leftJoin('keyword_list as k', 'prod_keywords.skey', '=', 'k.skey')
                                ->select('k.skey',  'k.display_name', 'k.type as ktype')
                                ->where('prod_keywords.partno', $partnoInBox)
                                ->whereNotNull('k.skey')->pluck('k.skey')->toArray();

                            $aryBoxData['subfilteritem'][$cntSubFilterItems] = implode(",", $prodKeys);
                            $cntSubFilterItems++;
                        }

                        $aryBoxData['boxitem'] = count($aryBoxData['model']);



                        $exportData = [];
                        foreach ($aryBoxData as $k => $bData) {
                            Logger()->debug(" generateProductListByMenucat bData : $k " . var_export($bData, true));
                            if (in_array($k, $aryFields)) {
                                if ($k == 'subfilteritem') {
                                    $exportData[$k] = implode("||", $bData);
                                } else {
                                    $exportData[$k] = (is_array($bData) ? implode(",", $bData) : $bData);
                                }
                            }
                        }
                        //Logger()->debug(" generateProductListByMenucat exportData : " . var_export($exportData, true));
                        // call fileService
                        $fileService->createListByMenucat($locale, $foldername, $confName, $exportData);
                    } else { // single
                        $exportData = $box[0];
                        $prodKeys = ProdKeywords::leftJoin('keyword_list as k', 'prod_keywords.skey', '=', 'k.skey')
                            ->select('k.skey',  'k.display_name', 'k.type as ktype')
                            ->where('prod_keywords.partno', $exportData['model'])
                            ->whereNotNull('k.skey')->pluck('k.skey')->toArray();

                        $filterItem = $prodKeys;
                        if ($exportData['keywords']) {
                            $filterItem = array_merge($filterItem, array_map('trim', explode(":", $exportData['keywords'])));
                        }
                        $filterItem = array_map(function ($x) {
                            return str_replace(' ', '', $x);
                        }, $filterItem);

                        $filterItemData = implode(",", array_unique($filterItem));

                        $exportData['boxitem'] = 1;
                        $exportData['filteritem'] = $filterItemData;
                        $exportData['subfilteritem'] = $filterItemData;

                        // call fileService
                        $fileService->createListByMenucat($locale, $foldername, $confName, $exportData);
                    }
                }
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }


    public function generateAllConf($locale,  FileService $fileService)
    {
        // ini_set('max_execution_time', 6000);
        // set_time_limit(6000);
        $num = 50;
        $cnt = 1;
        $username = 'system';
        $allProduct = Products::select('partno', 'exported')->where("lang", '=', $locale)->where('exported', '=', 0)->limit($num)->get();
        Logger()->debug(" generateAllConf $locale , Number : $num, count:" . $allProduct->count());
        foreach ($allProduct as $product) {
            $cnt++;

            $jsonProduct = $this->showOne($locale, $product->partno);
            $fileService->createConf('product', $product->partno . '.conf', $locale,   "[product]\ndetails=" . json_encode($jsonProduct),$username, Products::STATUS_ONE,$product->partno);
            $this->exportFilesToWeb($locale, $product->partno,$username);
            Products::where('partno', $product->partno)->where("lang", '=', $locale)
                ->update(['exported' => 1]);
        }
        echo $cnt;
    }

    public function generateAllConfWithFiles($locale,  FileService $fileService)
    {
        // ini_set('max_execution_time', 6000);
        // set_time_limit(6000);
        $username = 'system';
        $cnt = 1;
        $allProduct = Products::select('partno', 'exported')->where("lang", '=', $locale)->where('exported', '=', 0)->limit(20)->get();
        foreach ($allProduct as $product) {
            $cnt++;

            $jsonProduct = $this->showOne($locale, $product->partno);
            $fileService->createConf('product', $product->partno . '.conf', $locale,   "[product]\ndetails=" . json_encode($jsonProduct), $username,Products::STATUS_ONE, $product->partno);
            Products::where('partno', $product->partno)->where("lang", '=', $locale)
                ->update(['exported' => 1]);

            // export files
            //
            //export images from backend to akasa2206 front end
            //
            $images = Images::where('partno', $product->partno)->get();
            foreach ($images as $image) {
                if ($image->docname) {
                    $fileService->exportFiles($image->ctype, $image->docname, $image->partno, $locale, $username);
                }
            }

            //
            //export download from backend to akasa2206 front end
            //
            $downloads = Downloads::where('partno', $product->partno)->get();
            foreach ($downloads as $dl) {
                if ($dl->docname) {
                    $fileService->exportFiles($dl->ftype, $dl->docname, $dl->partno, $locale, $username);
                }
            }
        }
        echo $cnt;
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

        $boxes = ProdlistBoxes::select('boxno', 'menucat')->where('productcode', $partno)->groupBy("boxno")->where('lang', $locale)->where("is_selected", ProdlistBoxes::ISSELECT_ACTIVE)->get()->toArray();
        if ($boxes) {
            // call productBoxController
            $ProductBoxesCtrl = new productBoxesCtrl;
            $product['boxes'] = $ProductBoxesCtrl->getBoxDataWithImage($locale, $boxes);
        }
        // end boxes

        if ($product['related']) {
            $product['related_products'] = $this->getRelatedProduct($product['related'], $locale);
        }

        // prodlist_boxes is_selected added
        $product['navmenus'] = ProdlistBoxes::select('prodlist_boxes.productcode', 'prodlist_boxes.menucat', 'prodlist_boxes.boxno', 'p_nav.parent as group_cat', 'p_nav.submenu as main_cat', 'nav.submenu as sub_cat', 'p_nav.display_name as main_cat_display_name', 'group_nav.display_name as group_cat_display_name', 'nav.display_name as sub_cat_display_name')
            ->leftJoin('2022_navmenu as nav', 'nav.id', '=', 'prodlist_boxes.menucat')
            ->leftJoin('2022_navmenu as p_nav', 'nav.parent_id', '=', 'p_nav.id')
            ->leftJoin('2022_navmenu as group_nav', 'group_nav.id', '=', 'p_nav.parent_id')
            ->where('prodlist_boxes.productcode', $partno)
            // ->where('prodlist_boxes.lang', $locale)
            ->where('prodlist_boxes.lang', 'en')
            ->get();

        $product['selected_category'] = ProdlistBoxes::select('prodlist_boxes.productcode', 'prodlist_boxes.menucat', 'prodlist_boxes.boxno', 'p_nav.parent as group_cat', 'p_nav.submenu as main_cat', 'nav.submenu as sub_cat', 'p_nav.display_name as main_cat_display_name', 'group_nav.display_name as group_cat_display_name', 'nav.display_name as sub_cat_display_name')
            ->leftJoin('2022_navmenu as nav', 'nav.id', '=', 'prodlist_boxes.menucat')
            ->leftJoin('2022_navmenu as p_nav', 'nav.parent_id', '=', 'p_nav.id')
            ->leftJoin('2022_navmenu as group_nav', 'group_nav.id', '=', 'p_nav.parent_id')
            ->where('prodlist_boxes.is_selected', ProdlistBoxes::ISSELECT_ACTIVE)->where('prodlist_boxes.productcode', $partno)
            //->where('prodlist_boxes.lang', $locale)
            ->where('prodlist_boxes.lang', 'en')
            ->first();

        /// config to wheretobuy folder
        // ->with('productEcommerceUrls:link_name,sale_url,imglogo,seqno')
        // $product['ecommerce_urls'] = ProductEcommerceUrls::select("link_name", "sales_url", "imglogo", "seqno")->where("productcode", $partno)->orderBy("seqno", 'asc')->get();
        //Logger()->debug("showOne product ecommerce_urls " . var_export($product['ecommerce_urls']->count(), true));
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

    public function allPartnos($locale, Request $request)
    {
        try {
            //   return response()->json(Products::where("lang", '=', 'en')->where('partno', 'LIKE', '%'.$request->get('q').'%')->pluck("partno"));
            return response()->json(Products::where("lang", '=', 'en')->pluck("partno"));
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
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

    /***
     * receive the ecommerce url
     * acct name, acct id, name, url , img
     */
    public function ecommerceUrlList($locale, Request $request, FileService $fileService)
    {
        $sort = $request->has('sort') ? $request->get('sort') : 'updated_at';
        $order = $request->has('order') ? $request->get('order') : 'desc';
        $page = $request->has('page') ? $request->get('page') : 1;
        $rows = $request->has('rows') ? $request->get('rows') : 50;
        $skip = ($page - 1) * $rows;

        $urls = ProductEcommerceUrls::where("productcode", $request->get('productcode'))->orderBy($sort, $order);

        $data['total'] = $urls->count();
        $data['rows'] = $urls->skip($skip)->take($rows)->get();
        return response()->json($data);
    }

    /***
     * receive the ecommerce url
     * acct name, acct id, name, url , img
     */
    public function addEcommerceUrl($locale, Request $request, FileService $fileService)
    {
        logger()->debug(" ProductsController : addEcommerceUrl " . var_export($request->all(), true));
        try {
            $this->validate(
                $request,
                [
                    'productcode' => 'required',
                    'crmid' => 'required',
                    'acct_ref' => 'required',
                ],
                [
                    'productcode.required' => 'partno is required.',
                    'crmid.required' => 'Accounts ID is required.',
                    'acct_ref.required' => 'Account Key is required.',

                ]
            );
            $user = $request->get('userInfo');
            logger()->debug(" ProductsController : addEcommerceUrl - " . $request->get('imglogo'));
            $updateOrCreate = ProductEcommerceUrls::updateOrCreate(
                [
                    'crmid' => $request->get('crmid'),
                    'acct_ref' => $request->get('acct_ref'),
                    'productcode' => $request->get('productcode'),
                ],
                [
                    'country_code' => $request->get('country_code'),
                    'continent' => $request->get('continent'),
                    'source_type' => $request->get('source_type'),
                    'link_name' => $request->get('link_name'),
                    'sales_url' => $request->get('sales_url'),
                    'acct_name' => $request->get('acct_name'),
                    //  'imglogo' => $request->get('imglogo'),
                    'exported' => 0,
                    'status' => $request->get('status'),
                    'created_by' => $user['name'],
                    'updated_by' => $user['name'],
                ]
            );

            logger()->debug(" ProductsController : addEcommerceUrl updateOrCreate" . var_export($updateOrCreate, true));
            if ($updateOrCreate) {

                if ($request->has('imglogo') && $request->get('imglogo')) {
                    // handle img
                    $fileService->storeLogoEcommUrl(FileService::FILE_TYPE_AKASAONE_ACCTLOGO, $request->get('imglogo'));
                }
                return response()->json(['result' => true, 'data' => $updateOrCreate]);
            } else {
                return response()->json(['result' => false]);
            }
            // ProductEcommerceUrl


        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    /***
     * receive the ecommerce url
     * acct name, acct id, name, url , img
     */
    public function addBatchEcommerceUrl($locale, Request $request, FileService $fileService)
    {
        logger()->debug(" ProductsController : addBatchEcommerceUrl " . var_export($request->all(), true));
        try {
            $ids = [];
            $user = $request->get('userInfo');
            $allData = $request->get('data');
            foreach ($allData as $data) {
                logger()->debug(" ProductsController : addBatchEcommerceUrl " . var_export($data, true));
                $updateOrCreate = ProductEcommerceUrls::updateOrCreate(
                    [
                        'crmid' => $data['crmid'],
                        'acct_ref' => $data['acct_ref'],
                        'productcode' => $data['productcode'],
                    ],
                    [
                        'country_code' => $data['country_code'],
                        'continent' => $data['continent'],
                        'source_type' => $data['source_type'],
                        'link_name' => $data['link_name'],
                        'sales_url' => $data['sales_url'],
                        'acct_name' => $data['acct_name'],
                        //  'imglogo' => $data['imglogo'],
                        'exported' => 0,
                        'status' => $data['status'],
                        'created_by' => $user['name'],
                        'updated_by' => $user['name'],
                    ]
                );
                if ($updateOrCreate) {
                    $ids[] = $data['id'];
                }
            }

            if (!empty($ids)) {
                return response()->json(['result' => true, 'data' => $ids]);
            } else {
                return response()->json(['result' => false]);
            }

            // $this->validate(
            //     $request,
            //     [
            //         'productcode' => 'required',
            //         'crmid' => 'required',
            //         'acct_ref' => 'required',
            //     ],
            //     [
            //         'productcode.required' => 'partno is required.',
            //         'crmid.required' => 'Accounts ID is required.',
            //         'acct_ref.required' => 'Account Key is required.',

            //     ]
            // );
            // $user = $request->get('userInfo');
            // logger()->debug(" ProductsController : addEcommerceUrl - " . $request->get('imglogo'));

            // logger()->debug(" ProductsController : addEcommerceUrl updateOrCreate" . var_export($updateOrCreate, true));
            // if ($updateOrCreate) {

            //     if ($request->has('imglogo') && $request->get('imglogo')) {
            //         // handle img
            //         $fileService->storeLogoEcommUrl(FileService::FILE_TYPE_AKASAONE_ACCTLOGO, $request->get('imglogo'));
            //     }
            //     return response()->json(['result' => true, 'data' => $updateOrCreate]);
            // } else {
            //     return response()->json(['result' => false]);
            // }
            // // ProductEcommerceUrl


        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    /***
     * receive the ecommerce url
     * acct name, acct id, name, url , img
     */
    public function disableEcommerceUrl($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'productcode' => 'required',
                    'crmid' => 'required',
                    'acct_name' => 'required',
                ],
                [
                    'productcode.required' => 'partno is required.',
                    'crmid.required' => 'Accounts ID is required.',
                    'acct_name.required' => 'Account Name is required.',

                ]
            );
            logger()->debug(" ProductsController : disableEcommerceUrl " . var_export($request->all(), true));
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    /***
     * receive the ecommerce url
     * acct name, acct id, name, url , img
     */
    public function removeEcommerceUrl($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'productcode' => 'required',
                    'crmid' => 'required',
                    'acct_name' => 'required',
                ],
                [
                    'productcode.required' => 'partno is required.',
                    'crmid.required' => 'Accounts ID is required.',
                    'acct_name.required' => 'Account Name is required.',

                ]
            );
            logger()->debug(" ProductsController : removeEcommerceUrl " . var_export($request->all(), true));
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    /***
     * receive the ecommerce url
     * acct name, acct id, name, url , img
     */
    public function updateEcommerceUrl($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'productcode' => 'required',
                    'crmid' => 'required',
                    'acct_name' => 'required',
                ],
                [
                    'productcode.required' => 'partno is required.',
                    'crmid.required' => 'Accounts ID is required.',
                    'acct_name.required' => 'Account Name is required.',

                ]
            );
            logger()->debug(" ProductsController : updateEcommerceUrl " . var_export($request->all(), true));
            $eurl = ProductEcommerceUrls::where('crmid', $request->get('crmid'))
                ->where('productcode', $request->get('productcode'))
                ->update([
                    'seqno' => $request->get('seqno'),
                    // 'link_name' => $request->get('link_name'),
                    // 'sale_url' => $request->get('sale_url'),
                    // 'account_name' => $request->get('account_name'),
                    // 'imglogo' => $request->get('imglogo'),
                    'exported' => 0,
                    'status' => $request->get('status'),
                ]);
            if ($eurl) {
                return response()->json(['result' => true, 'data' => $eurl]);
            } else {
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function  exportEcommerceUrl($locale, Request $request)
    {
        try {
            // top sales : order by productcode,tot desc 
            $data = ProductEcommerceUrls::select("product_ecommerce_urls.*", 't.tot')->leftJoin('top_sales_qty as t', function ($join) {
                $join->on('product_ecommerce_urls.productcode', '=', 't.productcode');
                $join->on('product_ecommerce_urls.acct_ref', '=', 't.acct_ref');
            })->orderBy("t.tot", 'desc')->get();

            $confData = [];
            if ($data) {
                foreach ($data->toArray() as $d) {

                    // get img
                    $so = SalesOffices::where('acct_ref', $d['acct_ref'])->first();
                    if ($so) {
                        $d['logo'] = $so->logo;
                    }
                    $urlData[$d['productcode']][] = $d;
                }
            }

            if ($urlData) {
                $fileService = new FileService();
                foreach ($urlData as $p => $url) {
                    // create config file
                    $fileService->createConf('where2buy', $p . '.conf', $locale,  "[where2buy]\nsales_urls=" . json_encode($url));
                }
                return response()->json(['result' => true, 'data' => $urlData]);
            } else {
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function changeLogsList($locale, Request $request)
    {
        $sort = $request->has('sort') ? $request->get('sort') : 'cid';
        $order = $request->has('order') ? $request->get('order') : 'desc';
        $page = $request->has('page') ? $request->get('page') : 1;
        $rows = $request->has('rows') ? $request->get('rows') : 50;
        $skip = ($page - 1) * $rows;

        $urls = ProductChangeLogs::where("partno", $request->get('partno'))->orderBy($sort, $order);

        $data['total'] = $urls->count();
        $data['rows'] = $urls->skip($skip)->take($rows)->get();
        return response()->json($data);
    }

    public function testfp($locale)
    {
        echo "hello";
        $confData = "";
        printf($confData, "model = %s\n", "test here");
        printf($confData, "title = %s\n", "test here title");

        echo "<pre>";
        print_r($confData);
        echo "</pre>";
    }

    public function reseqnoBox($locale)
    {
        $allMenu = ProdlistBoxes::whereIn('productcode', ['AK-CBPE05-30B', 'A-NUC103-M1B', 'AK-CBPW34-BK', 'AK-CC9501BP01', 'AK-CC9502BP01', 'AK-CC9503BP01', 'AK-CC9504BP01', 'AK-CC9505BP01', 'A-NUC107-M1B', 'A-NUC22-WBKT', 'AK-CC4021KT01', 'AK-ENU4M2-01', 'A-NUC102-M1B', 'AK-ENU3M2-08', 'AK-CC7302BP03', 'AK-CBDP27-20BK', 'AK-DK09U3-WHCMV2', 'AK-CBPW33-15', 'AK-FN128', 'A-NUC105-M1B', 'A-NUC106-M1B', 'AK-FN071', 'A-RA15-M2B', 'A-NUC93-M2B', 'A-NUC101-M1B', 'AK-CBUB70-12BK', 'AK-DK09U3-WHV2', 'AK-CC4022KT01', 'AK-CC4030HP01', 'AK-CC4021HP01V1', 'A-STX15-M1B', 'A-STX15-FP02', 'A-STX15-FP01', 'A-ITC094-M1B', 'AK-FN123', 'A-M2HS04-BK', 'A-ITC100-M1B', 'AK-CC7406BP01', 'A-RA13-M2B', 'AK-T695-4G', 'AK-T685-4G', 'AK-4010MS-KT05', 'AK-9225LS-KT05', 'AK-8025LS-KT05', 'AK-8025HS-KT05', 'AK-8025MS-KT05', 'AK-6025MS-KT05', 'AK-6015MS-KT05', 'AK-5010MS-KT05', 'AK-1225LS-KT05', 'DFS122512L', 'AK-CBLD13-85BK', 'AK-CR-14BK', 'A-NUC96-M1B', 'AK-CC4026HP01', 'AK-PE200-01', 'AK-CBCA32-18BK', 'AK-CBPW32-30BK', 'AK-CBPW31-30BK', 'AK-CBPW30-BK', 'AK-CBPW29-BK', 'AK-CC6616HP01', 'AK-CC1111BP01', 'AK-CC7501BP01', 'AK-TT600-KT03', 'AK-CBCA31-18BK', 'AK-CBCA30-08WH', ' A-NUC102-M1B', 'AK-CBPE05-30B', 'A-ITX60-S1B'])
        ->where('lang', $locale)
            ->orderBy('menucat')->groupBy('menucat')->get();


        foreach ($allMenu as $menu) {

            $menucat = $menu->menucat;
            echo "<pre>";
            print_r($menucat);
            echo "</pre>";

            // first update box_seqno + 5000
            $allBoxes = ProdlistBoxes::where('menucat', $menucat)->where('lang', $locale)->get();
            foreach ($allBoxes as $box) {

                $seqno = (int)$box->box_seqno + 5000;

                ProdlistBoxes::whereId($box->id)->update(['box_seqno' => $seqno]);
            }

            // second update box_seqno from 0010 orderby publish_date

            $prodlistData = ProdlistBoxes::select('p.partno', 'p.pstatus', 'prodlist_boxes.id', 'prodlist_boxes.box_name', 'prodlist_boxes.boxno', 'prodlist_boxes.box_seqno', 'prodlist_boxes.menucat', "p.publish_date")
                ->leftJoin('products as p', 'p.partno', '=', 'prodlist_boxes.productcode')
                ->where("menucat", $menucat)
                ->where("p.pstatus", 2)
                ->where('prodlist_boxes.lang', $locale)
                ->orderBy('prodlist_boxes.box_seqno')
                ->orderBy(DB::raw("STR_TO_DATE(CONCAT('01-', p.publish_date),'%d-%m/%Y')"), 'DESC')
                ->get();

            $newSeq = 0;
            foreach ($prodlistData as $data) {
                $seq = sprintf('%04d', $newSeq += 10);
                echo "<pre>";
                print_r($seq);
                echo "</pre>";
                echo "<pre>";
                print_r($data->boxno);
                echo "</pre>";
                $updated = ProdlistBoxes::where('boxno', $data->boxno)->where('menucat', $menucat)->where('lang', $locale)->update(['box_seqno' =>$seq ]);
                echo "<pre>";
                print_r($updated);
                echo "</pre>";
            }
        }
    }
}
