<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class Mbcheck extends Model
{

  //  protected $connection = 'mysql';
    protected $table = 'mbcheck';
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    protected $fillable = [
        'platform',
        'processor',
        'manufacturer',
        'productline',
        'productname',
        'partnoline',
        'familyname',
        'modelname',
        'status', 'created_by', 'created_at', 'updated_by', 'updated_at'
    ];


    public function getValidationRules()
    {
        return [
            'platform' => 'required',
            'processor' => 'required',
        ];
    }

}
