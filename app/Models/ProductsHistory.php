<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class ProductsHistory extends Model
{
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    //use CreatedUpdatedBy;

    protected $table = 'products_history';

    public $timestamps = false;
    
    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    const PSTATUS_UP = 1;
    const PSTATUS_NEW = 2; //  active & newproduct
    const PSTATUS_CURRENT = 3;
    const PSTATUS_LEGACY = 5;
    const PSTATUS_EOL = 6; // not active
    const PSTATUS_PREORDER = 7;
    const PSTATUS_HIDDEN = 8; // not active

    const TYPE_MAIN = "Main";

    const CREATED_AT = 'logged_at';
    const CREATED_BY = 'logged_by';

    //    protected $fillable = ['name','seq','parent_id'];

    protected $fillable = [
        'id',
        'seqno',
        'prod_cat1',
        'prod_cat2',
        'cat_series',
        'cat_app',
        'keywords',
        'fankeywords',
        'extrakeywords',
        'partno',
        'partnoline',
        'series',
        'lang',
        'title',
        'name',
        'shortdesc',
        'shortdesc1',
        'shortdesc2',
        'longdesc',
        'introduction',
        'intro_display_type',
        'active',
        'publish_date',
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
        'creatorid',
        'groupid',
        'createdate',
        'updated_at',
        'updated_by',
        'pt',
        'es',
        'fr',
        'de',
        'cn',
        'jp',
        'archive_product',
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
        'group_id',
        'pstatus',
        'exported',
        'related_box_status',
        'logged_at',
        'logged_by',
    ];

    protected $casts = [
     //   'name' => 'array',
        'intro' => 'array',
        'desc' => 'array',
        'spec' => 'array',
    ];

    public function getValidationRules()
    {
        return [
        //    'name' => 'required',
            'intro' => 'required',
            'desc' => 'required',
            'spec' => 'required',
        ];
    }

    public function getPstatus()
    {
        $pstatusTitle[1] = "Upcoming / Active";
        $pstatusTitle[2] = "New/Active";
        $pstatusTitle[3] = "Current/Active";
        $pstatusTitle[4] = "EOL or Legacy consideration";
        $pstatusTitle[5] = "Legacy/Active";
        $pstatusTitle[6] = "EOL/Remove from website (hidden from public viewing)";
        return $pstatusTitle;
    }

    // has Many
    public function reviews()
    {
        return $this->hasMany('App\Models\ProductReviews', 'partno', 'partno')->with('images')->with('icon')->orderBy('seqno');
    }
    public function activeReviews(){
        return $this->hasMany('App\Models\ProductReviews', 'partno', 'partno')->where('status', 1)->with('images')->with('reviewsites')->orderBy('seqno');
    }
    // has Many images
    public function images()
    {
        return $this->hasMany('App\Models\Images', 'partno', 'partno')->orderBy('seqno');;
    }

    public function feature_images()
    {
        return $this->hasMany('App\Models\Images', 'partno', 'partno')->where("ctype", "feature")->orderBy('seqno');
    }

    public function gallery()
    {
        return $this->hasMany('App\Models\Images', 'partno', 'partno')->where("ctype", "gallery")->orderBy('seqno');
    }

    public function content_images()
    {
        return $this->hasMany('App\Models\Images', 'partno', 'partno')->where("ctype", "content");
    }

    public function spec_images()
    {
        return $this->hasMany('App\Models\Images', 'partno', 'partno')->where("ctype", "specification");
    }

    public function pdetailmap()
    {
        return $this->hasMany('App\Models\Images', 'partno', 'partno')->where("ctype", "pdetailmap");
    }

    public function plistmap()
    {
        return $this->hasMany('App\Models\Images', 'partno', 'partno')->where("ctype", "plistmap");
    }

    public function spec(){
        return $this->hasMany('App\Models\ProdSpec', 'partno', 'partno');
    }

    public function download(){
        return $this->hasMany('App\Models\Downloads', 'partno', 'partno')->orderBy('seqno');
    }

    public function details(){
        return $this->with('download')->with('reviews')->with('spec')->with('feature_images')->with('gallery')->with('content_images')->with('spec_images');
    }

    public function faqs(){
        return $this->hasMany('App\Models\Faqs', 'partno', 'partno');
    }
    public function activeRelatedBoxes(){
        return $this->hasMany('App\Models\ProductRelatedBoxes', 'partno', 'partno')->where("status", 1);
    }
    public function productInBox(){
        return $this->hasMany('App\Models\ProdlistBoxes', 'productcode', 'partno');
    }

    public function productEcommerceUrls(){
        return $this->hasMany('App\Models\ProductEcommerceUrls', 'productcode', 'partno')->orderBy('seqno');
    }

    // // Many to Many
    // public function tags()
    // {
    //     return $this->belongsToMany('App\Models\Tags');
    // }

    // public function Categories()
    // {
    //     return $this->belongsToMany('App\Models\Category');
    // }

    // public function keywords()
    // {
    //     return $this->belongsToMany('App\Models\Keywords');
    // }
}
