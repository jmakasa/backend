<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use App\Models\UploadFiles;
use App\Models\Reviewsites;
use Illuminate\Support\Facades\Storage;
use DB;

class FileService
{
    protected $DOCDIR;
    protected $webDir2206;
    protected $marketingDir;
    protected $ctype_array;
    const TYPE_PRODUCT = "product";
    const TYPE_CONFIG = "config";
    const TYPE_NAVIMENU = "navimenu";
    const TYPE_MARKETING_TPL = "marketing_tpl";
    const TYPE_FILTER = "filter";
    const TYPE_REVIEWSITE = "reviewsite";


    const FILE_TYPE_FEATURE = "feature";
    const FILE_TYPE_GALLERY = "gallery";
    const FILE_TYPE_CONTENT = "content";
    const FILE_TYPE_REVIEWS = "Reviews";
    const FILE_TYPE_CPY = "compatibility";
    const FILE_TYPE_MANUAL = "manual";
    const FILE_TYPE_MOVIE = "movie";
    const FILE_TYPE_SOFTWARE = "software";
    const FILE_TYPE_BLOG = "blog";
    const FILE_TYPE_BLOG_IMG = "blog_img";
    const FILE_TYPE_CONF = 'conf';
    const FILE_TYPE_REVIEWSITE = 'reviewsite';
    const FILE_TYPE_REVIEWSITELOGO = 'reviewsite_logo';
    const FILE_TYPE_REVIEW_FEATUREIMG = 'product_reviews_img';



    // $file['web2206']['blog']['img'] = "/img/blog/$lang/";
    // $file['web2206']['blog']['config'] = "/config/blogs/$lang/";
    // $file['web2206']['product']['list'] = "/config/product/$lang/";
    // $file['web2206']['product']['detail'] = "/config/product/$lang/";
    // $file['web2206']['product']['gallery'] = "/img/product/common/gallery/00/";
    // $file['web2206']['product']['feature'] = "/img/product/common/feature/00/";
    // $file['web2206']['product']['Reviews'] = "/img/product/common/Reviews/00/";
    // $file['web2206']['product']['content'] = "/img/product/common/content/00/";
    // $file['web2206']['product']['support'] = "/img/product/common/support/00/";
    // $file['web2206']['filter']['filteritem'] = "/config/filter/$lang/";
    // $file['web2206']['navimenu']['topmenu'] = "/config/navimenu/$lang/";
    // $file['web2206']['search']['list'] = "/search/$lang/";
    // $file['web2206']['legacy']['conf'] = "/config/legacy/$lang/";
    // $file['web2206']['legacy']['img'] = "/img/product/common/gallery/00/";
    // $file['web2206']['lang']['conf'] = "/config/lang/$lang/";
    // $file['web2206']['listpage_banner']['conf'] = "/config/banner/";
    // $file['web2206']['sales_office']['conf'] = "/config/sales_office/";
    // $file['web2206']['layout']['list'] = "/app/view/layout/list/";
    // $file['web2206']['layout']['blogs'] = "/app/view/layout/blogs/";
    // $file['web2206']['layout']['sidebar'] = "/app/view/layout/sidebar/";
    // $file['web2206']['layout']['site'] = "/app/view/layout/site/1/";
    // $file['web2206']['layout']['support'] = "/app/view/layout/support/";
    // $file['web2206']['layout']['conf'] = "/app/view/layout/";
    // $file['web2206']['css']['conf'] = "/css/";
    // $file['web2206']['js']['conf'] = "/js/";
    // $file['web2206']['search']['conf'] = "/search/$lang/";
    // $file['web2206']['root']['php'] = "/";

    public function __construct()
    {
        $this->DOCDIR = env("DOCDIR", "/akasa/www/docs");
        $this->webDir2206 = env("AKASAWEBDIR_2206", "/akasa/www/akasa2206");
        $this->marketingDir = env("MARKETING_DIR", "/akasa/www/marketing");
        $this->ctype_array = array('feature' => 'Features', 'gallery' => 'Gallery', 'content' => 'Contents', 'Reviews' => 'Reviews');
    }

