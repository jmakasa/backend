<?php

namespace App\Http\Controllers;

use App\Models\UploadFiles;
use App\Models\UploadFilesTasks;

use App\Services\FtpService;
use App\Services\UploadFileService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use DB;
use Carbon\Carbon;

class UploadFilesController extends Controller
{
    protected $loginUser;
    protected $username;
    protected $hostpath;
    public function __construct()
    {
        logger()->debug(Auth::user());
        $this->loginUser = $this->loginUser();
        $this->username = $this->loginUser['username'];
        // for testing 
        //$this->hostpath = "/test_uploads"; // test purpose : /test_uploads  *** is empty normally
         $this->hostpath= ""; // live
    }

    public function getList($locale, Request $request)
    {
        $sort = $request->get('sort') ? $request->get('sort') : 'updated_at';
        $order = $request->get('order') ? strval($request->get('order')) : 'desc';
        $page = $request->get('page') ? intval($request->get('page')) : 1;
        $rows = $request->get('rows') ? intval($request->get('rows')) : 50;
        $offset = ($page - 1) * $rows;

        $listData = UploadFiles::orderBy($sort, $order);

        if ($request->has('etype') && $request->get('etype') != 'all') {
            $listData->where('etype', $request->get('etype'));
        }

        if ($request->has('partno') && $request->get('partno')) {
            $aryPartno = explode(" ", $request->get('partno'));
            if (count($aryPartno) > 1) {
                $listData->whereIn("partno", $aryPartno);
                $listData->orWhereIn("filename", $aryPartno);
            } else {
                if ($request->has('match_case') && $request->get('match_case') == 'true') {
                    $listData->where("partno", $request->get('partno'));
                    $listData->orWhere("filename", $request->get('partno'));
                } else {
                    $listData->where("partno", 'like', '%' . $request->get('partno') . "%");
                    $listData->orWhere("filename", 'like', '%' . $request->get('partno') . "%");
                }
            }
        }

        return response()->json([
            'total' => $listData->count(),
            'rows' => $listData->offset($offset)->take($rows)->get()
        ]);
    }

    public function getTaskList($locale, Request $request)
    {
        $sort = $request->get('sort') ? "upload_files_tasks." . $request->get('sort') : 'upload_files_tasks.updated_at';
        $order = $request->get('order') ? strval($request->get('order')) : 'desc';
        $page = $request->get('page') ? intval($request->get('page')) : 1;
        $rows = $request->get('rows') ? intval($request->get('rows')) : 50;
        $offset = ($page - 1) * $rows;

        $listData = UploadFilesTasks::select(
            'upload_files_tasks.id',
            'upload_files_tasks.hostname',
            'upload_files_tasks.launch_datetime',
            'upload_files_tasks.status',
            'upload_files_tasks.uploaded_at',
            'upload_files.filename',
            'upload_files.local_file',
            'upload_files.remote_file',
            'upload_files.etype',
            'upload_files.lang',
            'upload_files_tasks.created_at',
            DB::raw("(CASE WHEN upload_files_tasks.hostname = 'akasa2206_uk' THEN 'UK' ELSE 'TW' END) AS hostname ")
        )
            ->leftJoin('upload_files', 'upload_files_tasks.upload_files_id', '=', 'upload_files.id')->orderBy($sort, $order);



        if ($request->has('etype') && $request->get('etype') != 'all') {
            $listData->where('etype', $request->get('etype'));
        }

        // if ($request->has('partno') && $request->get('partno')) {
        //   //  $listData->where('partno', 'like', '%' . $request->get('partno') . '%');
        //   $listData->where('partno', $request->get('partno'));
        // }
        if ($request->has('partno') && $request->get('partno')) {
            $aryPartno = explode(" ", $request->get('partno'));
            if (count($aryPartno) > 1) {
                $listData->whereIn("partno", $aryPartno);
            } else {
                if ($request->has('match_case') && $request->get('match_case') == 'true') {
                    $listData->where("partno", $request->get('partno'));
                } else {
                    $listData->where("partno", 'like', '%' . $request->get('partno') . "%");
                }
            }
        }

        return response()->json([
            'total' => $listData->count(),
            'rows' => $listData->offset($offset)->take($rows)->get()
        ]);
    }

