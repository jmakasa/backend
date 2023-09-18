<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Images;

class ImagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     //   $this->middleware('auth', ['except' => ["index"]]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getById($locale,$id)
    {
        logger()->debug(" getdata " . var_export($id, true));
        $data = Images::whereId($id)->first();
       // logger()->debug(" getdata " . var_export($data, true));
        return response()->json($data);
    }
    public function delete($locale,Request $request){
        logger()->debug( " delete image " . var_export($request->all(), true));
        
    }

    public function update($locale,Request $request){
        logger()->debug( " update image " . var_export($request->all(), true));
        $image = Images::findOrFail($request->input('id'));
        $update = $image->fill($request->all())->save();
        return response()->json($update);

    }
    public function listAll(){
        return response()->json(Images::findAll());
    }

    
}
