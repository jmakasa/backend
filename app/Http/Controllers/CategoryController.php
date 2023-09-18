<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    const FILE_PATH = "uploads\\";
    public function __construct()
    {
         $this->middleware('auth',['except' => [ 'apiCategoryList' ]]);
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
        $allCategories = Category::with('children')->get()->toArray();
        // logger()->debug(var_export($allCategories,true));
        $getEasyTreeData = $this->easyTreeData($allCategories, "name");
     //   logger()->debug(" --- final tree datat ----" . var_export($getEasyTreeData, true));
        $categories = Category::whereNull('parent_id')->orderBy('seq', 'asc')->get();
        return view('admin.category.index', compact('categories', "bearerToken"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::whereNull('parent_id')->orderBy('seq', 'asc')->get();
        logger()->debug("Category create");
        return view('admin.category.create', compact('categories'));
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
        logger()->debug(" category - Store : " . var_export($request->all(),true));
        $category = (new Category)
            ->validateAndFill($request->all())
            ->setAttribute('status', Category::STATUS_ACTIVE);
        if ($request->img_file) {
            $fileName = uniqid('cat_') . '.' . $request->img_file->extension();
            $request->img_file->move(public_path('uploads\category'), $fileName);
            $category->img  = "uploads\category\\" . $fileName;
        }
        // set default value 
        $category->name = $this->assignDefaultValue($request->input("name")['en'], $request->input('name'));
        $category->desc = $this->assignDefaultValue($request->input("desc")['en'], $request->input('desc'));
        logger()->debug(" category - Store data : " . var_export($category, true));
        if ($category->save()) {
            logger()->debug(" category - Store data : SAVED" . var_export($request->all(), true));
            return redirect()->route('admin.category_list', [config('app.locale')])->with('status', 'Category is added');
        } else {
            logger()->debug(" category - Store data : NO inserted" . var_export($request->all(), true));
            return back()->with('autofocus', true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($locale, $id)
    {
        logger()->debug(var_export($id, true));
        $getCategory = Category::whereId($id)->first();
        logger()->debug(var_export($getCategory, true));

        $categories = Category::whereNull('parent_id')->orderBy('seq', 'asc')->get();
        return view('admin.category.edit', compact('categories', "getCategory"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        logger()->debug(" category - update : " . var_export($request->all(), true));
        $category = Category::whereId($request->input("id"))->first();
        // set default value 
     //   $category->name = $this->assignDefaultValue($request->input("name")['en'], $request->input('name'));
        $category->name = $request->input("name");
        $category->desc = $request->input("desc");
        $category->parent_id = $request->input('parent_id');
        $category->seq = $request->input('seq');
        $category->status = $request->input('status');
        if ($request->img_file) {
            $fileName = uniqid('cat_') . '.' . $request->img_file->extension();
            $request->img_file->move(public_path('uploads\category'), $fileName);
            $category->img  = "uploads\category\\" . $fileName;
        }
        //   logger()->debug(" category - update data : " . var_export($category,true));
        if ($category->save()) {
            logger()->debug(" category - update data : SAVED" . var_export($request->all(), true));
            return redirect()->route('admin.category_list', [config('app.locale')])->with('status', 'Category is Updated');
        } else {
            logger()->debug(" category - update data : NO inserted" . var_export($request->all(), true));
            return back()->with('autofocus', true);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    public function delete(Request $request)
    {
        // TODO ::
    }

    public function apiCategoryList()
    {
        $allCategories = Category::with('children')->get()->toArray();
        // logger()->debug(var_export($allCategories,true));
        $getEasyTreeData = $this->easyTreeData($allCategories, "name");
       // logger()->debug(" --- final tree datat ----" . var_export($getEasyTreeData, true));
        return response()->json($getEasyTreeData);
    }

    public function easyTreeData($data, $textKey)
    {
        $aryData = [];
        $cnt = 0;
        foreach ($data as $d) {
            $aryData[$cnt]["id"] = $d['id'];
            $aryData[$cnt]['text'] = $d[$textKey][app()->getLocale()];
            $aryData[$cnt]["attributes"]['url'] = route('admin.category_edit', [
                'locale' => app()->getLocale(),
                'category_id' => $d['id']
            ]);
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
            $aryData[$cnt]["text"] = $d[$textKey][app()->getLocale()];
            $aryData[$cnt]["attributes"]['url'] = route('admin.category_edit', [
                'locale' => app()->getLocale(),
                'category_id' => $d['id']
            ]);
           // logger()->debug("easyTreeHasChild -  " . var_export($d, true));
            if (array_key_exists('children', $d)) {
                foreach ($d['children'] as $c) {
                    $aryData[$cnt]['children']["id"] = $c['id'];
                    $aryData[$cnt]['children']["text"] = $c[$textKey][app()->getLocale()];
                    $aryData[$cnt]['children']["attributes"]['url'] = route('admin.category_edit', [
                        'locale' => app()->getLocale(),
                        'category_id' => $c['id']
                    ]);
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
