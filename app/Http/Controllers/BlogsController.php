<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;



class BlogsController extends Controller
{
    protected $imgPath;
    protected $imgWebPath;
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getBlogsList', 'export_list', 'export_detail', 'export_featured', 'export_one_detail', 'updateDetail','getBlogsTagList']]);
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

        $blogs = Blogs::select('id','title',
        'subtitle',
        'btype',
        'releasedate',
        'topimage',
        'seqno',
        'lang',
        'status',)->where('lang', $locale)->orderBy($sort, $order)->orderBy('releasedate', 'desc');
        

        $result = [];
        $result['total'] = $blogs->count();
        $result['rows'] = $blogs->skip($skip)->take($rows)->get()->toArray();

        return response()->json($result);
    }

    public function getBlogsTagList($locale, Request $request)
    {
        Logger()->debug(" getBlogsList ");
        return response()->json(Blogs::select('id','title')->where('lang', $locale)->orderBy('status', 'desc')->orderBy('releasedate', 'desc')->get());
    }

    public function getBlogsById($locale, Request $request)
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

            $blog = Blogs::whereId($request->get('id'))->whereLang($locale)->get()->first();

            return response()->json($blog->get());
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function export_list($locale, Request $request,FileService $fileService)
    {
        try {
            // get data
            $blogs = Blogs::select(
                'id',
                'title',
                'subtitle',
                "releasedate",
                "topimage",
                'slug',
                DB::raw("CASE
                WHEN btype =1 THEN 'Company News'
                WHEN btype =2 THEN 'Industry Insights'
                WHEN btype =3 THEN 'Press Release'
                WHEN btype =4 THEN 'Product Review'
                WHEN btype =5 THEN 'Use Case'
                END as btype")
            )->where("status", ">", 0)->whereLang($locale)->orderBy("status", "desc")
            ->orderBy('releasedate', 'desc')
            // ->orderBy("seqno", "asc")
            ->get();
            $user = ($request->has('username') ? $request->get('username') : 'SYSTEM');

            // export slug
            $slug = Blogs::select('id','slug')->where("status", ">", 0)->whereLang($locale)->orderBy("status", "desc")
            ->orderBy('id', 'asc')
            ->get();

            
            $result = $fileService->createConf(FileService::FILE_TYPE_BLOG,  'list.conf', $locale,  
                "[BLOGLIST]\njson=" . json_encode($blogs->toArray())."\n\n[SLUGLIST]\nsluglist=" . json_encode($slug->toArray())
                ,$user, FileService::STATUS_ACTIVE, "Blog");

            foreach ($blogs as $b) {
                if ($b->topimage) {
                    $fileService->exportFiles(FileService::FILE_TYPE_BLOG_IMG, $b->topimage, $b->id, $locale,$user);
                }
            }
            

            $return['result'] = true;
            return response()->json($return);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function export_detail($locale, Request $request, FileService $fileService)
    {
        try {
            // get data
            $blogs = Blogs::select(
                'id',
                'title',
                'subtitle',
                "releasedate",
                "topimage",
                'related_products',
                'contents',
                'seqno',
                'caption',
                'lang',
                'featured_blog',
                DB::raw("CASE
                WHEN btype =1 THEN 'Company News'
                WHEN btype =2 THEN 'Industry Insights'
                WHEN btype =3 THEN 'Press Release'
                WHEN btype =4 THEN 'Product Review'
                WHEN btype =5 THEN 'Use Case'
                END as btype")
            )->where("lang", $locale)->where("status", ">", 0)->orderBy("seqno", "asc")->get();

            $blogIds = $blogs->pluck('id')->toArray();
            $user = ($request->has('username') ? $request->get('username') : 'SYSTEM');

            foreach ($blogs as $b) {
                $blog = [];
                $id = $b->id;
                $ofilename = $id . ".conf";
                $handle = fopen($ofilename, "w");
                fprintf($handle, "[BLOG]\n");
                $blog['blog'] = $b->toArray();

                // related_products
                $aryRelatedProd = explode(",", $blog['blog']['related_products']);
                $products = Products::select('products.name', 'products.title', 'products.partno', 'products.pstatus', 'i.docname')->whereIn('products.partno', $aryRelatedProd)
                    ->leftJoin("images as i", 'products.partno', '=', 'i.partno')
                    ->where('i.ctype', 'gallery')
                    ->where('i.listpic', 1)
                    ->where('products.lang', $locale)->get();
                $blog['related_products'] = $products->toArray();

                // image
                if ($b->topimage) {
                    $fileService->exportFiles(FileService::FILE_TYPE_BLOG_IMG, $b->topimage, $id, $locale,$user);
                }

                // set upload_files 
                $fileService->changeStatus(FileService::FILE_TYPE_BLOG_CIMG,$id,FileService::STATUS_INACTIVE,$user);
                
                if ($b->contents){
                    $content = $b->contents;
                
                    $dom = new \DomDocument('1.0', 'UTF-8');
            
                    $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
    
    
                    @$dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    
                    $images = $dom->getElementsByTagName('img');
    
                    foreach ($images as $key => $img) {
                        $src = $img->getAttribute('src');
                        $fileService->exportFiles(FileService::FILE_TYPE_BLOG_CIMG, basename($src), $id , $locale,$user,FileService::STATUS_ACTIVE);
                    }
                }
            
                // get featured blog
                if ($blog['blog']['featured_blog']) {
                    $aryFeaturedBlog = explode(",", $blog['blog']['featured_blog']);
                    $featuredBlog = Blogs::select('id', 'title', 'btype', 'releasedate', 'topimage')
                        ->whereIn('id', $aryFeaturedBlog)->whereLang($locale)->get();

                    $blog['featured_blog'] = $featuredBlog->toArray();
                } else {
                    $blog['featured_blog'] = [];
                }

                // prev and next blog
                $index = array_search($id, $blogIds);
                $blog['prev'] = [];
                $blog['next'] = [];

                if ($index !== false && $index > 0) {
                    $prevId = $blogIds[$index - 1];
                    $prevBlog = Blogs::select('id', 'title','slug')->whereId($prevId)->first();
                    $blog['prev'] = $prevBlog->toArray();
                }
                if ($index !== false && $index < count($blogIds) - 1) {
                    $nextId = $blogIds[$index + 1];
                    $nextBlog = Blogs::select('id', 'title','slug')->whereId($nextId)->first();
                    $blog['next'] = $nextBlog->toArray();
                }
                $fileService->createConf(FileService::FILE_TYPE_BLOG,  $id . '.conf', $locale,  "[BLOG]\njson=" . json_encode($blog),$user, FileService::STATUS_ACTIVE, $id);

            }

            $return['result'] = true;
            return response()->json($return);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function export_featured($locale, Request $request, FileService $fileService)
    {
        try {

            // get data
            $blogs = Blogs::select(
                'id',
                'title',
                'subtitle',
                "releasedate",
                "topimage",
                'related_products',
                'contents',
                'seqno',
                'caption',
                'lang',
                'featured_blog',
                DB::raw("CASE
                WHEN btype =1 THEN 'Company News'
                WHEN btype =2 THEN 'Industry Insights'
                WHEN btype =3 THEN 'Press Release'
                WHEN btype =4 THEN 'Product Review'
                WHEN btype =5 THEN 'Use Case'
                END as btype")
            )->where("lang", $locale)->where("status", 2)->orderBy("seqno", "asc")->get();
            $user = ($request->has('username') ? $request->get('username') : 'SYSTEM');

            $fileService->createConf(FileService::FILE_TYPE_BLOG,  'featured.conf', $locale,  "[FEATURED]\nfeatured_json=" . json_encode($blogs->toArray()), $user, FileService::STATUS_ACTIVE,"Blog");

            $return['result'] = true;
            return response()->json($return);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }
    public function export_one_detail($locale, Request $request, FileService $fileService)
    {
        try {
            // get data
            $blogIds = Blogs::select('id')->where("lang", $locale)->where("status", ">", 0)->orderBy("seqno", "asc")->pluck('id')->toArray();

            $b = Blogs::select(
                'id',
                'title',
                'subtitle',
                "releasedate",
                "topimage",
                'related_products',
                'contents',
                'seqno',
                'caption',
                'lang',
                'featured_blog',
                DB::raw("CASE
                WHEN btype =1 THEN 'Company News'
                WHEN btype =2 THEN 'Industry Insights'
                WHEN btype =3 THEN 'Press Release'
                WHEN btype =4 THEN 'Product Review'
                WHEN btype =5 THEN 'Use Case'
                END as btype")
            )->whereId($request->get("id"))->first();

            $user = ($request->has('username') ? $request->get('username') : 'SYSTEM');
            if ($b) {
                $blog = [];
                $id = $b->id;
                $ofilename = $id . ".conf";
                $handle = fopen($ofilename, "w");
                fprintf($handle, "[BLOG]\n");
                $blog['blog'] = $b->toArray();

                // related_products
                $aryRelatedProd = explode(",", $blog['blog']['related_products']);
                $products = Products::select('products.name', 'products.title', 'products.partno', 'products.pstatus', 'i.docname')->whereIn('products.partno', $aryRelatedProd)
                    ->leftJoin("images as i", 'products.partno', '=', 'i.partno')
                    ->where('i.ctype', 'gallery')
                    ->where('i.listpic', 1)
                    ->where('products.lang', $locale)->get();
                $blog['related_products'] = $products->toArray();

                // image
                if ($b->topimage) {
                    $fileService->exportFiles(FileService::FILE_TYPE_BLOG_IMG, $b->topimage, $b->id, $locale,$user);
                }
                // handle content images
                // set upload_files 
                $fileService->changeStatus(FileService::FILE_TYPE_BLOG_CIMG,$id,FileService::STATUS_INACTIVE,$user);
                $content = $b->contents;
    
                $dom = new \DomDocument();
    
                @$dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    
                $images = $dom->getElementsByTagName('img');
    
                foreach ($images as $key => $img) {
                    
                    $src = $img->getAttribute('src');
                    Logger()->debug(" export_one_detail src : $src ");
                    Logger()->debug(" export_one_detail src basename : " .basename($src));
                    $fileService->exportFiles(FileService::FILE_TYPE_BLOG_CIMG, basename($src), $id , $locale,$user,FileService::STATUS_ACTIVE);
                }

                // get featured blog
                if ($blog['blog']['featured_blog']) {
                    $aryFeaturedBlog = explode(",", $blog['blog']['featured_blog']);
                    $featuredBlog = Blogs::select('id', 'title', 
                    DB::raw("CASE
                    WHEN btype =1 THEN 'Company News'
                    WHEN btype =2 THEN 'Industry Insights'
                    WHEN btype =3 THEN 'Press Release'
                    WHEN btype =4 THEN 'Product Review'
                    WHEN btype =5 THEN 'Use Case'
                    END as btype"),
                    'releasedate', 'topimage')
                        ->whereIn('id', $aryFeaturedBlog)->whereLang($locale)->get();

                    $blog['featured_blog'] = $featuredBlog->toArray();
                } else {
                    $blog['featured_blog'] = [];
                }

                // prev and next blog
                $index = array_search($id, $blogIds);
                $blog['prev'] = [];
                $blog['next'] = [];

                if ($index !== false && $index > 0) {
                    $prevId = $blogIds[$index - 1];
                    $prevBlog = Blogs::select('id', 'title')->whereId($prevId)->first();
                    $blog['prev'] = $prevBlog->toArray();
                }
                if ($index !== false && $index < count($blogIds) - 1) {
                    $nextId = $blogIds[$index + 1];
                    $nextBlog = Blogs::select('id', 'title')->whereId($nextId)->first();
                    $blog['next'] = $nextBlog->toArray();
                }

                $fileService->createConf(FileService::FILE_TYPE_BLOG,  $id . '.conf', $locale,  "[BLOG]\njson=" . json_encode($blog), $user, FileService::STATUS_ACTIVE, $id);
            }

            $return['result'] = true;
            return response()->json($return);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function export_slug($locale, Request $request, FileService $fileService)
    {
        try {
            $blogs = Blogs::select('id','title')->where("lang", $locale)->where("status", ">", 0)->orderBy("seqno", "asc")->pluck('id')->toArray();

        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function convertTitleToURL($str) { 
	
        // Convert string to lowercase 
        $str = strtolower($str); 
        
        // Replace the spaces with hyphens 
        $str = str_replace(' ', '-', $str); 
        
        // Remove the special characters 
        $str = preg_replace('/[^a-z0-9\-]/', '', $str); 
        
        // Remove the consecutive hyphens 
        $str = preg_replace('/-+/', '-', $str); 
        
        // Trim hyphens from the beginning 
        // and ending of String 
        $str = trim($str, '-'); 
        
        return $str; 
    } 

    public function updateDetail($locale, Request $request)
    {
        Logger()->debug(" updateDetail ");
        Logger()->debug(" updateDetail : data " . var_export($request->all(), true));
        try {

            $this->validate(
                $request,
                [
                    'editmode' => 'required',
                ],
                [
                    'editmode.required' => 'Editmode is required.',
                ]
            );
            $user = ($request->has('username') ? $request->get('username') : 'SYSTEM');

            if ($request->get('editmode') == 'add'){
                // create new
                $this->validate(
                    $request,
                    [
                        'title' => 'required',
                    ],
                    [
                        'title.required' => 'Title is required.',
                    ]
                );

                $blogData = $request->only('partno','title','subtitle',/*'related_products','seqno',*/'is_highlight','releasedate','btype','status');
                if ($request->has('related_products')){
                    $blogData['related_products']= implode(",",$request->get('related_products'));
                }
                // convert title to slug convertTitleToURL
                $blogData['slug'] = $this->convertTitleToURL($blogData['title']);
                
                
                $newBlog = new Blogs();
                $newBlog->fill($blogData);
                $newBlog->save();
                

                $newBlog = Blogs::whereId($newBlog->id)->whereLang($locale)->get()->first();
                $blogId=$newBlog->id;
                // blog base64 content
                if ($request->has('contents') && $request->get('contents') ){
                    $content = $request->get('contents');
        
                    $content = str_replace('<figure', '<div class="img_caption"', $content); // Replace <figure> with <div>
                    $content = str_replace('</figure>', '</div>', $content);

                    $dom = new \DomDocument('1.0', 'UTF-8');
        
                    $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');


                    @$dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        
                    $images = $dom->getElementsByTagName('img');
        
                    foreach ($images as $key => $img) {
                        
                        $src = $img->getAttribute('src');
                        Logger()->debug(" updateDetail src " . var_export($src, true));
                        // Check if the src is a base64 image
                        if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                            // Get the image type (png, jpg, etc.)
                            $imageType = strtolower($type[1]);
                            
        
                            // Decode the base64 string
                            $base64Data = substr($src, strpos($src, ',') + 1);
                            $decodedData = base64_decode($base64Data);
        
                            // Generate a unique filename
                        // $filename = uniqid() . '.' . $imageType;
                            $filename = $img->getAttribute('data-filename');
        
                            // Store the file in Laravel's storage (e.g., public/images)
                            Storage::disk('web2206')->put('img/blog/'.$locale.'/' . $blogId.'/'.$filename, $decodedData);
                            Storage::disk('www_docs')->put('img/blog/'.$locale.'/' . $blogId.'/'.$filename, $decodedData);
        
                            $filePath = '/img/blog/'.$locale.'/' . $blogId.'/';
                            // Replace the base64 image with the stored file's URL in the HTML Storage::url('images/' . $filename))
                            $img->setAttribute('src', $filePath.$filename);
                        }
                    }
        
                    // Save the modified HTML content to the database
                    $modifiedContent = $dom->saveHTML();
                    $newBlog->contents = $modifiedContent;
                }

                // blog topimage
                if ($request->hasFile('topimage')){
    
                    $topimg = $request->file('topimage');
                    $folderPath = ($request->has('folderPath') ? $request->get('folderPath') : 'img/blog/'.$locale.'/' . $blogId);
                    $filename = ($request->has('new_filename') ? $request->get('new_filename') : $topimg->getClientOriginalName());
                    $disktype = ($request->has('diskType') ? $request->get('diskType') : 'www_docs'); 
                    logger()->debug(" updateDetail - topimage :  - $folderPath, $filename,$disktype");
                    if (!Storage::disk($disktype)->exists($folderPath)) {
                        Storage::disk($disktype)->makeDirectory($folderPath);
                    }
                    $uploaded = $request->file('topimage')->storeAs($folderPath,$filename, $disktype);
                    logger()->debug(" updateDetail - topimage :  - $folderPath, $filename,$disktype,$uploaded");
                    $newBlog->topimage = $filename;
                }
                logger()->debug(" updateDetail - newBlog : " . var_export($newBlog,true));
                //handle featured blog
                $newBlog->featured_blog = is_array($request->get('featured_blog')) ? implode(",", $request->get('featured_blog')) : "";
                // add created_by
                $newBlog->created_by = $user;
                
                $return['result'] = false;
                if ($newBlog->save()){
                    $return['result'] = true;
                    $return['data'] = $newBlog->toArray();
                    return response()->json($return);
                } else {
                    return response()->json($return);
                }

            } else {
                // update
                $this->validate(
                    $request,
                    [
                        'id' => 'required',
                    ],
                    [
                        'id.required' => 'ID is required.',
    
                    ]
                );
                $blogData = [];
                $blogId = $request->get('id');
                $blog = Blogs::whereId($blogId)->whereLang($locale)->get()->first();
    
                if ($request->has('contents') && $request->get('contents') ){
                    $content = $request->get('contents');

                    $content = str_replace('<figure', '<div class="img_caption"', $content); // Replace <figure> with <div>
                    $content = str_replace('</figure>', '</div>', $content);
         
                     $dom = new \DomDocument('1.0', 'UTF-8');
         
                     $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
     
                     @$dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
         
                     $images = $dom->getElementsByTagName('img');
         
                     foreach ($images as $key => $img) {
                         
                         $src = $img->getAttribute('src');
                         Logger()->debug(" updateDetail src " . var_export($src, true));
                         // Check if the src is a base64 image
                         if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                             // Get the image type (png, jpg, etc.)
                             $imageType = strtolower($type[1]);
         
                             // Decode the base64 string
                             $base64Data = substr($src, strpos($src, ',') + 1);
                             $decodedData = base64_decode($base64Data);
         
                             // Generate a unique filename
                             $filename = uniqid() . '.' . $imageType;
         
                             // Store the file in Laravel's storage (e.g., public/images)
                             Storage::disk('web2206')->put('img/blog/'.$locale.'/' . $blogId.'/'.$filename, $decodedData);
                             Storage::disk('www_docs')->put('img/blog/'.$locale.'/' . $blogId.'/'.$filename, $decodedData);
         
                             $filePath = '/img/blog/'.$locale.'/' . $blogId.'/';
                             // Replace the base64 image with the stored file's URL in the HTML Storage::url('images/' . $filename))
                             $img->setAttribute('src', $filePath.$filename);
                         }
                     }
         
                     // Save the modified HTML content to the database
                     $modifiedContent = $dom->saveHTML();
                    // $blog->contents = $modifiedContent;
                     $blogData['contents'] = $modifiedContent;
                     Logger()->debug(" updateDetail modifiedContent " . var_export($modifiedContent, true));
                }
                
                
                $blogData['title'] = $request->get('title');
                $blogData['subtitle'] = $request->get('subtitle');
                
                $blogData['releasedate'] = $request->get('releasedate');
                $blogData['btype'] = $request->get('btype');
                $blogData['slug'] = $this->convertTitleToURL($request->get('title'));

                if ($request->has('related_products')){
                    $blogData['related_products'] = implode(",",$request->get('related_products'));
                }
                // handle topimage
                if ($request->hasFile('topimage')){
                    $topimg = $request->file('topimage');
                    $folderPath = ($request->has('folderPath') ? $request->get('folderPath') : 'img/blog/'.$locale.'/' . $blogId);
                    $filename = ($request->has('new_filename') ? $request->get('new_filename') : $topimg->getClientOriginalName());
                    $disktype = ($request->has('diskType') ? $request->get('diskType') : 'www_docs'); 
                    logger()->debug(" updateDetail - topimage :  - $folderPath, $filename,$disktype");
                    $uploaded = $topimg->storeAs($folderPath, $filename, $disktype);
                    logger()->debug(" updateDetail - topimage :  - $folderPath, $filename,$disktype,$uploaded");
                    $blogData['topimage'] = $filename;
                }
    
                //handle featured blog
                $blogData['featured_blog'] = is_array($request->get('featured_blog')) ? implode(",", $request->get('featured_blog')) : "";
                
                $return['result'] = false;
                if ($blog->saveChangesAndRecordHistory($blogData,'update',$user)){
                    $return['result'] = true;
                    $return['data'] = $blog->toArray();
                    return response()->json($return);
                } else {
                    return response()->json($return);
                }

            }
            
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        } catch (Exception $e) {
            Logger()->debug(" updateDetail : error - " . var_export($e->getMessage(), true));
            return response()->json($e->getMessage());
        }

        
    }

}
