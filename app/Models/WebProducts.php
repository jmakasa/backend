<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class WebProducts extends Model
{
    use HasFactory;
    use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    const TYPE_MAIN = "Main";

    protected $fillable = ['parent_id',
    'partno',
    'title',
    'name',
    'product_code',
    'web_settings',
    'web_available',
    'introduction',
    'long_desc',
    'shortdesc',
    'shortdesc1',
    'shortdesc2',
    'longdesc',
    'spec',
    'seq',
    'type',
    'status',
    'pstatus',
    'created_by',
    'updated_by',
    'deleted_at',
    'created_at',
    'updated_at',
    'seqno',
    'prod_cat1',
    'prod_cat2',
    'cat_series',
    'cat_app',
    'keywords',
    'fankeywords',
    'extrakeywords',
    'active',
    'html_1',
    'html_2',
    'plistflag',
    'pdetailflag',
    'displaypartnoline',
    'iscooler',
    'newproduct',
    'upcoming',
    'specialtemplate',
    'detailtoppanel',
    'detailtoppanelbgl',
    'detailtoppanelbgr',
    'related',
    'eol',
    'eol_date',
    'eol_comment',
    'creator',
    'modauthor',
    'moddate',
    'meta_keyword',
    'meta_description',
    'boilerplate',
    'keyword_1',
    'keyword_2',
    'keyword_3',
    'keyword_4',
    'keyword_5',
    'product_tag_1',
    'product_tag_2',
    'product_tag_3',
    'product_tag_4',
    'product_tag_5',
    'meta_title',
    'productcode',
    'group_id'];

    protected $casts = [
        'name' => 'array',
        'introduction' => 'array',
        'long_desc' => 'array',
        'shortdesc' => 'array',
        'shortdesc1' => 'array',
        'shortdesc2' => 'array',
        'longdesc' => 'array',
        'spec' => 'array',
    ];

    public function getValidationRules(){
        return [
            'name' => 'required',
            'title' => 'required',
        ];
    }

    // has Many
    public function reviews()
    {
        return $this->hasMany('App\Models\ProductReviews', 'products_id', 'id');
    }


    // Many to Many
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tags');
    }

    public function Categories(){
        return $this->belongsToMany('App\Models\Category');
    }

    public function keywords(){
        return $this->belongsToMany('App\Models\Keywords');
    }

}
