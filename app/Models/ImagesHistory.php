<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatorMod;
use App\Traits\Validatable;

class ImagesHistory extends Model
{
    use HasFactory;
    use CreatorMod;
    use Validatable;

    protected $table = 'images_history';

    const CREATED_AT = 'createdate';
    const UPDATED_AT = 'moddate';
    const CREATED_BY = 'creator';
    const UPDATED_BY = 'modauthor';

    protected $fillable = [
        'id',
        'seqno',
        'lang',
        'partno',
        'docname',
        'docdir',
        'caption',
        'caption_pt',
        'caption_fr',
        'caption_de',
        'caption_es',
        'caption_pl',
        'caption_it',
        'caption_cn',
        'comment',
        'filetype',
        'filesize',
        'ctype',
        'status',
        'iconid',
        'creator',
        'modauthor','bck_date','action'
    ];

    public function getValidationRules(){
        return [
            'partno' => 'required',
            'docname'=> 'required',
        ];
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products', 'partno');
    }
}
