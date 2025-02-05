<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use App\Models\UploadFiles;
use App\Models\Reviewsites;
use App\Models\SalesProjectDocs;
use Illuminate\Support\Facades\Storage;
use DB;
use Vinkla\Hashids\Facades\Hashids;
use Carbon\Carbon;

class FileService
{
    protected $DOCDIR;
    protected $webDir2206;
    protected $webDirOEM;
    protected $marketingDir;
    protected $ctype_array;
    protected $productConfPath;
    protected $salesProjectsPath;

    const TYPE_PRODUCT = "product";
    const TYPE_CONFIG = "config";
    const TYPE_NAVIMENU = "navimenu";
    const TYPE_MARKETING_TPL = "marketing_tpl";
    const TYPE_FILTER = "filter";
    const TYPE_REVIEWSITE = "reviewsite";
    const TYPE_TOP_SALES = "top_sales";
    const TYPE_SALES_OFFICES = "sales_offices";
    const TYPE_WHERE2BUY = "where2buy";
    const TYPE_FCCHECK = "fanless_case_check";
    const TYPE_OEMDCFANLIST = "oem_dcfan";


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
    const FILE_TYPE_BLOG_CIMG = "blog_content_img";
    const FILE_TYPE_CONF = 'conf';
    const FILE_TYPE_REVIEWSITE = 'reviewsite';
    const FILE_TYPE_REVIEWSITELOGO = 'reviewsite_logo';
    const FILE_TYPE_REVIEW_FEATUREIMG = 'product_reviews_img';
    const FILE_TYPE_AKASAONE_ACCTLOGO = "acct_logo";
    const FILE_TYPE_ECOMMERCE_URLS_LOGO = 'ecommerce_urls_logo';
    const FILE_TYPE_WHERE_TO_BUY_SALES = 'ecommerce_url';
    const FILE_TYPE_FCCHECK = 'fanless_case_check';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;


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
        $this->webDirOEM = env("AKASAWEBDIR_OEM", "/akasa/www/akasaoem2411");
        $this->marketingDir = env("MARKETING_DIR", "/akasa/www/marketing");
        $this->ctype_array = array('feature' => 'Features', 'gallery' => 'Gallery', 'content' => 'Contents', 'Reviews' => 'Reviews');
        $this->productConfPath = DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "product" . DIRECTORY_SEPARATOR;
    }

    public function createConf($type, $filename, $lang, $json, $user='',$status=1, $partno = '')
    {
        switch ($type) {
            case FileService::FILE_TYPE_BLOG:
                $disk = 'web2206';
                $path =  "/config/blog/" . $lang . "/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::FILE_TYPE_BLOG_IMG:
            case FileService::FILE_TYPE_BLOG_CIMG:
                $disk = 'web2206';
                $path =  "/img/blog/" . $lang . "/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_PRODUCT:
                $disk = 'web2206';
                $path =  "/config/product/" . $lang . "/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_CONFIG:
                $disk = 'web2206';
                $path =  "/config/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_NAVIMENU:
                $disk = 'web2206';
                $path =  "/config/navimenu/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_MARKETING_TPL:
                // backend
                $disk = 'web2206';
                $path =  "";
                $destinationPath = $this->marketingDir . "/templates/";
                break;
            case FileService::TYPE_FILTER:
                // WEB filter
                $disk = 'web2206';
                $path =  "/config/filter/" . $lang . "/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_REVIEWSITE:
                $disk = 'web2206';
                $path =  "/config/reviewsites/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_TOP_SALES:
                $disk = 'web2206';
                $path =  "/config/top_sales/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_SALES_OFFICES:
                $disk = 'web2206';
                $path =  "/config/sales_offices/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_WHERE2BUY:
                $disk = 'web2206';
                $path =  "/config/where2buy/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_FCCHECK:
                $disk = 'web2206';
                $path =  "/config/fanless_case_check/";
                $destinationPath = $this->webDir2206 . $path;
                break;
            case FileService::TYPE_OEMDCFANLIST:
                $disk = 'akasaweb_oem';
                $path =  "/data/";
                $destinationPath = $this->webDirOEM . $path;
                break;
        }
        // if (!is_dir($destinationPath)) {
        //     logger()->debug(" FileService - createConf : folder create " . var_export($destinationPath, true));
        //     mkdir($destinationPath, 0777, true);
        // }
        logger()->debug(" FileService - createConf : DATA $destinationPath, $type, $filename, $lang,$user,$status, $partno ");
        if ($path) {
            $user = ($user ? $user : 'system');
            $this->addUploadFile($destinationPath . $filename, $path . $filename, $type, $lang, 'ftp', $user, $status, 'akasa2206_uk', $partno);
            logger()->debug(" FileService - PUT file $path.$filename ");
            $filePath = Storage::disk($disk)->put($path . $filename, $json);
            return $filePath;
        } else {
            logger()->debug(" FileService - NO PATH -  PUT file $destinationPath . $filename ");
            return File::put($destinationPath . $filename, $json);
        }
    }

    public function exportFiles($type, $filename, $partno, $locale, $user='', $status = 1)
    {
        logger()->debug(" FileService - export images : $type, $filename, $partno,$user");
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
                //     $fromPath = $this->DOCDIR . "/blog/" . $partno .  "/";
                //         $path = "/img/blog/" . $partno .  "/";
                //         $toPath = $this->webDir2206 . $path;
                //         $readyToGo = true;
                //         break;
            case FileService::FILE_TYPE_BLOG_IMG:
            case FileService::FILE_TYPE_BLOG_CIMG:
                $fromPath = $this->DOCDIR . "/img/blog/$locale/$partno/";
                $remotePath = "/img/blog/$locale/$partno/";
                $toPath = $this->webDir2206 . $remotePath;
                $readyToGo = true;
                break;
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
            case FileService::FILE_TYPE_ECOMMERCE_URLS_LOGO:
                $pinfo = pathinfo($filename);
                // $pinfo['dirname']; $pinfo['basename']; $pinfo['extension']; $pinfo['filename']; 
                $fromPath = $this->DOCDIR . "/akasaone/" . $pinfo['dirname'] . "/";
                //"/img/product/common/review/icon/";
                $remotePath = "/img/product/common/e_url/" . $pinfo['dirname'] . "/";
                $filename = $pinfo['basename'];
                $toPath = $this->webDir2206 . $remotePath;
                $readyToGo = true;
                break;
            default:
                break;
        }
        if ($readyToGo) {
            $user= ($user ? $user : 'system');
            logger()->debug(" FileService - export images : $type, $filename, $partno ");
            logger()->debug(" FileService - from: $fromPath, to:$toPath");
            if (file_exists($fromPath . $filename)) {
                logger()->debug(" FileService - export has images : ".$fromPath . $filename);
                if (!is_dir($toPath)) {
                    mkdir($toPath, 0777, true);
                }
                $this->addUploadFile($fromPath . $filename, $remotePath . $filename, $type, $locale, 'ftp', $user, $status, 'akasa2206_uk', $partno);
                File::copy($fromPath . $filename, $toPath . $filename);
            } else {
                logger()->debug(" FileService - Image NO FOUND : ".$fromPath . $filename);
            }
        }
    }

    public function changeStatus($etype, $partno, $status, $user, $host = 'akasa2206_uk', $id = null)
    {
        $listData = UploadFiles::where('etype', $etype)->where('partno', $partno)->where('etype', $etype);

        if ($id) {
            $listData->whereId($id);
        }
        $tot = $listData->count();
        $cnt = 0;
        foreach ($listData->get() as $data) {
            $uploadFile = UploadFiles::whereId($data->id)->update([
                'status' => $status,
                'updated_by' => $user
            ]);
            if ($uploadFile) {
                $cnt++;
            }
        }
        if ($tot == $cnt) {
            return true;
        } else {
            return false;
        }
    }

    public function addUploadFile($localFile, $remoteFile, $etype, $lang, $method, $creator, $status,$host = 'akasa2206_uk', $partno = '')
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
            ['local_file' => $localFile, 'remote_file' => $remoteFile, 'status' =>$status, 'method' => $method, 'updated_by' => $creator, 'created_by' => $creator, 'updated_at' => NOW()]
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

    public function removeUploadFile($localFile, $remoteFile, $etype, $lang, $method, $creator, $host = 'akasa2206_uk', $partno = '') {}

    public function moveFile($type, $filename)
    {
        logger()->debug(" FileService - moveFile : $type, $filename");
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

    public function removeFile($type, $filename, $filepath = "")
    {
        switch ($type) {
            case FileService::FILE_TYPE_REVIEWSITE:
                // $filepath = Reviewsites::FILEPATH;
                $disk = 'marketing_reviewsite';
                break;
            case FileService::FILE_TYPE_REVIEW_FEATUREIMG:
                $disk = 'product_docs';
                break;
        }
        $toBeRemove = $filepath . "/" . $filename;
        if (Storage::disk($disk)->exists($toBeRemove)) { // check new filename is exisit
            return Storage::disk($disk)->delete($toBeRemove);
        } else {
            return false;
        }
    }




    public function cleanStr($string)
    {
        // Replaces all spaces with hyphens.
        $string = str_replace(' ', '-', $string);

        // Removes special chars.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        // Replaces multiple hyphens with single one.
        $string = preg_replace('/-+/', '-', $string);

        return $string;
    }

    public function storeLogoEcommUrl($type, $imglogo)
    {

        switch ($type) {
            case FileService::FILE_TYPE_AKASAONE_ACCTLOGO:
                $url = "http://192.168.8.18/akasaone/public/docs/akasaone/";
                $disk = 'akasaone';
                break;
        }

        $fileHeader = get_headers($url . $imglogo);
        logger()->debug(" FileService - storeLogoEcommUrl :  FILE $url.$imglogo ");
        logger()->debug(" FileService - storeLogoEcommUrl :  fileHeader " . var_export($fileHeader, true));


        if ($fileHeader[0] != 'HTTP/1.1 404 Not Found') {
            $imageContent = file_get_contents($url . $imglogo);
            $pinfo = pathinfo($imglogo);
            logger()->debug(" FileService - storeLogoEcommUrl :  pinfo " . var_export($pinfo, true));
            if (!Storage::disk($disk)->exists($pinfo['dirname'])) {
                Storage::disk($disk)->makeDirectory($pinfo['dirname']);

                return Storage::disk($disk)->put($imglogo, $imageContent);
            } else {
                return Storage::disk($disk)->put($imglogo, $imageContent);
            }
        } else {
            return false;
        }
    }

    /***
     * return array
     * primary_folder
     * secondary_folder
     * tempFile
     */
    public function generateUploadFilePath($id, $type, $filename)
    {
        if ($id && $type && $filename) {
            $folder_prefix_no = 0;
            $related_id_field = "";
            switch ($type) {
                case 'ticket_threads_attachments':
                    $related_id_field = 'ticket_threads_id';
                    $folder_prefix_no = "10000";
                    break;
                case 'ticket_attachments':
                    $related_id_field = 'tickets_id';
                    $folder_prefix_no = "12000";
                    break;
            }

            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            $tempName = Hashids::encode($id . rand(1, 999999));
            $now = Carbon::now();
            $primary_folder = Hashids::encode($now->year . $now->month);
            // print_r(Hashids::decode('WkR5M0ADXj'));
            $secondary_folder = Hashids::encode($folder_prefix_no . $id);

            $primaryPath = public_path() . "/" . $type . "/" . $primary_folder . "/";
            if (!File::isDirectory($primaryPath)) {
                logger()->debug(" $type : isDirectory folder need to be created " . var_export($primaryPath, true));
                File::makeDirectory($primaryPath, 0777, true, true);
            }

            $secondaryPath = public_path() . "/" . $type . "/" . $primary_folder . "/" . $secondary_folder . "/";
            if (!File::isDirectory($secondaryPath)) {
                logger()->debug(" $type : isDirectory folder need to be created " . var_export($secondaryPath, true));
                File::makeDirectory($secondaryPath, 0777, true, true);
            }

            return [
                $related_id_field => $id,
                'filename' => $filename,
                'stored_filename' => $tempName . "." . $extension,
                'primary_folder' => $primary_folder,
                'secondary_folder' => $secondary_folder,
                'movePath' => public_path() . "/" . $type . "/" . $primary_folder . "/" . $secondary_folder . "/",
                'filepath' => "/" . $type . "/" . $primary_folder . "/" . $secondary_folder . "/",
                'ext' => $extension,
            ];
        }
        return false;
    }

    public function deleteProductConf($lang, $filename, $disk, $folderPath = "")
    {
        if ($folderPath) {
            $path =    $this->productConfPath . $lang . DIRECTORY_SEPARATOR . $folderPath . DIRECTORY_SEPARATOR;
        } else {
            $path =    $this->productConfPath . $lang . DIRECTORY_SEPARATOR;
        }
        return Storage::disk($disk)->delete($path . $filename);
    }

    public function createListByMenucat($lang, $folderPath, $filename, $aryData,$status =1)
    {

        // file path
        $path =    $this->productConfPath . $lang . DIRECTORY_SEPARATOR . $folderPath . DIRECTORY_SEPARATOR;
        // $destinationPath = $this->webDir2206 . $path;
        $destinationPath = $path;
        $exportFile = $destinationPath . $filename;

        if (!is_dir($destinationPath)) {
            logger()->debug(" FileService - createListByMenucat : folder create " . var_export($destinationPath, true));
            Storage::disk('web2206')->makeDirectory($destinationPath);
        }

        $aryFields = [
            'model',
            'title',
            'name',
            'pstatus',
            'img',
            'menucat',
            'boxitem',
            'filteritem',
            'subfilteritem'
        ];


        foreach ($aryFields as $field) {
            $data = "";
            if (isset($aryData[$field])) {

                $data = $aryData[$field];
                if (is_array($aryData[$field])) {
                    $data = implode(",", $aryData[$field]);
                }
                Storage::disk('web2206')->append($destinationPath . $filename, sprintf($field . " = %s\n", $data), null);
            }
        }

        Storage::disk('web2206')->append($destinationPath . $filename, "\n");
        // fprintf($handle, "\n\n");
        // fclose($handle);    
        return $this->addUploadFile($destinationPath . $filename, $path . $filename, 'list', $lang, 'ftp', 'system', $status,'akasa2206_uk');
    }
}