    public function getuploadedDatetimeByPartno($locale, Request $request){
        
        try {
            $this->validate(
                $request,
                [
                    'partno' => 'required',
                ],
                [
                    'partno.required' => 'partno is required.',
                ]
            );
            
            Logger()->debug(" getuploadedDatetimeByPartno : addTask - " . var_export($request->all(), true));
            $list = DB::table('upload_files_tasks')
                    ->leftJoin('upload_files','upload_files.id', "=","upload_files_tasks.upload_files_id")
                    ->where('upload_files.partno',$request->get('partno'))
                    ->groupBy('upload_files.filename')->orderBy("uploaded_datetime","desc")
                    ->get(['upload_files.id',
                    'upload_files.id',
                    'upload_files.partno',
                    'upload_files.filename', 
                    DB::raw('MAX(upload_files_tasks.uploaded_at) as uploaded_datetime')
                ]);

                Logger()->debug(" getuploadedDatetimeByPartno : get data - " . var_export($list, true));
            
                return response()->json([
                'total' => count($list),
                'rows' => $list
            ]);
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }

    }

    public function uploadBatchNow($locale, Request $request, UploadFileService $uploadFileService)
    {
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                    'hostname' => 'required',
                ],
                [
                    'id.required' => 'ID is required.',
                    'hostname.required' => 'hostname is required.',
                ]
            );
            // add to task
            $launch_datetime = $request->get('launch_datetime');
            if (is_array($request->get('id'))){
                $aryIds = $request->get('id');
            } else {
                $aryIds = explode(",", $request->get('id'));
            }
            $insertIds = [];
            foreach ($request->get('hostname') as $hostname) {
                foreach ($aryIds as $id) {
                    $insertIds[] = $uploadFileService->addUploadFilesTasks($id, $hostname, $launch_datetime, UploadFilesTasks::STATUS_PENDING, $this->username);
                    Logger()->debug(" uploadBatchNow : addTask - " . var_export($insertIds, true));
                }
            }

            return response()->json($this->doUploadByIds($insertIds));
            // $allTasks = UploadFilesTasks::select(
            //     'upload_files_tasks.id',
            //     'upload_files_tasks.hostname',
            //     'upload_files_tasks.launch_datetime',
            //     'upload_files_tasks.status',
            //     'upload_files_tasks.uploaded_at',
            //     'upload_files.filename',
            //     'upload_files.local_file',
            //     'upload_files.remote_file',
            //     'upload_files.etype',
            //     'upload_files.lang',
            //     'upload_files_tasks.created_at',
            //     'upload_files_tasks.hostname'
            // )
            //     ->leftJoin('upload_files', 'upload_files_tasks.upload_files_id', '=', 'upload_files.id')
            //     ->whereIn("upload_files_tasks.id", $insertIds);


            // $cntTasks = $allTasks->count();
            // $cntSuccess = [];
            // $cntFailed = 0;
            // $taskQueue = [];

            // foreach ($allTasks->get()->toArray() as $tData) {
            //     $taskQueue[$tData['hostname']][] = $tData;
            // }

            // foreach ($taskQueue as $hostname => $tasks) {
            //     Logger()->debug(" uploadBatchNow : hostname - $hostname");
            //     $ftpService = new FtpService($hostname);
            //     foreach ($tasks as $task) {
            //         $remote_file =  $this->hostpath . $task['remote_file'];
            //         $ftpService->checkAndCreateFolder($remote_file);

            //         if ($ftpService->uploadFile($task['local_file'], $remote_file)) {
            //             Logger()->debug(" uploadBatchNow : TID " . $task['id'] . ", uploaded remote_file - $remote_file");
            //             $uploadFileService->uploadedFile($task['id'], UploadFilesTasks::STATUS_UPLOADED, $this->username);
            //             $cntSuccess[] = $task['id'];
            //         } else {
            //             $uploadFileService->updateUploadFilesTasksStatus($task['id'], UploadFilesTasks::STATUS_FAILED, $this->username);
            //             $cntFailed++;
            //             Logger()->error(" uploadBatchNow : failed to upload file to server" . var_export($task, true));
            //         }
            //     }
            //     $ftpService->closeConnection();
            // }

            // if (count($cntSuccess) == $cntTasks && $cntFailed == 0) {
            //     return response()->json([
            //         'result' => true, 'data' => $cntSuccess
            //     ]);
            // } else {
            //     return response()->json([
            //         'result' => false, 'data' => $cntFailed
            //     ]);
            // }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function scheduleTasks($locale, Request $request, UploadFileService $uploadFileService)
    {
        try {
            $this->validate(
                $request,
                [
                    'id' => 'required',
                    'hostname' => 'required',
                    'launch_datetime' => 'required',
                ],
                [
                    'id.required' => 'ID is required.',
                    'hostname.required' => 'Hostname is required.',
                    'launch_datetime.required' => 'Launch datetime is required.',
                ]
            );
            Logger()->debug(" scheduleTasks :  IDs ". var_export($request->all(),true));
            $launch_datetime = $request->get('launch_datetime');
            if (is_array($request->get('id'))){
                $aryIds = $request->get('id');
            } else {
                $aryIds = explode(",", $request->get('id'));
            }
            //
            
            $insertIds = [];
            foreach ($request->get('hostname') as $hostname) {
                foreach ($aryIds as $id) {
                    $insertIds[] = $uploadFileService->addUploadFilesTasks($id, $hostname, $request->get('launch_datetime'), UploadFilesTasks::STATUS_SCHEDULED, $this->username);
                    Logger()->debug(" addTasks : addTask - " . var_export($insertIds, true));
                }
            }

            if (count($insertIds) == count($aryIds)) {
                return response()->json([
                    'result' => true, 'data' => $insertIds
                ]);
            } else {
                return response()->json([
                    'result' => false, 'data' => $aryIds
                ]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function executeTasks($locale, Request $request)
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
            $ids = explode(",", $request->get('id'));
            return response()->json($this->doUploadByIds($ids));
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    public function executeScheduledTasks()
    {
        $aryHostname = UploadFilesTasks::leftJoin('upload_files', 'upload_files_tasks.upload_files_id', '=', 'upload_files.id')
            ->where('upload_files_tasks.launch_datetime', '<=', date("Y-m-d H:i:s"))
            // ->where(function ($query) {
            //     $query->where('upload_files_tasks.status', '=', UploadFilesTasks::STATUS_SCHEDULED)
            //         ->orWhere('upload_files_tasks.status', '=', UploadFilesTasks::STATUS_PENDING);
            // })
            ->Where('upload_files_tasks.status', '=', UploadFilesTasks::STATUS_SCHEDULED)
            ->whereNotNull('upload_files.remote_file')
            ->pluck('upload_files_tasks.id')->toArray();
        //return response()->json($aryHostname);
        Logger()->debug(" executeScheduledTasks :  IDs ". var_export($aryHostname,true));
        return response()->json($this->doUploadByIds($aryHostname));
    }

    public function showScheduledTasks()
    {
        $aryHostname = UploadFilesTasks::leftJoin('upload_files', 'upload_files_tasks.upload_files_id', '=', 'upload_files.id')
            ->where('upload_files_tasks.launch_datetime', '<', Carbon::now()->toDateTimeString())
            // ->where(function ($query) {
            //     $query->where('upload_files_tasks.status', '=', UploadFilesTasks::STATUS_SCHEDULED)
            //         ->orWhere('upload_files_tasks.status', '=', UploadFilesTasks::STATUS_PENDING);
            // })
            ->Where('upload_files_tasks.status', '=', UploadFilesTasks::STATUS_SCHEDULED)
            ->whereNotNull('upload_files.remote_file')
            ->pluck('upload_files_tasks.id')->toArray();
        //return response()->json($aryHostname);
     //   Logger()->debug(" executeScheduledTasks :  IDs ". var_export($aryHostname,true));
        return response()->json($aryHostname);
    }



    public function delUploadFiles($locale, Request $request)
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

            $aryIds = explode(",", $request->get('id'));
            // delete upload file task >whereIn('id', array(1, 2, 3))
            $uploadFiles = UploadFiles::whereIn('id', $aryIds)
                ->each(function ($file) {
                    $history  = $file->replicate();
                    $history->setTable('upload_files_history');
                    $history->action = 'DEL';
                    $history->action_taker = $this->username;
                    $history->save();

                    $file->delete();
                    // delete upload file tasks
                    $uploadFileTasks = UploadFilesTasks::where("upload_files_id", $file->id)
                        ->each(function ($task) {
                            $taskHistory = $task->replicate();
                            $taskHistory->setTable('upload_files_tasks_history');
                            $taskHistory->action = 'DEL';
                            $taskHistory->action_taker = $this->username;
                            $taskHistory->save();

                            $task->delete();
                        });
                });

            if ($uploadFiles) {
                return response()->json(['result' => true]);
            } else {
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

    // delete tasks
    public function delTasks($locale, Request $request)
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
            $aryIds = explode(",", $request->get('id'));
            // delete upload file task >whereIn('id', array(1, 2, 3))
            $uploadFileTask = UploadFilesTasks::whereIn('id', $aryIds)
                ->each(function ($task) {
                    $taskHistory = $task->replicate();
                    $taskHistory->setTable('upload_files_tasks_history');
                    $taskHistory->action = 'DEL';
                    $taskHistory->action_taker = $this->username;
                    $taskHistory->save();

                    $task->delete();
                });

            if ($uploadFileTask) {
                return response()->json(['result' => true]);
            } else {
                return response()->json(['result' => false]);
            }
        } catch (ValidationException $ex) {
            return $ex->validator->errors();
        }
    }

// remove file remotely
        public function removeUploadedFile($locale, Request $request)
        {
            try {
                $this->validate(
                    $request,
                    [
                        'id' => 'required',
                        'hostname' => 'required',
                    ],
                    [
                        'id.required' => 'ID is required.',
                        'hostname.required' => 'Hostname is required.',
                    ]
                );
                $uploadFileService = new UploadFileService();

                $launch_datetime = $request->get('launch_datetime');
                if (is_array($request->get('id'))){
                    $aryIds = $request->get('id');
                } else {
                    $aryIds = explode(",", $request->get('id'));
                }
                $insertIds = [];
                foreach ($request->get('hostname') as $hostname) {
                    foreach ($aryIds as $id) {
                        $insertIds[] = $uploadFileService->addUploadFilesTasks($id, $hostname, $launch_datetime, UploadFilesTasks::STATUS_DELETED_PENDING, $this->username);
                        Logger()->debug(" removeUploadedFile : addTask - " . var_export($insertIds, true));
                    }
                }


                $removeFiles = [];

                // delete upload file task >whereIn('id', array(1, 2, 3))
                $uploadFiles = UploadFiles::whereIn('id', $aryIds)
                ->each(function ($file) {
                    $history  = $file->replicate();
                    $history->setTable('upload_files_history');
                    $history->action = 'REMOVED';
                    $history->action_taker = $this->username;
                    $history->save();
                    $removeFiles[$file->id]=$file->remote_file;

                    // delete upload file tasks
                    $uploadFileTasks = UploadFilesTasks::where("upload_files_id", $file->id)
                        ->each(function ($task) {
                            $taskHistory = $task->replicate();
                            $taskHistory->setTable('upload_files_tasks_history');
                            $taskHistory->action = 'REMOVED';
                            $taskHistory->action_taker = $this->username;
                            $taskHistory->save();

                            $task->delete();
                        });
                    $file->delete();
                });

                // do remove
                $cntTasks = count($aryIds) + count($request->get('hostname'));
                $cntSuccess = [];
                $cntFailed = 0;
                foreach ($request->get('hostname') as $hostname) {
                    $ftpService = new FtpService($hostname);

                    foreach ($removeFiles as $rId => $rFile){
                        $task = UploadFilesTasks::Where("upload_files_id",$rId)->where("status",UploadFilesTasks::STATUS_DELETED_PENDING)
                            ->where("hostname",$hostname)->first();

                        if ($ftpService->delFile($rFile)) {
                            
                            Logger()->debug(" removeUploadedFile : TID " . $task->id . ", remove remote_file - $rFile");
                            $uploadFileService->uploadedFile($task->id, UploadFilesTasks::STATUS_UPLOADED, $this->username);
                            $cntSuccess[] = $task->id;
                        } else {
                            $uploadFileService->updateUploadFilesTasksStatus($task->id, UploadFilesTasks::STATUS_DELETE_FAILED, $this->username);
                            $cntFailed++;
                            Logger()->error(" doUploadByIds : failed to upload file to server" . var_export($task, true));
                        }
                    }

                    $ftpService->closeConnection();
                    
                }
                if (count($cntSuccess) == $cntTasks && $cntFailed == 0) {
                    return [
                        'result' => true, 'data' => $cntSuccess
                    ];
                } else {
                    return [
                        'result' => false, 'data' => $cntFailed
                    ];
                }
            } catch (ValidationException $ex) {
                return $ex->validator->errors();
            }
        }

    public function checkFtpConn($locale, $hostname)
    {
        Logger()->debug(" checkFtpConn : checkFtpConn - hostname :$hostname");
        if ($hostname) {
            $ftpService = new FtpService($hostname);
            //json_encode($ftpService->ftpLogin());
            $file_list = ftp_nlist($ftpService->ftpConn(), ".");

            //output the array stored in $file_list using foreach loop
            foreach ($file_list as $key => $dat) {
                echo $key . "=>" . $dat . "<br>";
            }
            $ftpService->closeConnection();
        } else {
            return false;
        }
    }

    private function doUploadByIds($ids)
    {

        $uploadFileService = new UploadFileService();

        $allTasks = UploadFilesTasks::select(
            'upload_files_tasks.id',
            'upload_files_tasks.hostname',
            'upload_files_tasks.launch_datetime',
            'upload_files_tasks.status',
            'upload_files_tasks.uploaded_at',
            'upload_files.filename',
            'upload_files.local_file',
            'upload_files.remote_file',
            'upload_files.etype',
            'upload_files.lang',
            'upload_files_tasks.created_at',
            'upload_files_tasks.hostname'
        )
            ->leftJoin('upload_files', 'upload_files_tasks.upload_files_id', '=', 'upload_files.id')
            ->whereIn("upload_files_tasks.id", $ids);


        $cntTasks = $allTasks->count();
        $cntSuccess = [];
        $cntFailed = 0;
        $taskQueue = [];

        foreach ($allTasks->get()->toArray() as $tData) {
            $taskQueue[$tData['hostname']][] = $tData;
        }

        foreach ($taskQueue as $hostname => $tasks) {
            Logger()->debug(" doUploadByIds : hostname - $hostname");
            $ftpService = new FtpService($hostname);
            foreach ($tasks as $task) {
                $remote_file =  $this->hostpath . $task['remote_file'];
                $ftpService->checkAndCreateFolder($remote_file);

                if ($ftpService->uploadFile($task['local_file'], $remote_file)) {
                    Logger()->debug(" doUploadByIds hostname - $hostname : TID " . $task['id'] . ", uploaded remote_file - $remote_file");
                    $uploadFileService->uploadedFile($task['id'], UploadFilesTasks::STATUS_UPLOADED, $this->username);
                    $cntSuccess[] = $task['id'];
                } else {
                    $uploadFileService->updateUploadFilesTasksStatus($task['id'], UploadFilesTasks::STATUS_FAILED, $this->username);
                    $cntFailed++;
                    Logger()->error(" doUploadByIds hostname - $hostname : failed to upload file to server" . var_export($task, true));
                }
            }
            $ftpService->closeConnection();
        }

        if (count($cntSuccess) == $cntTasks && $cntFailed == 0) {
            return [
                'result' => true, 'data' => $cntSuccess
            ];
        } else {
            return [
                'result' => false, 'data' => $cntFailed
            ];
        }
    }

    public function doRemoveFileByIds($ids){ // tasks id
        $uploadFileService = new UploadFileService();

        $allTasks = UploadFilesTasks::select(
            'upload_files_tasks.id',
            'upload_files_tasks.hostname',
            'upload_files_tasks.launch_datetime',
            'upload_files_tasks.status',
            'upload_files_tasks.uploaded_at',
            'upload_files.filename',
            'upload_files.local_file',
            'upload_files.remote_file',
            'upload_files.etype',
            'upload_files.lang',
            'upload_files_tasks.created_at',
            'upload_files_tasks.hostname'
        )
            ->leftJoin('upload_files', 'upload_files_tasks.upload_files_id', '=', 'upload_files.id')
            ->whereIn("upload_files_tasks.id", $ids);


        $cntTasks = $allTasks->count();
        $cntSuccess = [];
        $cntFailed = 0;
        $taskQueue = [];

        foreach ($allTasks->get()->toArray() as $tData) {
            $taskQueue[$tData['hostname']][] = $tData;
        }

        foreach ($taskQueue as $hostname => $tasks) {
            Logger()->debug(" doUploadByIds : hostname - $hostname");
            $ftpService = new FtpService($hostname);
            foreach ($tasks as $task) {
                $remote_file =  $this->hostpath . $task['remote_file'];
               // $ftpService->checkAndCreateFolder($remote_file);

                if ($ftpService->delFile($remote_file)) {
                    Logger()->debug(" doUploadByIds : TID " . $task['id'] . ", uploaded remote_file - $remote_file");
                    $uploadFileService->uploadedFile($task['id'], UploadFilesTasks::STATUS_DELETED, $this->username);
                    $cntSuccess[] = $task['id'];
                } else {
                    $uploadFileService->updateUploadFilesTasksStatus($task['id'], UploadFilesTasks::STATUS_DELETE_FAILED, $this->username);
                    $cntFailed++;
                    Logger()->error(" doUploadByIds : failed to remove file to server" . var_export($task, true));
                }
            }
            $ftpService->closeConnection();
        }

        if (count($cntSuccess) == $cntTasks && $cntFailed == 0) {
            return [
                'result' => true, 'data' => $cntSuccess
            ];
        } else {
            return [
                'result' => false, 'data' => $cntFailed
            ];
        }

    }
}
