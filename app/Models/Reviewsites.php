<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;
// use App\Traits\CreatorMod;

class Reviewsites extends Model
{
    use HasFactory;
   // use UuidForKey;
    use CreatedUpdatedBy;
    use Validatable;
//  protected $table = 'category';
    protected $table = 'reviewsites';
    
    // const CREATED_AT = 'createdate';
    // const UPDATED_AT = 'moddate';
    // const CREATED_BY = 'creator';
    // const UPDATED_BY = 'modauthor';

    const FILEPATH = '/img/product/common/review/icon/';
    

    protected $fillable = ['sitename', 'sitelogo', 'siteurl', 'docdir', 'country', 'lang', 'filetype', 'filesize', 'created_by', 'created_at', 'updated_by', 'updated_at', 'comment','status'];

    // protected $casts = [
    //     'title' => 'array',
    //     'desc' => 'array',
    //     'content' => 'array',icon/
    // ];

    public function getValidationRules(){
        return [
            'sitename' => 'required',
          //  'siteurl'=> 'required',
            'sitelogo'=> 'required', 
            // 'type' => 'required|in:'.implode(',',[
            //         self::TYPE_PRESS_RELEASE,
            //         self::TYPE_PRODUCT_REVIEWS,
            //         self::TYPE_TECH_TRENDS,
            //         self::TYPE_BUYING_GUIDE,
            //         self::TYPE_TIPS_TUTORIALS,
            // ]),
        ];
    }

    public function productReviews()
    {
        return $this->hasMany('App\Models\ProductReviews', 'reviewsites_id', 'id')->orderBy('seqno');
    }


}
