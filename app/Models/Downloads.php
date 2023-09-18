<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;

class Downloads extends Model
{
    use HasFactory;
    use Validatable;
    protected $table = 'download';


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
    public function product()
    {
        return $this->belongsTo('App\Models\Products', 'partno');
    }
}
