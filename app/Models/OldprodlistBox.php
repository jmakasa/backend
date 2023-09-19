<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class OldprodlistBox extends Model
{
    use HasFactory;
    use Validatable;
    use CreatedUpdatedBy;

    protected $table = 'oldprodlist_box';

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";
    
    const CREATED_AT = 'createdate';
    const CREATED_BY = 'creator';


    protected $fillable = ['boxno','product_id','productcode','box_seqno','seqno','box_name','lang','menucat','status'];

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
    public function products()
    {
        return $this->hasMany('App\Models\Products', 'product_id', 'id');
    }

}