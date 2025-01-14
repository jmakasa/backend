<?php

namespace App\Models\CRM_818;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class ProdSpecGroups818 extends Model
{
    use HasFactory;
    //    use UuidForKey;
    use CreatedUpdatedBy;
    use Validatable;
    protected $connection = 'mysql_818';
    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    // protected $table = 'prod_spec';

    protected $fillable = ['group_name_en', 'group_name_cn', 'group_name_json', 'status'];

    public function getValidationRules()
    {
        return [
            'group_name_en' => 'required',
            'group_name_cn' => 'required',
        ];
    }
    protected $casts = [
        'group_name_json' => 'array',
    ];

    public function specs()
    {
        return $this->hasMany('App\Models\ProdSpec', 'group_id', 'id');
    }
}
