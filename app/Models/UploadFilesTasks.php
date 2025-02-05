<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;

class UploadFilesTasks extends Model
{
    use HasFactory;
    use Validatable;

    const STATUS_PENDING = "0";
    const STATUS_SCHEDULED = "1";
    const STATUS_UPLOADED = "2";
    const STATUS_FAILED = "3";
    const STATUS_DELETED_PENDING = "90";
    const STATUS_DELETED_SCHEDULED  = "91";
    const STATUS_DELETED  = "92";
    const STATUS_DELETE_FAILED = "93";

    protected $casts = [
        'created_at' => 'datetime:m-d-Y H:i:s',
        'updated_at' => 'datetime:m-d-Y H:i:s',
    ];

    protected $fillable = [
        'upload_files_id','hostname','launch_datetime','status','uploaded_at','created_by','created_at','updated_by','updated_at'
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
        public function uploadFiles()
        {
            return $this->belongsTo('App\Models\UploadFiles', 'upload_files_id');
        }

}
