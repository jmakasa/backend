<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class TopSalesQty extends Model
{
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    protected $table = 'top_sales_qty';


    protected $fillable = [
        'company_name', 'account_ref', 'productcode', 'year', 'jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sept', 'oct', 'nov', 'dec', 'tot', 'status', 'created_by', 'updated_by'
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
