<?php

namespace App\Http\Controllers;

use App\Models\ModifyHistorys;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ModifyHistorysController extends Controller
{
    protected $mtype;

    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['apiProductLists']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($locale, Request $request)
    {
        
        try {
            logger()->debug(" ModifyHistorysController - create : " . var_export($request->all(), true));
            $modifyHistorys = (new ModifyHistorys)
            ->validateAndFill($request->all());

            $modifyHistorys->lang = $locale;
            $modifyHistorys->save();


        } catch (ValidationException $ex) {
            logger()->error(" ModifyHistorysController - create : " . var_export($request->all(), true));
            return $ex->validator->errors();
        }
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
}
