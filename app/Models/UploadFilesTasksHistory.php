<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;

class UploadFilesTasksHistory extends Model
{
    use HasFactory;
    use Validatable;
    //upload_files_tasks_history
    protected $table = 'upload_files_tasks_history';

    protected $fillable = [
        'upload_files_tasks_id','hostname','launch_datetime','status','uploaded_at','created_by','created_at','updated_by','updated_at','action','action_taker'
    ];

        public function getValidationRules()
        {
            return [
                'upload_files_id' => 'required',
                'hostname' => 'required',
                'launch_datetime' => 'required',
                'status' => 'required',
            ];
        }
        // public function uploadFiles()
        // {
        //     return $this->belongsTo('App\Models\UploadFiles', 'upload_files_id');
        // }

}
