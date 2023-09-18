<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class BlogsController extends Controller
{
    protected $imgPath;
    protected $imgWebPath;
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getBlogsList']]);
        $this->imgWebPath = "/img/product/banner/";
        $this->imgPath = env("AKASAWEBDIR_2206", "/akasa/www/akasa2206") . $this->imgWebPath;
    }


    /**
     * get all blogs 
     * return json 
     * 
     */
    public function getBlogsList($locale, Request $request)
    {
        Logger()->debug(" getBlogsList ");
        $sort = $request->has('sort') ? $request->get('sort') : 'status';
        $order = $request->has('order') ? $request->get('order') : 'desc';
        $page = $request->has('page') ? $request->get('page') : 1;
        $rows = $request->has('rows') ? $request->get('rows') : 50;
        $lang = $request->has('lang') ? $request->get('lang') : 'en';
        $skip = ($page - 1) * $rows;

        $blogs = Blogs::where('lang', $locale)->orderBy($sort, $order)->orderBy('seqno', 'asc');
        $blogs->skip($skip)->take($rows);

        return response()->json($blogs->get());
    }

    public function getBlogsById($locale, Request $request){
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                ],
                [
                    'id.required' => 'ID is required.',

                ]
            );

            $blog = Blogs::whereId($request->get('id'))->whereLang($locale)->get()->first();

            return response()->json($blog->get());


        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function export_list(){
        // get data
        $blogs = 
        $sql = "SELECT `id`,`title`, `subtitle`, `btype`, `releasedate`, `seqno`,  CONCAT('img/product/common/blog/',`id`,'/', `topimage`) as topimage, `status` FROM blogs  WHERE status >0 order by status, seqno";
    

        // export conf

    }
}