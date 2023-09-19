<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;
use App\Models\Tags;
use App\Models\Blogs;
use App\Models\Keywords;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apiListsOptions()
    {
        //  return json form setting : keywords, tags, web langs, category
        $aryData = [];
        // keywords
        /*
        $keywords = Keywords::whereStatus("Active")->with("children")->get();
        $mapKeywords = $this->mapLocaleValues(["id","name","display_name"], $keywords);
        logger()->debug(" apiListsOptions - " . var_export($mapKeywords,true));
      //  logger()->debug(" apiListsOptions - " . var_export($keywords,true));
        $aryData["keywords"] = $mapKeywords;

        // category
        $category = Category::whereStatus("Active")->with("children")->get();
        $aryData["category"] = $this->mapLocaleValues(["id","name"], $category);

        // tags
        $tags = Tags::whereStatus("Active")->with("children")->get();
        $aryData["tags"] = $this->mapLocaleValues(["id","name"], $tags);
*/
        // web langs
        $aryData["lang"] = config('app.locales');
        // Keywords
        $aryData["keywords"] = Keywords::select("id","name")->whereStatus("Active")->with("children")->orderBy("seq","asc")->get();
        // Category
        $allActiveCategory = Category::select("id","name")->whereNull("parent_id")->with("children")->whereStatus("Active")->orderBy("seq","asc")->get();
   
        $aryData["category"] = array_unique($this->parentData($allActiveCategory));
       // logger()->debug( " category " . var_export($aryData["category"],true));
 /*       foreach ($allActiveCategory as $activeCategory){
            logger()->debug(" Parent  - " . $activeCategory->name['en']);  
            $aryData["category"][]=$activeCategory;
            if ($activeCategory->children->count() >0){
                logger()->debug(" has child - " . $activeCategory->children->count());
               // array_merge($aryData["category"], $this->getChildrenList($activeCategory->children));
               $aryData["category"][] = $this->getChildrenList($activeCategory->children);
            }
        }
    */
        // Tags
        $aryData["tags"] = Tags::select("id","name")->whereStatus("Active")->with("children")->orderBy("created_at","asc")->get();



     //   logger()->debug(" apiListsOptions - " . var_export($aryData,true));
        return response()->json($aryData);
    }

    public function parentData($data)
    {
        logger()->debug('parentData');
    
        $aryData = [];
        $childData = [];
        foreach ($data as $d) {
            logger()->debug(" Parent  - " . var_export($d->name,true));  
            $aryData[] = $d;
         //   dd($aryData);
            if ($d->children->count() > 0) {
                logger()->debug(" children  - ");  
           //     $aryData[] = $this->parentHasChild($d->children);
            // $childData[] = $this->parentHasChild($d->children);
              $aryData = array_merge($aryData,$this->parentHasChild($d->children));
            } 
        }
      //  $arrayReturn = array_merge($aryData, $childData);
        return $aryData;
    }
    public function parentHasChild($data)
    {
        $aryData = [];

        foreach ($data as $d) {
            logger()->debug('parentHasChild - parent' . $d->name['en']);
            $aryData[] = $d;
            // check
            if ($d->children->count() > 0) {
                logger()->debug('parentHasChild - has child');
              //  $aryData[] = $this->parentHasChild($d->children);
              $aryData = array_merge($aryData,$this->parentHasChild($d->children));
                foreach ($d->children as $c) {
                    $aryData[] = $c;
                    if ($c->children->count() > 0) {
                        $aryData = array_merge($aryData,$this->parentHasChild($c->children));
                    }
                }
                return $aryData;
            }
        }
        return $aryData;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
