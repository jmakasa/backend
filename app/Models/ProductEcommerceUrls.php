<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;
//use App\Traits\CreatorMod;
use App\Traits\CreatedUpdatedBy;

class ProductEcommerceUrls extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    use Validatable;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $fillable = ['crmid', 'acct_ref', 'acct_name','country_code','continent', 'productcode', 'source_type', 'imglogo', 'link_name', 'sales_url', 'seqno','status', 'exported', 'created_by', 'created_at', 'updated_by', 'updated_at'];

    public function getValidationRules()
    {
        return [
            'crmid' => 'required',
            'acct_name' => 'required',
            'productcode' => 'required',
            'sales_url' => 'required',
        ];
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products', 'partno', 'productcode');
    }
    public function icon()
    {
        return $this->hasOne('App\Models\Images', 'id', 'icon_id');
    }
}
