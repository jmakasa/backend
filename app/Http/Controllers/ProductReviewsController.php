<?php

namespace App\Http\Controllers;

use App\Models\ProductReviews;
use App\Models\Images;
use Exception;
use Illuminate\Http\Request;
use App\Services\HistoryService;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File; 
use App\Services\FileService;
use Illuminate\Support\Str;

class ProductReviewsController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['apiProductLists']]);
        // check login session key : username
    }

    public function getList($locale, Request $request){
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

            $sort = $request->has('sort') ? $request->get('sort') : 'seqno';
        $order = $request->has('order') ? $request->get('order') : 'asc';
        $page = $request->has('page') ? $request->get('page') : 1;
        $rows = $request->has('rows') ? $request->get('rows') : 50;
        $skip = ($page - 1) * $rows;


            
            // list ProductReviews
           $prodReviews =  ProductReviews::where('partno',$request->get('partno'))
           ->where('lang',$locale)
           ->with('reviewsites') 
                ->with('images')
                ->with('icon');

                $data['total'] = $prodReviews->count();
                //  $Reviewsites->where(DB::raw('lower(sitename)'),strtolower($request->get('sitename')));
                  $prodReviews->orderBy($sort, $order)->skip($skip)->take($rows);                  
                  $data['rows'] = $prodReviews->get()->toArray();
                //  logger()->debug(" ProductReviewsController listProdReviews : " . var_export($data, true));
                  return response()->json($data);

        } catch (Exception $ex) {
            logger()->error(" addThread " . var_export($ex, true));
            return $ex;
        } catch (ValidationException $ex) {
            logger()->error(" addThread " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }

    }
 /**
     * get list of reviewsites_id
     * return json
     */
    public function getListBySiteId ($locale,Request $request){
        try {
            $this->validate(
                $request,
                [
                    'reviewsites_id' => 'required',

                ],
                [
                    'reviewsites_id.required' => 'Reviewsite ID is required.',
                ]
            );

            $sort = $request->has('sort') ? $request->get('sort') : 'seqno';
            $order = $request->has('order') ? $request->get('order') : 'asc';
            $page = $request->has('page') ? $request->get('page') : 1;
            $rows = $request->has('rows') ? $request->get('rows') : 50;
            $skip = ($page - 1) * $rows;
            
            // list ProductReviews
           $prodReviews =  ProductReviews::where('reviewsites_id',$request->get('reviewsites_id'))
           ->where('lang',$locale)
           ->with('reviewsites') 
                ->with('images')
                ->with('icon');

                $data['total'] = $prodReviews->count();
                //  $Reviewsites->where(DB::raw('lower(sitename)'),strtolower($request->get('sitename')));
                  $prodReviews->orderBy($sort, $order);                  
                  $data['rows'] = $prodReviews->get()->toArray();
                //  logger()->debug(" ProductReviewsController listProdReviews : " . var_export($data, true));
                  return response()->json($data);

        } catch (ValidationException $ex) {
            logger()->error(" getListByReviewsiteId " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
    }
    /**
     *  add new reviews
     * 
     * image : image, icon
     * 
     * icon can upload or 
     */
    public function add($locale, Request $request, FileService $fileService){
        try {
            $this->validate(
                $request,
                [
                    'title' => 'required',
                    'type' => 'required',
                    'web_link' => 'required',
              //      'short_desc' => 'required',
                ],
                [
                    'title.required' => 'Title is required.',
                    'type.required' => 'Type is required.',
                    'web_link.required' => 'WebLink is required.',
                //    'short_desc.required' => 'Desc is required.',
                ]
            );

            if($request->has('id')){ // EDIT 
                logger()->debug(" ProductReviewsController edit : " . var_export($request->all(), true));
             //   $prodReview = ProductReviews::with('images')->whereId($request->get('id'))->first();
             $prodReview = ProductReviews::whereId($request->get('id'))->first();
                // product review
                if ($request->has('is_highlight') && $request->get('is_highlight')){
                    $prodReview->is_highlight = ProductReviews::STATUS_ACTIVE;
                } else {
                    $prodReview->is_highlight = ProductReviews::STATUS_INACTIVE;
                }
                if ($request->has('is_hide_icon') && $request->get('is_hide_icon')){
                    $prodReview->is_hide_icon = ProductReviews::STATUS_ACTIVE;
                } else {
                    $prodReview->is_hide_icon = ProductReviews::STATUS_INACTIVE;
                }
                // TODO :: SEQNO
                if ($request->has('seqno') && $request->get('seqno')){
                    $prodReview->seqno = $request->get('seqno');
                } else {
                    $prodReview->seqno = sprintf("%04d", '1');
                }
                if ($request->get('title') != $prodReview->title){
                    $prodReview->title = $request->get('title');
                } 
                if ($request->get('short_desc') != $prodReview->short_desc){
                    $prodReview->short_desc = $request->get('short_desc');
                } 
                if ($request->get('type') != $prodReview->type){
                    $prodReview->type = $request->get('type');
                } 
                if ($request->get('web_link') != $prodReview->web_link){
                    $prodReview->web_link = $request->get('web_link');
                } 
                if ($request->get('remarks') != $prodReview->remarks){
                    $prodReview->remarks = $request->get('remarks');
                } 
                if ($request->get('status') != $prodReview->status){
                    $prodReview->status = $request->get('status');
                }

                // reviewsite reviewsites_id
                if ($request->get('reviewsites_id') != $prodReview->reviewsites_id){
                    logger()->debug(" ProductReviewsController Reviewsites ID : $prodReview->reviewsites_id");
                    $prodReview->reviewsites_id = $request->get('reviewsites_id');
                }
                Logger()->debug(" ProductReviewsController - prepare image data");
                // images
                if ($request->has('docname') && $request->filled('docname')){
                    //
                    Logger()->debug(" ProductReviewsController - docname " . $request->get('docname'));
                    Logger()->debug(" ProductReviewsController - reviewsites " . var_export($request->get('reviewsites'),true));
                    $reviewsites = $request->get('reviewsites');
                    $newFilename = $request->get('partno')."_".$this->cleanStr($reviewsites['sitename']);
                    Logger()->debug(" ProductReviewsController - images_id =  " . $prodReview->images_id);
                    // check images table if edit check images_id and change docname in image table.
                    if ($prodReview->images_id ===0){ // need to insert new image
                        // insert into images
                        $imgData = $request->only('lang','partno','docname','caption','comment','filetype','filesize');
                        // seqno, docdir
                        $newImage = (new Images)
                            ->validateAndFill($imgData);
                            // $filename,FileService $fileService){
                            $newImage->docname = $this->renameFeature($request->get('partno'),$newFilename,$request->get('docname'), $fileService);

                        $newImage->seqno = sprintf("%04d", '900');
                        $newImage->ctype = 'Reviews';
                        $newImage->docdir = 'img/product/common/Reviews/00/';
                        if ($newImage->save()){
                            Logger()->debug(" ProductReviewsController - has save images");
                            $prodReview->images_id = $newImage->id;
                            if ($prodReview->isDirty()) {
                                $historyService = new HistoryService;
                                foreach ($prodReview->getDirty() as $key => $value) {
                                    $historyService->addProductsChangeLogs($prodReview->id, $prodReview->partno, $prodReview->getTable(), $key, $prodReview->getOriginal($key), $value, 'change', $request->get('username'));
                                }
                            }
                            if ($prodReview->save()){
                                $this->resetSeqno($request->get('partno'));
                                return response()->json($prodReview->toArray());
                            } else {
                                return response()->json(false);
                            }
                        } else {
                            return response()->json(false);
                        }

                    } else {
                        $oldImage = Images::whereId($prodReview->images_id)->first();
                        $filepath = $request->get('partno') . '/Web_Library/Reviews/';
                        $fileService->removeFile(FileService::FILE_TYPE_REVIEW_FEATUREIMG, $oldImage->docname, $filepath);

                        $image = Images::whereId($prodReview->images_id)->update([
                                'docname' => $this->renameFeature($request->get('partno'),$newFilename,$request->get('docname'), $fileService),
                                'filesize' => $request->get('filesize'),
                                'filetype' => $request->get('filetype')
                            ]);
                            if ($prodReview->isDirty()) {
                                $historyService = new HistoryService;
                                foreach ($prodReview->getDirty() as $key => $value) {
                                    $historyService->addProductsChangeLogs($prodReview->id, $prodReview->partno, $prodReview->getTable(), $key, $prodReview->getOriginal($key), $value, 'change', $request->get('username'));
                                }
                            }
                            if ($prodReview->save()){
                                $this->resetSeqno($request->get('partno'));
                                return response()->json($prodReview->toArray());
                            } else {
                                return response()->json(false);
                            }
                    }

                    

                } else {
                    if ($prodReview->isDirty()) {
                        $historyService = new HistoryService;
                        foreach ($prodReview->getDirty() as $key => $value) {
                            $historyService->addProductsChangeLogs($prodReview->id, $prodReview->partno, $prodReview->getTable(), $key, $prodReview->getOriginal($key), $value, 'change', $request->get('username'));
                        }
                    }
                    if ($prodReview->save()){
                        $this->resetSeqno($request->get('partno'));
                        return response()->json($prodReview->toArray());
                    } else {
                        return response()->json(false);
                    }
                }

            } else { /// NEW
                ///
                logger()->debug(" ProductReviewsController add : " . var_export($request->all(), true));
                // new ProductReviews

                $prData = $request->only('partno','reviewsites_id','title','short_desc','lang','type','web_link','remarks');
                $newProductReview = (new ProductReviews)
                    ->validateAndFill($prData)
                    ->setAttribute('status', ProductReviews::STATUS_ACTIVE);
                    //is_highlight
                    if ($request->has('is_highlight') && $request->get('is_highlight')){
                        $newProductReview->is_highlight = ProductReviews::STATUS_ACTIVE;
                    } else {
                        $newProductReview->is_highlight = ProductReviews::STATUS_INACTIVE;
                    }
                    if ($request->has('is_hide_icon') && $request->get('is_hide_icon')){
                        $newProductReview->is_hide_icon = ProductReviews::STATUS_ACTIVE;
                    } else {
                        $newProductReview->is_hide_icon = ProductReviews::STATUS_INACTIVE;
                    }
                    // TODO :: SEQNO
                    if ($request->has('seqno') && $request->get('seqno')){
                        $newProductReview->seqno = $request->get('seqno');
                    } else {
                        $newProductReview->seqno = sprintf("%04d", '1');
                    }
                    // images
                        $hasImage = false;
                        if ($request->has('docname') && $request->filled('docname')){
                            logger()->debug(" ProductReviewsController has docname and filled docname : " . var_export($request->get('docname'), true));
                            // insert into images
                            $imgData = $request->only('lang','partno','docname','caption','comment','filetype','filesize');
                            // seqno, docdir
                            $newImage = (new Images)
                                ->validateAndFill($imgData);
                            
                            $newImage->seqno = sprintf("%04d", '900');
                            $newImage->ctype = 'Reviews';
                            $newImage->docdir = 'img/product/common/Reviews/00/';
                            $newImage->save();
                            $hasImage = true;
                        }
                        if ($hasImage){
                            $newProductReview->images_id = $newImage->id;
                        }
                        // end images

                    if ($newProductReview->save()){
                        $this->resetSeqno($request->get('partno'));
                        return response()->json($newProductReview->toArray());
                    } else {
                        return response()->json(false);
                    }
            
            }
        } catch (ValidationException $ex) {
            logger()->error(" ProductReviewsController add " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }

    }

    public function removeImage($locale, Request $request){
        try {
            $this->validate(
                $request,
                $this->validateId()['rules'],
                $this->validateId()['ruleMessages']
            );
            // TODO:: remove image record
            // '/docs/products/' + $request->get('partno') + '/Web_Library/Reviews/';
            $img = Images::whereId($request->get('images_id'))->first();
            $filename = env("WEBDIR", "/akasa/www/").'/docs/products/' . $request->get('partno') . '/Web_Library/Reviews/'.$img->docname;
            File::delete($filename);
            if ($img->delete() && ProductReviews::whereId($request->get('id'))->update(['images_id'=>0])){
                return response()->json(true);
            } else {
                return response()->json(false);
            }


        } catch (ValidationException $ex) {
            logger()->error("    ProductReviewsController : delete " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
        
    }

    public function delete($locale, Request $request,FileService $fileService){
        try {
            $this->validate(
                $request,
                $this->validateId()['rules'],
                $this->validateId()['ruleMessages']
            );

            $pr = ProductReviews::whereId($request->get('id'))->first();
            $this->backupData($pr->id,$pr->replicate(), 'DELETE','product_reviews_history');

            if ($pr->images_id !== 0){
                $img = Images::whereId($pr->images_id)->first();
                $this->backupData($img->id,$img->replicate(), 'DELETE','images_history');
                $filepath = $img->partno . '/Web_Library/Reviews/';
                $fileService->removeFile(FileService::FILE_TYPE_REVIEW_FEATUREIMG, $img->docname, $filepath);
                $img->delete();
            }

            if ($pr->delete()){
                return response()->json(true);
            } else {
                return response()->json(false);
            }


        } catch (ValidationException $ex) {
            logger()->error("    ProductReviewsController : delete " . var_export($ex->validator->errors(), true));
            return $ex->validator->errors();
        }
        
    }

    public function resetSeqno($partno){
        $prodReviews = ProductReviews::where('partno',$partno)->orderBy("seqno")->get();
        $seqno = 10;
        foreach ($prodReviews as $data){
            $data->seqno = sprintf("%04d", $seqno);
            $data->save();
            $seqno +=10;
        }
    }

    
    private function renameFeature($partno, $newFilename, $filename,FileService $fileService){
        // rename logo
        //file rename lowercase sitename white replaced by _ sitename
       // $aryFileinfo = pathinfo($logoname);
       // path  "/products/" . $partno . "/Web_Library/" . $this->ctype_array[$type] . "/";
       $path = "/".$partno."/Web_Library/Reviews/";
       $aryFileinfo = pathinfo($filename);

        $newFilename = str_replace(" ", "_", Str::upper($newFilename)) ."_".date('ymdHis').".".$aryFileinfo['extension'];
        //$newFilename = str_replace(" ", "_", Str::lower($sitename)) .".".$aryFileinfo['extension'];
        // Logger()->debug(" ReviewsitesController - sitelogo " . var_export($request->get('sitelogo'), true));
         Logger()->debug(" ReviewsitesController - adnewFilename " . var_export($newFilename, true));
        $renameFile = $fileService->renameFile(FileService::FILE_TYPE_REVIEW_FEATUREIMG, $filename, $newFilename, $path);
        if ($renameFile){
            return $newFilename;
        } else {
            return false;
        }
    }
}