    public function createConf($type, $filename, $lang, $json, $partno = '')
    {
        switch ($type) {
            case FileService::FILE_TYPE_BLOG:
                $path =  "/config/blog/" . $lang . "/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_PRODUCT:
                $path =  "/config/product/" . $lang . "/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_CONFIG:
                $path =  "/config/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_NAVIMENU:
                $path =  "/config/navimenu/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_MARKETING_TPL:
                // backend
                $path =  "";
                $destinationPath = $this->marketingDir . "/templates/";
                break;
            case FileService::TYPE_FILTER:
                // WEB filter
                $path =  "/config/filter/" . $lang . "/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_REVIEWSITE:
                $path =  "/config/reviewsites/";
                $destinationPath = $this->webDir2206 . $path;
                break;
        }
        if (!is_dir($destinationPath)) {
            logger()->debug(" FileService - createConf : folder create " . var_export($destinationPath, true));
            mkdir($destinationPath, 0777, true);
        }
        logger()->debug(" FileService - createConf : DATA $destinationPath, $type, $filename, $lang ");
        if ($path) {
            $this->addUploadFile($destinationPath . $filename, $path . $filename, $type, $lang, 'ftp', 'system', 'akasa2206_uk', $partno);
            return Storage::disk('web2206')->put($path . $filename, $json);
        } else {
            return File::put($destinationPath . $filename, $json);
        }
    }

    public function exportFiles($type, $filename, $partno, $locale)
    {
        logger()->debug(" FileService - export images : $type");
        $readyToGo = false;
        switch ($type) {
            case FileService::FILE_TYPE_FEATURE:
            case FileService::FILE_TYPE_GALLERY:
            case FileService::FILE_TYPE_CONTENT:
            case FileService::FILE_TYPE_REVIEWS:
                $fromPath = $this->DOCDIR . "/products/" . $partno . "/Web_Library/" . $this->ctype_array[$type] . "/";
                $remotePath = "/img/product/common/" . $type . "/00/";
                $toPath = $this->webDir2206 . $remotePath;
                $readyToGo = true;
                break;
                // case FileService::FILE_TYPE_BLOG:
                // case FileService::FILE_TYPE_BLOG_IMG:
                //         $fromPath = $this->DOCDIR . "/blog/" . $partno . "/Web_Library/" . $this->ctype_array[$type] . "/";
                //         $path = "/img/product/common/" . $type . "/00/";
                //         $toPath = $this->webDir2206 . $path;
                //         $readyToGo = true;
                //         break;
            case FileService::FILE_TYPE_CPY:
            case FileService::FILE_TYPE_MANUAL:
            case FileService::FILE_TYPE_MOVIE:
            case FileService::FILE_TYPE_SOFTWARE:
                // $ftype = $row['ftype'];
                // $from = "/akasa/www/docs/products/" . $partno . "/Web_Library/Download/" . $row['docname'];
                // $to = "/akasa/www/akasa10/download/" . $ftype . "/" . $row['docname'];
                $fromPath = $this->DOCDIR . "/products/" . $partno . "/Web_Library/Download/";
                $remotePath = "/download/" . $type . "/";
                $toPath = $this->webDir2206 . $remotePath;
                $readyToGo = true;
                break;
            case FileService::FILE_TYPE_REVIEWSITE:
                $fromPath = $this->marketingDir . Reviewsites::FILEPATH;
                //"/img/product/common/review/icon/";
                $remotePath = "/img/product/common/Reviews/00/icon/";
                $toPath = $this->webDir2206 . $remotePath;
                $readyToGo = true;
                break;
            default:
                break;
        }
        if ($readyToGo) {
            logger()->debug(" FileService - export images : $type, $filename, $partno " . var_export($fromPath, true));
            logger()->debug(" FileService - export images : $type, $filename, $partno " . var_export($toPath, true));
            if (file_exists($fromPath . $filename)) {
                if (!is_dir($toPath)) {
                    mkdir($toPath, 0777, true);
                }
                $this->addUploadFile($fromPath . $filename, $remotePath . $filename, $type, $locale, 'ftp', 'system', 'akasa2206_uk', $partno);
                File::copy($fromPath . $filename, $toPath . $filename);
            }
        }
    }

