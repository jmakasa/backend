<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatorMod;
use App\Traits\Validatable;

class Images extends Model
{
    use HasFactory;
    use CreatorMod;
    use Validatable;

    const CREATED_AT = 'createdate';
    const UPDATED_AT = 'moddate';
    const CREATED_BY = 'creator';
    const UPDATED_BY = 'modauthor';

    protected $fillable = [
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
        'modauthor'
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
