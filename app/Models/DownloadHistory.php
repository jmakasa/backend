<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;

class DownloadHistory extends Model
{
    use HasFactory;
    use Validatable;
    protected $table = 'download_history';
    const CREATED_AT = 'createdate';
    const UPDATED_AT = 'moddate';

    protected $fillable = [
        'partno',
        'lang',
        'seqno',
        'subject',
        'docname',
        'docdir',
        'ftype',
        'filetype',
        'filesize',
        'comment',
        'creator',
        'createdate',
        'releasedate',
        'modauthor',
        'moddate',
        'pid',
        'bck_date',
        'action'
    ];
    
    public function getValidationRules(){
        return [
            'partno' => 'required',
            'docname' => 'required',
            'docdir' => 'required',
            'subject' => 'required',
        ];
    }
}
