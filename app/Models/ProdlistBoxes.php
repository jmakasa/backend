<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class ProdlistBoxes extends Model
{
    use HasFactory;
    use Validatable;
    use CreatedUpdatedBy;

    protected $table = 'prodlist_boxes';

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";
    const ISSELECT_ACTIVE = '1';
    const ISSELECT_INACTIVE = '0';
    
    const CREATED_AT = 'createdate';
    const CREATED_BY = 'creator';


    protected $fillable = ['boxno','product_id','productcode','box_seqno','seqno','box_name','lang', 'menucat','is_selected','status'];

    // protected $casts = [
    //     'name' => 'array',
    //     'intro' => 'array',
    //     'desc' => 'array',
    //     'spec' => 'array',
    // ];

    public function getValidationRules(){
        return [
            'productcode' => 'required',
            'product_id' => 'required',
            'menucat' => 'required',
            'boxno' => 'required',
        ];
    }

    // has Many
    public function productId()
    {
        return $this->hasMany('App\Models\Products', 'product_id', 'id');
    }

    public function productcode()
    {
        return $this->hasMany('App\Models\Products', 'productcode', 'partno');
    }

    public function menus()
    {
        return $this->hasOne('App\Models\Navmenu2022', 'id', 'menucat');
    }

}