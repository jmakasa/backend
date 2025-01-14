<?php

namespace App\Http\Controllers;

use App\Models\Navmenu2022;
use App\Models\CRM_818\Navmenu2022818;
use App\Models\Navmenu2022Filter;
use App\Models\ProdlistBoxes;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\ValidationException;
use Redirect;



class NavmenuController extends Controller
{
    protected $imgPath;
    protected $imgWebPath;
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['exportNavmenu', 'jsonNavmenu2022List', 'update', 'backendNavmenu','getNavmenuListByPartno',"getSeletedFilterList","updateSelectedFilterSeqno"]]);
        $this->imgWebPath = "/img/product/banner/";
        $this->imgPath = env("AKASAWEBDIR_2206", "/akasa/www/akasa2206") . $this->imgWebPath;
    }

/**
 * 
 * get selected filter list
 */

 public function getSeletedFilterList($locale, Request $request){
    try {
        $this->validate(
            $request,
            [
                'menucat' => 'required',
            ],
            [
                'menucat.required' => 'submenu is required.',
            ]
        );

        $navFiler= Navmenu2022Filter::where('menucat',$request->get("menucat"))->orderBy("seqno","asc")->get()->toArray();

        return response()->json(['result' => true,"rows"=> $navFiler]); 

    } catch (ValidationException $ex) {
        return $ex->validator->errors();
    }
 }

 public function updateSelectedFilterSeqno($locale, Request $request){
    try {
        $this->validate(
            $request,
            [
                'id' => 'required',
                'seqno' => 'required',  
            ],
            [
                'id.required' => 'ID is required.',
                'seqno.required' => 'SEQNO is required.',
            ]
        );

        $update = Navmenu2022Filter::whereId($request->get('id'))
                    ->update(['seqno'=> $request->get('seqno')]);

        

        return response()->json(['result' => $update]); 

    } catch (ValidationException $ex) {
        return $ex->validator->errors();
    }
 }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $bearerToken = $request->header('Authorization');
        $allCategories = Navmenu2022::with('children')->get()->toArray();
        // logger()->debug(var_export($allCategories,true));
        $getEasyTreeData = $this->easyTreeData($allCategories, "name");
        //   logger()->debug(" --- final tree datat ----" . var_export($getEasyTreeData, true));
        $categories = Navmenu2022::whereNull('parent_id')->orderBy('seqno', 'asc')->get();
        return view('admin.Navmenu2022.index', compact('categories', "bearerToken"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Navmenu2022::whereNull('parent_id')->orderBy('seqno', 'asc')->get();
        logger()->debug("Navmenu2022 create");
        return view('admin.Navmenu2022.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        logger()->debug(" Navmenu2022 - Store : " . var_export($request->all(), true));
        $request->request->add(['parent' => $this->getParentById($request->input('parent_id'))]);
        $Navmenu2022 = (new Navmenu2022)
            ->validateAndFill($request->all())
            ->setAttribute('status', Navmenu2022::STATUS_ACTIVE);
        if ($request->img_file) {
            $fileName = uniqid('cat_') . '.' . $request->img_file->extension();
            $request->img_file->move($this->imgPath, $fileName);
            $Navmenu2022->img  = $this->imgWebPath . $fileName;
        }
        // set default value 
        // $Navmenu2022->name = $this->assignDefaultValue($request->input("name")['en'], $request->input('name'));
        // $Navmenu2022->desc = $this->assignDefaultValue($request->input("desc")['en'], $request->input('desc'));
        logger()->debug(" Navmenu2022 - Store data : " . var_export($Navmenu2022, true));
        if ($Navmenu2022->save()) {
            logger()->debug(" Navmenu2022 - Store data : SAVED" . var_export($request->all(), true));
            return redirect()->route('admin.Navmenu2022_list', [config('app.locale')])->with('status', 'Navmenu2022 is added');
        } else {
            logger()->debug(" Navmenu2022 - Store data : NO inserted" . var_export($request->all(), true));
            return back()->with('autofocus', true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Navmenu2022  $Navmenu2022
     * @return \Illuminate\Http\Response
     */
    public function show(Navmenu2022 $Navmenu2022)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Navmenu2022  $Navmenu2022
     * @return \Illuminate\Http\Response
     */
    public function edit($locale, $id)
    {
        logger()->debug(var_export($id, true));
        $getNavmenu2022 = Navmenu2022::whereId($id)->first();
        logger()->debug(var_export($getNavmenu2022, true));

        $categories = Navmenu2022::whereNull('parent_id')->orderBy('seqno', 'asc')->get();
        return view('admin.Navmenu2022.edit', compact('categories', "getNavmenu2022"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Navmenu2022  $Navmenu2022
     * @return \Illuminate\Http\Response
     */
    public function update($locale, Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'json' => 'required',
                    'submenu' => 'required',
                ],
                [
                    'json.required' => 'display_name is required.',
                    'submenu.required' => 'submenu is required.',
                ]
            );

            if ($request->input("action") == 'update') {
                logger()->debug(" Navmenu2022 - update : " . var_export($request->all(), true));
                $Navmenu2022 = Navmenu2022::whereId($request->input("id"))->first();
                
                $Navmenu2022->submenu = $request->input("submenu");
                $Navmenu2022->parent_id = $request->input('parent_id');
                // find parent - submenu
                $Navmenu2022->parent = $this->getParentById($request->input('parent_id'));
                $Navmenu2022->title = $request->input("title");
                $Navmenu2022->desc = $request->input("desc");
                $Navmenu2022->seqno = $request->input('seqno');
                $Navmenu2022->has_child = ($request->input('has_child')?1:0);
                $Navmenu2022->status = $request->input('status');
                $Navmenu2022->is_display_image = ($request->input('is_display_image')?1:0);
                $Navmenu2022->css_style = $request->input('css_style');
                $aryDisplayname = [];
                foreach($request->input('json') as $key => $value){
                    $aryDisplayname[$key] = $value;
                    logger()->debug(" Navmenu2022 - json array  : $key => $value ");
                }
                $Navmenu2022->display_name = $aryDisplayname['en'];
                $Navmenu2022->json = $request->input('json');
                //$Navmenu2022->json = json_encode($aryDisplayname);
                // 818
                $Navmenu2022818 = Navmenu2022818::whereId($request->input("id"))->first();
                
                $Navmenu2022818->submenu = $request->input("submenu");
                $Navmenu2022818->parent_id = $request->input('parent_id');
                // find parent - submenu
                $Navmenu2022818->parent = $this->getParentById($request->input('parent_id'));
                $Navmenu2022818->title = $request->input("title");
                $Navmenu2022818->desc = $request->input("desc");
                $Navmenu2022818->seqno = $request->input('seqno');
                $Navmenu2022818->has_child = ($request->input('has_child')?1:0);
                $Navmenu2022818->status = $request->input('status');
                $Navmenu2022818->is_display_image = ($request->input('is_display_image')?1:0);
                $Navmenu2022818->css_style = $request->input('css_style');

                $Navmenu2022818->display_name = $aryDisplayname['en'];
                $Navmenu2022818->json = $request->input('json');

                
            } else {
                logger()->debug(" Navmenu2022 - create : " . var_export($request->all(), true));
                // if new, id = create
                if ($request->input("id") == null) {
                    $getCnt = Navmenu2022::where("parent_id", $request->input("parent_id"))->count();
                    $newId = $request->input("parent_id") * 10 +  $getCnt + 1;
                    $request->merge([
                        'id' => $newId,
                    ]);
                }
                $request->request->add([
                    'parent' => $this->getParentById($request->input('parent_id')),
                    'has_child' => ($request->input('has_child')?1:0),
                    'is_display_image' => ($request->input('is_display_image')?1:0),
                    'json' => json_encode($request->input('json'))
                ]);

                $Navmenu2022 = (new Navmenu2022)
                    ->validateAndFill($request->all())
                    ->setAttribute('status', Navmenu2022::STATUS_ACTIVE);
                $Navmenu2022818 = (new Navmenu2022818)
                    ->validateAndFill($request->all())
                    ->setAttribute('status', Navmenu2022::STATUS_ACTIVE);
            }

            // set default value 
            if ($request->imagefile) {
                $fileName = $request->imagefile->getClientOriginalName();
                $request->imagefile->move($this->imgPath, $fileName);
                $Navmenu2022->docname  = $this->imgWebPath . $fileName;
                $Navmenu2022818->docname  = $this->imgWebPath . $fileName;
            }
            //   logger()->debug(" Navmenu2022 - update data : " . var_export($Navmenu2022,true));
            if ($result = $Navmenu2022->save() && $Navmenu2022818->save()) {
                logger()->debug(" Navmenu2022 - update data : SAVED" . var_export($result, true));
                return response()->json(['result' => $result]);
                //     return redirect()->route('admin.Navmenu2022_list', [config('app.locale')])->with('status', 'Navmenu2022 is Updated');
            } else {
                logger()->debug(" Navmenu2022 - update data : NO inserted" . var_export($request->all(), true));
                return response()->json(['result' => false]);
                //return back()->with('autofocus', true);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function getParentById($id)
    {
        if ($id) {
            $getParent = Navmenu2022::whereId($id)->first()->toArray();
            return $getParent['submenu'];
        } else {
            return 'Home';
        }
    }

    public function create_new($locale, Request $request)
    {
        logger()->debug(" Navmenu2022 - Store : " . var_export($request->all(), true));
        $request->request->add([
            'parent' => $this->getParentById($request->input('parent_id')),
            'has_child' => ($request->input('has_child')?1:0),
            'is_display_image' => ($request->input('is_display_image')?1:0),
            'json' => json_encode($request->input('json'))
        ]);
        $Navmenu2022 = (new Navmenu2022)
            ->validateAndFill($request->all())
            ->setAttribute('status', Navmenu2022::STATUS_ACTIVE);
            if ($request->imagefile) {
                $fileName = $request->imagefile->getClientOriginalName();
                $request->imagefile->move($this->imgPath, $fileName);
                $Navmenu2022->docname  = $this->imgWebPath . $fileName;
            }

        logger()->debug(" Navmenu2022 - create_new data : " . var_export($Navmenu2022, true));
        if ($Navmenu2022->save()) {
            logger()->debug(" Navmenu2022 - update data : SAVED" . var_export($request->all(), true));
            return response()->json(['result' => true]);
            //     return redirect()->route('admin.Navmenu2022_list', [config('app.locale')])->with('status', 'Navmenu2022 is Updated');
        } else {
            logger()->debug(" Navmenu2022 - update data : NO inserted" . var_export($request->all(), true));
            return response()->json(['result' => false]);
            //return back()->with('autofocus', true);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Navmenu2022  $Navmenu2022
     * @return \Illuminate\Http\Response
     */
    public function destroy(Navmenu2022 $Navmenu2022)
    {
        //
    }

    public function delete(Request $request)
    {
        // TODO ::
    }

    /**
     * 
     */
    public function getNavmenuListByPartno($locale, Request $request){
        // if (!$this->hasLoginFromMarketing()) {
        //     // redirect to login
        //     $currenturl = $request->url();

        //  //   dd($currenturl);
        //     $host = request()->getHttpHost();
        //     $url = "http://" . $host . "/marketing/login.php?returnUrl=" . $currenturl;
        //     return Redirect::to($url);
        // }
       // $request->merge(['partno' => $request->route('partno')]);

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

            $prodlistBoxes = ProdlistBoxes::where('productcode', $request->get('partno'))->whereLang($locale)->orderBy("menucat","asc")->get();
            $aryMenu =$this->activeAryNavmenu2022ListOneLevel($locale);
            $aryResultData = [];
            foreach ($prodlistBoxes as $pb){
                $id = (int)$pb->menucat;
                
                    $aryMenu[$id]['is_selected'] = $pb->is_selected;
                    $aryMenu[$id]['pb_id'] = $pb->id;
                
                $aryResultData[] = $aryMenu[$id];
            }
            
            return response()->json($aryResultData);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }

        
    }

    /**
     * generate conf file for menu
     */
    public function exportNavmenu($locale, FileService $fileService)
    {
        //   logger()->debug(" --- exportNavmenu ----" . var_export($aryMenus, true));
        $content = [];
        $content[] = "[json]\njson_menu=" . json_encode($this->activeAryNavmenu2022List($locale));
        $content[] = "\nfilter_menucat=" . json_encode($this->activeAryNavmenu2022ListOneLevel($locale));

        if ($fileService->createConf('navimenu', 'navi_2206.conf', $locale,  implode("\n\n", $content))) {
            return response()->json(['result' => true]);
        } else {
            return response()->json(['result' => false]);
        }
    }

    /** 
     * return active nav menu
     */
    public function activeAryNavmenu2022List($locale = 'en')
    {
        //SELECT JSON_EXTRACT('{"a":1,"b":"stringdata"}','$.b');
        $homeMenus = Navmenu2022::select('id', 'parent_id', 'parent', 'submenu', 'title', 'desc', 'docname', 'display_name', 'is_display_image','json')
            ->whereParentId("0")->whereStatus(config('constants.status.active'))
            ->whereLang($locale)->get();
        $aryMenus = [];
        $aryParam = ['id', "parent_id", "parent", "submenu", "title", "desc", "docname", "display_name", 'is_display_image','json'];
        logger()->debug(" --- activeAryNavmenu2022List ----" . var_export($homeMenus, true));
        foreach ($homeMenus as $menu) {
            foreach ($aryParam as $param) {
                $aryMenus[$menu['id']][$param] = $menu[$param];
            }
            //            $aryMenus[$menu['id']]['parent_id'] = $menu['parent_id'];
            foreach ($menu->recurringActiveChildren->toArray() as $submenu) {
                // logger()->debug(" --- activeAryNavmenu2022List ----" . var_export($submenu, true));
                foreach ($aryParam as $param) {
                    $aryMenus[$menu['id']]['children'][$submenu['id']][$param] = $submenu[$param];
                }
                //  $aryMenus[$menu['id']]['children'][$submenu['id']]['parent_id'] = $submenu['parent_id'];
                foreach ($submenu['children'] as $lastMenu) {
                    foreach ($aryParam as $param) {
                        $aryMenus[$menu['id']]['children'][$submenu['id']]['children'][$lastMenu['id']][$param] = $lastMenu[$param];
                    }
                    //$aryMenus[$menu['id']]['children'][$submenu['id']]['children'][$lastMenu['id']]['parent_id'] = $lastMenu['parent_id'];
                }
            }
            //     logger()->debug(" --- activeAryNavmenu2022List ----" . var_export($menu->children->toArray(), true));

        }
        return $aryMenus;
    }

    private function getNavmenuList($locale){
        $aryMenucatField = ['id', 'd_group_cat', 'group_cat', 'main_cat', 'sub_cat', 'docname', 'title', 'desc'];

        $aryData = DB::table('2022_navmenu AS a')
            ->select('b.display_name as d_group_cat', 'b.parent as group_cat', 'b.submenu as main_cat',  'a.submenu as sub_cat', 'a.id', 'a.docname', 'a.title', 'a.desc')
            ->leftJoin('2022_navmenu AS b', 'a.parent_id', '=', 'b.id')
            ->where('a.parent_id', '<>', "")
            ->where('a.lang',$locale)
            ->orderBy('a.id', 'asc')->get();
            return $aryData;
    }

    public function activeAryNavmenu2022ListOneLevel($locale = 'en')
    {
        $aryMenucatField = ['id', 'd_group_cat', 'group_cat', 'main_cat', 'sub_cat', 'docname', 'title', 'desc','submenu_json','parent_json'];

        $aryData = DB::table('2022_navmenu AS a')
            ->select('b.display_name as d_group_cat', 'b.parent as group_cat', 'b.submenu as main_cat',  'a.submenu as sub_cat', 'a.id', 'a.docname', 'a.title', 'a.desc', 'a.json as submenu_json', 'b.json as parent_json')
            ->leftJoin('2022_navmenu AS b', 'a.parent_id', '=', 'b.id')
            ->where('a.parent_id', '<>', "")
            ->where('a.lang',$locale)
            ->orderBy('a.id', 'asc')->get()->toArray();
           
        $aryMenucat = [];
        foreach ($aryData as $obj) {
            $row = (array)$obj;
            //  dd($row);
            foreach ($aryMenucatField as $field) {
                switch ($field){
                    case 'submenu_json':
                        foreach (json_decode($row[$field]) as $key => $txt) {
                            $aryMenucat[$row['id']]['sub_title_' . $key] = $txt;
                        }
                        UNSET($row[$field]);
                    break;
                    case 'parent_json':
                        foreach (json_decode($row[$field]) as $key => $txt) {
                            $aryMenucat[$row['id']]['main_title_' . $key] = $txt;
                        }
                    break;
                    default:
                        $aryMenucat[$row['id']][$field] = $row[$field];
                    break;
                }
            }
        }
        return $aryMenucat;
    }

    /** 
     * return ALL nav menu
     */
    public function aryNavmenu2022List()
    {
        $homeMenus = Navmenu2022::select('id', 'parent_id', 'parent', 'submenu', 'title', 'desc', 'docname', 'display_name')->whereParentId("0")->get();
        $aryMenus = [];
        foreach ($homeMenus as $menu) {
            $aryMenus[$menu['id']]['id'] = $menu['id'];
            $aryMenus[$menu['id']]['parent_id'] = $menu['parent_id'];
            $aryMenus[$menu['id']]['parent'] = $menu['parent'];
            $aryMenus[$menu['id']]['submenu'] = $menu['submenu'];
            $aryMenus[$menu['id']]['title'] = $menu['title'];
            $aryMenus[$menu['id']]['desc'] = $menu['desc'];
            $aryMenus[$menu['id']]['docname'] = $menu['docname'];
            $aryMenus[$menu['id']]['display_name'] = $menu['display_name'];
            foreach ($menu->recurringchildren->toArray() as $submenu) {
                // logger()->debug(" --- aryNavmenu2022List ----" . var_export($submenu, true));
                $aryMenus[$menu['id']]['children'][$submenu['id']]['id'] = $submenu['id'];
                $aryMenus[$menu['id']]['children'][$submenu['id']]['parent_id'] = $submenu['parent_id'];
                $aryMenus[$menu['id']]['children'][$submenu['id']]['parent'] = $submenu['parent'];
                $aryMenus[$menu['id']]['children'][$submenu['id']]['submenu'] = $submenu['submenu'];
                $aryMenus[$menu['id']]['children'][$submenu['id']]['title'] = $submenu['title'];
                $aryMenus[$menu['id']]['children'][$submenu['id']]['desc'] = $submenu['desc'];
                $aryMenus[$menu['id']]['children'][$submenu['id']]['docname'] = $submenu['docname'];
                $aryMenus[$menu['id']]['children'][$submenu['id']]['display_name'] = $submenu['display_name'];
                foreach ($submenu['children'] as $lastMenu) {
                    $aryMenus[$menu['id']]['children'][$submenu['id']]['children'][$lastMenu['id']]['id'] = $lastMenu['id'];
                    $aryMenus[$menu['id']]['children'][$submenu['id']]['children'][$lastMenu['id']]['parent_id'] = $lastMenu['parent_id'];
                    $aryMenus[$menu['id']]['children'][$submenu['id']]['children'][$lastMenu['id']]['parent'] = $lastMenu['parent'];
                    $aryMenus[$menu['id']]['children'][$submenu['id']]['children'][$lastMenu['id']]['submenu'] = $lastMenu['submenu'];
                    $aryMenus[$menu['id']]['children'][$submenu['id']]['children'][$lastMenu['id']]['title'] = $lastMenu['title'];
                    $aryMenus[$menu['id']]['children'][$submenu['id']]['children'][$lastMenu['id']]['desc'] = $lastMenu['desc'];
                    $aryMenus[$menu['id']]['children'][$submenu['id']]['children'][$lastMenu['id']]['docname'] = $lastMenu['docname'];
                    $aryMenus[$menu['id']]['children'][$submenu['id']]['children'][$lastMenu['id']]['display_name'] = $lastMenu['display_name'];
                }
            }

            //     logger()->debug(" --- aryNavmenu2022List ----" . var_export($menu->children->toArray(), true));

        }
        return $aryMenus;
    }

    /**
     * generate newmenu to backend marketing/templates/newmenu_2022.tpl
     */
    public function backendNavmenu($locale, FileService $fileService)
    {
        $aryNavmenus = $this->aryNavmenu2022List();

        $navmenus = "<div class=\"easyui-panel\" style=\"width:980px;padding:5px;\" data-options=\"border:false\">\n";
        $cntMainNav = 0;
        $cnt2ndNav = 0;

        foreach ($aryNavmenus as $navmenu) {
            $cntMainNav++;
            $navmenus .= "<a href=\"javascript:showlist('" . $navmenu['id'] . "','" . $navmenu['submenu'] . "')\" class=\"easyui-menubutton\" data-options=\""
                . "menu:'#mm" . $cntMainNav . "'"
                . '">' . $navmenu['display_name'] . "</a>\n";
        }
        // $navmenus .= "<a href=\"#\" class=\"easyui-linkbutton\" iconCls=\"icon-display\" plain=\"false\""
        //     . " onclick=\"OpenInNewTab('manproducts.php?action=viewlist&webmenu=old')\">Old AKASA10</a>\n"
        //     . "<a href=\"logout.php\" class=\"easyui-linkbutton\" iconCls=\"icon-box-arrow-right\" plain=\"true\">Logout</a>\n"
        //     . "</div>";


            foreach ($aryNavmenus as $navmenu) {
                $cnt2ndNav++;
                $navmenus .= "\n";
                $navmenus .= '<div id="mm' . $cnt2ndNav . '">';
                foreach ($navmenu['children'] as $key => $children) {
                    //data-options="name:'new'" <div data-options='id:11, text='"CPU COOLERS CONSUMER" >
                   // $navmenus .= "\n<div data-options='id:" . $key . ' >\n<span onclick="javascript:showlist('."'".$key."'".'>' . $children['submenu'] . "</span>\n<div>\n";
                   $navmenus .="\n<div>";
                    $navmenus .= "\n".'<span onclick="javascript:showlist(\''.$key.'\',\''.$children['submenu']."')\">".$children['submenu']."</span>";
                    $navmenus .="\n<div>";
                    if (isset($children['children']) && $children['children']) {
                        foreach ($children['children'] as $k => $child) {
                            $navmenus .= '<div href="javascript:showlist(\'' . $k . '\',\'' . $navmenu['submenu'] . ' (' . $children['submenu'] . '): ' . $child['submenu'] . "')\">" . $child['submenu'] . "</div>\n";
                        }
                    }
                    $navmenus .= "</div>\n</div>\n";
                }
                $navmenus .= "</div>\n";
            }
            $navmenus .= "</div>";
        //    echo $navmenus;
        //  logger()->debug(" --- backendNavmenu ----" . var_export($navmenus, true));
        if ($fileService->createConf('marketing_tpl', 'newmenu_2022.tpl', $locale,  $navmenus)) {
            return response()->json(['result' => true]);
        } else {
            return response()->json(['result' => false]);
        }
    }

    public function jsonNavmenu2022List($locale, $state = null)
    {
        logger()->debug(" jsonNavmenu2022List " . $state . ", locale:".$locale);
        if ($state == 'open') {
            $homeMenus = Navmenu2022::select('id', 'parent_id', 'parent', 'submenu', 'title', 'desc', 'docname', 'status', 'display_name','json','seqno','is_display_image','has_child', DB::raw("'open' as state"))->whereParentId("0")->whereLang($locale)
                ->with(['children' => function ($query) use ($locale) {
                    $query->select('*')->selectRaw("'open' as state");
                }])->get();
          //  return response()->json($homeMenus);
        } else {
            $homeMenus = Navmenu2022::select('id', 'parent_id', 'parent', 'submenu', 'title', 'desc', 'docname', 'display_name','json','seqno','is_display_image','has_child', 'status', DB::raw("'closed' as state"))->whereParentId("0")->whereLang($locale)
                ->with(['children' => function ($query) use ($locale) {
                    $query->select('*')->selectRaw("'closed' as state");
                }])->get();
        }

       // logger()->debug(" jsonNavmenu2022List " . var_export($homeMenus,true));
        if ($homeMenus->count() > 0){
            return response()->json($homeMenus);
        } else {
            $homeMenus = array (
                'id' => 1,
                'text'=>"No Result"
            );
            return response()->json($homeMenus);
        }
    }

    public function easyTreeData($data, $textKey)
    {
        $aryData = [];
        $cnt = 0;
        foreach ($data as $d) {
            $aryData[$cnt]["id"] = $d['id'];
            $aryData[$cnt]['text'] = $d[$textKey];

            if (array_key_exists('children', $d)) {
                $aryData[$cnt]['children'] = $this->easyTreeHasChild($d['children'], $textKey);
            }
            $cnt++;
        }
        logger()->debug(var_export($aryData, true));
        return $aryData;
    }
    public function easyTreeHasChild($data, $textKey)
    {
        $aryData = [];
        $cnt = 0;
        foreach ($data as $d) {
            $aryData[$cnt]["id"] = $d['id'];
            $aryData[$cnt]["text"] = $d[$textKey];
            // $aryData[$cnt]["text"] = $d[$textKey][app()->getLocale()];
            // $aryData[$cnt]["attributes"]['url'] = route('admin.Navmenu2022_edit', [
            //     'locale' => app()->getLocale(),
            //     'Navmenu2022_id' => $d['id']
            // ]);
            // logger()->debug("easyTreeHasChild -  " . var_export($d, true));
            if (array_key_exists('children', $d)) {
                foreach ($d['children'] as $c) {
                    $aryData[$cnt]['children']["id"] = $c['id'];
                    $aryData[$cnt]['children']["text"] = $c[$textKey];
                    //$aryData[$cnt]['children']["text"] = $c[$textKey][app()->getLocale()];
                    // $aryData[$cnt]['children']["attributes"]['url'] = route('admin.Navmenu2022_edit', [
                    //     'locale' => app()->getLocale(),
                    //     'Navmenu2022_id' => $c['id']
                    // ]);
                    if (array_key_exists('children', $c)) {
                        $aryData[$cnt]['children']['children'] = $this->easyTreeHasChild($c['children'], $textKey);
                    }
                }
                return $aryData;
            }
            $cnt++;
        }
        return $aryData;
    }
}
