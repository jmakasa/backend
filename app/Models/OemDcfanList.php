<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class OemDcfanList extends Model
{

    protected $connection = 'mysql';
    protected $table = 'oem_dcfan_list';
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    protected $fillable = [
        'type',
        'series',
        'model',
        'size',
        'series',
        'depth',
        'bearing',
        'voltage',
        'current',
        'power_consumption',
        'rated_speed',
        'airflow',
        'air_pressure',
        'noise_level',
        'weight',
        'status', 'created_by', 'created_at','updated_by', 'updated_at'
    ];


    public function getValidationRules()
    {
        return [
            'type' => 'required',
            'model' => 'required',
        ];
    }

}
