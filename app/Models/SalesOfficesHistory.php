<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class SalesOfficesHistory extends Model
{
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    const PSTATUS_EOL = 6;

    const STYPE_RET = "ret";
    const STYPE_DIST = "dist";


    protected $fillable = [
        'id','company_name', 'account_ref', 'logo', 'country_code', 'country', 'address', 'tel', 'fax', 'email', 'website', 'online_shop', 'stype', 'status', 'created_by', 'updated_by', 
    ];

    protected $casts = [
        // 'name' => 'array',
        // 'intro' => 'array',
        // 'desc' => 'array',
        // 'spec' => 'array',
    ];

    public function getValidationRules()
    {
        return [
            'company_name' => 'required',
        ];
    }

    
}
