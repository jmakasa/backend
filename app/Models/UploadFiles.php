<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;

class UploadFiles extends Model
{
    use HasFactory;
    use Validatable;

    const ETYPE_PROD = 'product';

    protected $fillable = [
        'hostname','local_file','remote_file','filename','etype','lang','method','status','partno','created_by','created_at','updated_by','updated_at'];

        public function getValidationRules()
        {
            return [
                'local_file' => 'required',
                'remote_file' => 'required',
                'etype' => 'required',
            ];
        }
        
        public function tasks(){
            return $this->hasMany('App\Models\UploadFilesTasks', 'upload_files_id', 'id');
        }

}