    public function addUploadFile($localFile, $remoteFile, $etype, $lang, $method, $creator, $host = 'akasa2206_uk', $partno = '')
    {
        //    $data['hostname'] = $host;
        $data['local_file'] = $localFile;
        $data['remote_file'] = $remoteFile;
        $data['filename'] = basename($remoteFile);
        $data['etype'] = $etype;
        $data['lang'] = $lang;
        $data['method'] = $method;
        $data['partno'] = $partno;
        $data['created_by'] = $creator;
        $newUploadRecord = UploadFiles::updateOrCreate(
            ['filename' => basename($remoteFile), 'etype' => $etype, 'lang' => $lang, 'partno' => $partno],
            ['local_file' => $localFile, 'remote_file' => $remoteFile, 'method' => $method, 'updated_by' => $creator, 'created_by' => $creator, 'updated_at' => NOW()]
        );
        // $newUploadRecord = (new UploadFiles)
        // ->validateAndFill($data);
        // $newUploadFile->updateOrCreate

        if ($newUploadRecord->save()) {
            //     logger()->debug(" FileService - addUploadFile : file -  $localFile ".var_export($newUploadRecord,true));
            return true;
        } else {
            return false;
        }
    }

    public function moveFile($type, $filename)
    {
        logger()->debug(" FileService - export images : $type");
        $readyToGo = false;
        switch ($type) {
            case FileService::FILE_TYPE_REVIEWSITE:
                $fromPath = Reviewsites::FILEPATH;
                $toPath = Reviewsites::FILEPATH . "/backup/";
                $disk = 'marketing';
                break;
        }

        if (File::exists($fromPath . $filename)) {
            return Storage::disk($disk)->move($fromPath . $filename, $toPath . $filename);
        } else {
            logger()->debug(" FileService - moveFile : not exist : $type, $filename");
        }
    }
    public function renameFile($type, $filename, $newFilename, $filepath = "")
    {
        logger()->debug(" FileService - renameFile : $type,$filename, $newFilename,$filepath");
        switch ($type) {
            case FileService::FILE_TYPE_REVIEWSITE:
                // $filepath = Reviewsites::FILEPATH;
                $disk = 'marketing_reviewsite';
                break;
            case FileService::FILE_TYPE_REVIEW_FEATUREIMG:
                $disk = 'product_docs';
                break;
        }
        $oldFile = $filepath . $filename;
        
        $newFile = $filepath . $newFilename;
        logger()->debug(" FileService - old file : $oldFile");

        if (Storage::disk($disk)->exists($oldFile)) { // check existing file
            if (Storage::disk($disk)->exists($newFile)) { // check new filename is exisit
                Storage::disk($disk)->delete($newFile);
                return Storage::disk($disk)->move($oldFile, $newFile);
            } else {
                return Storage::disk($disk)->move($oldFile, $newFile);
            }
            
        } else {
            logger()->debug(" FileService - moveFile : not exist : $type, $filename");
        }
    }

    public function removeFile($type, $filename, $filepath = ""){
        switch ($type) {
            case FileService::FILE_TYPE_REVIEWSITE:
                // $filepath = Reviewsites::FILEPATH;
                $disk = 'marketing_reviewsite';
                break;
            case FileService::FILE_TYPE_REVIEW_FEATUREIMG:
                $disk = 'product_docs';
                break;
        }
        $toBeRemove = $filepath."/".$filename;
        if (Storage::disk($disk)->exists($toBeRemove)) { // check new filename is exisit
            return Storage::disk($disk)->delete($toBeRemove);
        } else {
            return false;
        }
    }

    public function cleanStr($string){
        // Replaces all spaces with hyphens.
        $string = str_replace(' ', '-', $string);
    
        // Removes special chars.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        // Replaces multiple hyphens with single one.
        $string = preg_replace('/-+/', '-', $string);
        
        return $string;
    }
}
