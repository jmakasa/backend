<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class MbcheckProdlist extends Model
{

   // protected $connection = 'mysql';
    protected $table = 'mbcheck_prodlist';
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    protected $fillable = [
        'productcode',
        'mbcheck_id',
        'status', 'created_by', 'created_at', 'updated_by', 'updated_at'
    ];


    public function getValidationRules()
    {
        return [
            'productcode' => 'required',
            'mbcheck_id' => 'required',
        ];
    }

}
