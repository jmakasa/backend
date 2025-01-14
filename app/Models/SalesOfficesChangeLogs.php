<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedAtOnly;

class SalesOfficesChangeLogs extends Model
{
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedAtOnly;
    const UPDATED_AT = null;


    protected $fillable = [
        'id',
        'fieldname',
        'orgvalue',
        'newvalue',
        'created_by', 
        'created_at'
    ];

    protected $casts = [];

    public function getValidationRules()
    {
        return [
            'company_name' => 'required',
        ];
    }

    
}
