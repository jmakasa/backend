<?php

namespace App\Http\Controllers;

use App\Models\Reviewsites;
use App\Models\ReviewsitesHistory;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use DB;

class ReviewsitesController extends Controller
{

    protected $imgWebPath;
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['apiProductLists']]);
        // check login session key : username
        $this->imgWebPath = "/img/product/common/review/";
    }

    /**
     * reviewsites list 
     * 
     * return json
     */
    public function getList($locale, Request $request)
    {
        $sort = $request->has('sort') ? $request->get('sort') : 'created_at';
        $order = $request->has('order') ? $request->get('order') : 'desc';
        $page = $request->has('page') ? $request->get('page') : 1;
        $rows = $request->has('rows') ? $request->get('rows') : 50;
        $lang = $locale;
        $skip = ($page - 1) * $rows;

        $Reviewsites = Reviewsites::withCount(['productReviews']);


        Logger()->debug(" ReviewsitesController - getList : request - " . var_export($request->all(), true));
        if ($request->has('sitename')) {
            Logger()->debug(" ReviewsitesController - has sitename");
            $Reviewsites->where(DB::raw('lower(sitename)'), "LIKE", "%" . strtolower($request->get('sitename') . "%"));
        }
        $data['total'] = $Reviewsites->count();
        //  $Reviewsites->where(DB::raw('lower(sitename)'),strtolower($request->get('sitename')));
        $Reviewsites->orderBy($sort, $order)->skip($skip)->take($rows);


        $data['rows'] = $Reviewsites->get()->toArray();
        return response()->json($data);
    }

    /**
     * reviewsites name list
     * 
     * return json id, name only
     */
    public function getReviewsitesName($locale, $sitename, Reviewsites $Reviewsites)
    {
        try {

            return response()->json($Reviewsites->select('id', 'sitename as name')->where('sitename', 'LIKE', '%' . $sitename . '%')->get()->toArray());
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    /**
     * reviewsites geticon2edit
     * 
     * return json id, name only
     */
    public function getReviewsitesbyId($locale, Request $request, Reviewsites $Reviewsites)
    {
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                ],
                [
                    'id.required' => 'id is required.',
                ]
            );
            return response()->json($Reviewsites->select('id', 'sitename', 'siteurl', 'comment')->whereId($request->get('id'))->first()->toArray());
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }


    /** 
     * create new reviewsites
     */
    public function add($locale, Request $request, FileService $fileService)
    {
        //
        try {
            $this->validate(
                $request,
                [
                    'sitename' => 'required',
                ],
                [
                    'sitename.required' => 'SITENAME is required.',
                ]
            );
            // new Reviewsites
            $input = $request->only('sitename', 'sitelogo', 'siteurl', 'docdir', 'filetype', 'filesize', 'comment');
            $reviewsite = (new Reviewsites)
                ->validateAndFill($input)
                ->setAttribute('docdir', $this->imgWebPath);


            if ($reviewsite->save()) {
                // rename logo
                //file rename lowercase sitename white replaced by _ sitename
            //    $this->renameLogo($request->get('sitename'), $request->get('sitelogo'),$fileService);
                $newFilename = $this->renameLogo($request->get('sitename'), $request->get('sitelogo'),$fileService);
                if ($newFilename){
                    $reviewsite->sitelogo = $newFilename;
                    $reviewsite->save();
                }
                return response()->json($reviewsite->toArray());
            } else {
                // TODO:: return and said no this partno
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function edit($locale, Request $request, FileService $fileService)
    {
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
            $reviewsite = Reviewsites::whereId($request->get('id'))->first();
            // new Reviewsites

            $reviewsite->sitename = $request->get('sitename');

            $reviewsite->siteurl = $request->get('siteurl');

            if ($reviewsite->sitelogo != $request->get('sitelogo')) {
                // remove the logo
                $fileService->removeFile(FileService::FILE_TYPE_REVIEWSITE,$reviewsite->sitelogo, 'icon' );


                //file rename lowercase sitename white replaced by _
                $newFilename = $this->renameLogo($request->get('sitename'), $request->get('sitelogo'),$fileService);
                if ($newFilename){
                    $reviewsite->sitelogo = $newFilename;
                }

                $reviewsite->filetype = $request->get('filetype');
                $reviewsite->filesize = $request->get('filesize');
            }

            $reviewsite->comment = $request->get('comment');
            Logger()->debug(" ReviewsitesController - editReviewsites " . var_export($request->all(), true));
            if ($reviewsite->save()) {
                return response()->json($reviewsite->toArray());
            } else {
                return response()->json(false);
                // TODO:: return and said no this partno
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function delete($locale, Request $request, FileService $fileService)
    {
        try {
            $this->validate(
                $request,
                [
                    'reviewsites_id' => 'required',
                ],
                [
                    'reviewsites_id.required' => 'ID is required.',
                ]
            );

            $reviewsite = Reviewsites::whereId($request->get('reviewsites_id'))->first();
            $this->backupData($reviewsite->id, $reviewsite->replicate(), 'DELETE','reviewsites_history');
            // remove image
            $fileService->moveFile(FileService::FILE_TYPE_REVIEWSITE, $reviewsite->sitelogo);

            if ($reviewsite->delete()) {
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        } catch (ValidationException $ex) {
            logger()->error("    ProductReviewsController : delete " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }

    public function exportConf($locale,FileService $fileService){
        $reviewsites  = Reviewsites::all()->toArray();
        $aryReviewsite = [];
        foreach ($reviewsites as $data) {
            $aryReviewsite[$data['id']] = $data;
        }
        $result = $fileService->createConf(FileService::TYPE_REVIEWSITE, 'reviewsites.conf', $locale,  "[reviewsites]\nsites=" . json_encode($aryReviewsite));
        if ($result){
            return response()->json(['result' => $result]);
        } else {
            return  response()->json(['result' => false]);
        }           
    }


    private function renameLogo($sitename, $logoname,FileService $fileService){
        // rename logo
        //file rename lowercase sitename white replaced by _ sitename
        $aryFileinfo = pathinfo($logoname);

        //$newFilename = str_replace(" ", "_", Str::lower($sitename)) . "_" . str_replace(" ", "_", Str::lower($logoname));
        $newFilename = str_replace(" ", "_", Str::lower($sitename)) ."_".date('ymdHis').".".$aryFileinfo['extension'];
        // Logger()->debug(" ReviewsitesController - sitelogo " . var_export($request->get('sitelogo'), true));
        // Logger()->debug(" ReviewsitesController - adnewFilename " . var_export($newFilename, true));
        $renameFile = $fileService->renameFile(FileService::FILE_TYPE_REVIEWSITE, $logoname, $newFilename, 'icon/');
        if ($renameFile){
            return $newFilename;
        } else {
            return false;
        }
    }
}
