<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;
//use App\Traits\CreatorMod;
use App\Traits\CreatedUpdatedBy;

class ProductReviews extends Model
{
    use HasFactory;
   // use CreatorMod;
   use CreatedUpdatedBy;
    use Validatable;
    protected $table = 'product_reviews_history';
    // const CREATED_AT = 'createdate';
    // const UPDATED_AT = 'moddate';
    // const CREATED_BY = 'creator';
    // const UPDATED_BY = 'modauthor';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $fillable = ['id','partno','images_id','reviewsites_id','title','short_desc','type','web_link','seqno','is_highlight','remarks','created_by', 'created_at', 'updated_by', 'updated_at','bck_date','action'];

    public function getValidationRules(){
        return [
            'partno' => 'required',
            'title'=> 'required',
            'type'=> 'required',
            'short_desc'=> 'required',
        ];
    }
    
    public function reviewsites()
    {
        return $this->belongsTo('App\Models\Reviewsites', 'reviewsites_id');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Products', 'products_id');
    }

    public function images(){
        return $this->hasOne('App\Models\Images', 'id', 'images_id');

    }

}
