<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use App\Models\UploadFiles;
use App\Models\UploadFilesTasks;
use Illuminate\Support\Facades\Storage;
use DB;

class UploadFileService
{
    protected $dbService;
    protected $tablename;
    protected $tasksTable;
    protected $dbconn;
    protected $webdbconn;

    public function __construct()
    {
        $this->tablename = 'upload_files';
        $this->tasksTable = 'upload_files_tasks';
    }

    public function findRemotePath($etype, $ftype, $lang, $location = 'web2206')
    {
        $file['web2206']['blog']['img'] = "/img/blog/$lang/";
        $file['web2206']['blog']['config'] = "/config/blogs/$lang/";
        $file['web2206']['product']['list'] = "/config/product/$lang/";
        $file['web2206']['product']['detail'] = "/config/product/$lang/";
        $file['web2206']['product']['gallery'] = "/img/product/common/gallery/00/";
        $file['web2206']['product']['feature'] = "/img/product/common/feature/00/";
        $file['web2206']['product']['Reviews'] = "/img/product/common/Reviews/00/";
        $file['web2206']['product']['content'] = "/img/product/common/content/00/";
        $file['web2206']['product']['support'] = "/img/product/common/support/00/";
        $file['web2206']['filter']['filteritem'] = "/config/filter/$lang/";
        $file['web2206']['navimenu']['topmenu'] = "/config/navimenu/$lang/";
        $file['web2206']['search']['list'] = "/search/$lang/";
        $file['web2206']['legacy']['conf'] = "/config/legacy/$lang/";
        $file['web2206']['legacy']['img'] = "/img/product/common/gallery/00/";
        $file['web2206']['lang']['conf'] = "/config/lang/$lang/";
        $file['web2206']['listpage_banner']['conf'] = "/config/banner/";
        $file['web2206']['sales_office']['conf'] = "/config/sales_office/";
        $file['web2206']['layout']['list'] = "/app/view/layout/list/";
        $file['web2206']['layout']['blogs'] = "/app/view/layout/blogs/";
        $file['web2206']['layout']['sidebar'] = "/app/view/layout/sidebar/";
        $file['web2206']['layout']['site'] = "/app/view/layout/site/1/";
        $file['web2206']['layout']['support'] = "/app/view/layout/support/";
        $file['web2206']['layout']['conf'] = "/app/view/layout/";
        $file['web2206']['css']['conf'] = "/css/";
        $file['web2206']['js']['conf'] = "/js/";
        $file['web2206']['search']['conf'] = "/search/$lang/";
        $file['web2206']['root']['php'] = "/";


        //app\view\layout\list


        return $file[$location][$etype][$ftype];
    }

    public function addUploadFilesTasks($uploadFilesId, $hostname, $launch_datetime, $status, $created_by)
    {
        $newTask = UploadFilesTasks::firstOrNew(
            ['upload_files_id' => $uploadFilesId, 'hostname' => $hostname, 'launch_datetime' => $launch_datetime, 'status' => $status, 'created_by' => $created_by]
        );
        if ($newTask->save()){
            return $newTask->id;
        } else {
            return false;
        }
    }

    public function addUploadRecord($localFile, $remoteFile, $etype, $lang, $method, $partno = null, $created_by)
    {
        $newUploadFiles = UploadFiles::firstOrNew(
            ['local_file' => $localFile, 'remote_file' => $remoteFile, 'etype' => $etype, 'lang' => $lang]
        );

        if ($partno){
            $newUploadFiles->partno = $partno;
        }
        $newUploadFiles->method = $method;
        $newUploadFiles->created_by = $created_by;

        return $newUploadFiles->save();
    }

    public function updateTask($id, $status, $hostname, $launch_datetime, $updated_by)
    {
        return UploadFilesTasks::whereId($id)
            ->update([
                'status' => $status,
                'hostname' => $hostname,
                'launch_datetime' => $launch_datetime,
                'updated_by' => $updated_by
            ]);
    }
    
    public function updateUploadFilesStatus($id, $status, $updated_by)
    {
        return UploadFiles::whereId($id)
            ->update([
                'status' => $status, 'updated_by' => $updated_by
            ]);
    }

    public function updateUploadFilesDate($id, $updated_at, $updated_by)
    {
        return UploadFiles::whereId($id)
                    ->update([
                        'updated_at' => $updated_at, 'updated_by' => $updated_by
                    ]);
    }
    
    public function updateUploadFilesTasksStatus($id, $status, $updated_by)
    {
        return UploadFilesTasks::whereId($id)
                    ->update([
                        'status' => $status, 'updated_by' => $updated_by
                    ]);
    }

    // uploadedFile
    public function uploadedFile($id, $status, $updated_by)
    {
        return UploadFilesTasks::whereId($id)
                    ->update([
                        'status' => $status, 'updated_by' => $updated_by, "uploaded_at" => date("Y-m-d H:i:s")
                    ]);
    }

    public function updateLaunchDatetime($id, $launchDatetime)
    {
        return UploadFilesTasks::whereId($id)
        ->update([
            'launch_datetime' => $launchDatetime
        ]);
    }
}
