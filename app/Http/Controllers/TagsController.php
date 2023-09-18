<?php

namespace App\Http\Controllers;

use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{
    public function __construct()
    {
        logger()->debug(Auth::user());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tags = Tags::whereNull('parent_id')->get();
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $tags = Tags::whereNull('parent_id')->get();
        logger()->debug("Tags create");
        return view('admin.tags.create', compact('tags'));
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
        //logger()->debug(" Tags - Store : " . var_export($request->all(),true));
        $tags = (new Tags)
            ->validateAndFill($request->all())
            ->setAttribute('status', Tags::STATUS_ACTIVE);
        // set default value 
        $tags->name = $this->assignDefaultValue($request->input("name")['en'], $request->input('name'));
       
        if ($tags->save()) {
            logger()->debug(" Tags - Store data : SAVED" . var_export($request->all(), true));
            return redirect()->route('admin.tags_list', [config('app.locale')])->with('status', 'Tags is added');
        } else {
            logger()->debug(" Tags - Store data : NO inserted" . var_export($request->all(), true));
            return back()->with('autofocus', true);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tags  $Tags
     * @return \Illuminate\Http\Response
     */
    public function show(Tags $Tags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tags  $Tags
     * @return \Illuminate\Http\Response
     */
    public function edit($locale, $id)
    {
        logger()->debug(var_export($id, true));
        $getTag = Tags::whereId($id)->first();
        logger()->debug(var_export($getTag, true));

        $tags = Tags::whereNull('parent_id')->get();
        return view('admin.tags.edit', compact('tags', "getTag"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tags  $Tags
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //  logger()->debug(" Tags - update : " . var_export($request->all(),true));
        $tags = Tags::whereId($request->input("id"))->first();
        $tags->parent_id = $request->input('parent_id');

        // set default value 
        $tags->name = $this->assignDefaultValue($request->input("name")['en'], $request->input('name'));
        
        if ($tags->save()) {
            logger()->debug(" Tags - update data : SAVED" . var_export($request->all(), true));
            return redirect()->route('admin.tags_list', [config('app.locale')])->with('status', 'Tags is Updated');
        } else {
            logger()->debug(" Tags - update data : NO inserted" . var_export($request->all(), true));
            return back()->with('autofocus', true);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tags  $tags
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tags $tags)
    {
        //
    }
}
