<?php

namespace App\Models\CRM_818;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class ProdSpec818 extends Model
{
    use HasFactory;
//    use UuidForKey;
    use CreatedUpdatedBy;
    use Validatable;
    protected $connection = 'mysql_818';
    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";
    const TYPE_PRESS_RELEASE = "Press Release";
    const TYPE_PRODUCT_REVIEWS = "Product reviews";
    const TYPE_TECH_TRENDS = "Tech Trends";
    const TYPE_BUYING_GUIDE = "Buying guides";
    const TYPE_TIPS_TUTORIALS = "Tips & Tutorials";

    protected $table = 'prod_spec';

    protected $fillable = ['lang','seqno','partno','group_id','specgroup','specname','specdesc','is_highlight','created_by','created_at','updated_at','updated_by'];

    // protected $casts = [
    //     'title' => 'array',
    //     'desc' => 'array',
    //     'content' => 'array',
    // ];

    public function getValidationRules(){
        return [
            'partno' => 'required',
            'specgroup'=> 'required',
            'specname'=> 'required',
            'specdesc'=> 'required',
        ];
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products', 'partno');
    }

    public function children()
    {
      //  $this->query('App\Models\ProdSpec', 'specgroup');

        return $this->hasMany('App\Models\ProdSpec', 'parent_id','id')->orderBy("seqno");
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\ProdSpec', 'parent_id');
    }

    public function specGroup(){
        return $this->belongsTo('App\Models\ProdSpecGroups', 'group_id');
    }
    

}