<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class ProductRelatedBoxes extends Model
{
    use HasFactory;
    use Validatable;
    use CreatedUpdatedBy;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";
    
    const CREATED_AT = 'createdate';
    const CREATED_BY = 'creator';


    protected $fillable = ['boxno','seqno','lang','menucat','partno','status'];

    public function getValidationRules(){
        return [
            'partno' => 'required',
            'menucat' => 'required',
            'boxno' => 'required',
        ];
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products', 'partno');
    }


}