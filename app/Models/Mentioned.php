<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class Mentioned extends Model
{
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;

    protected $table = 'mentioned';

    // use the table name to be the type
    const TYPE_TICKET_NOTE = "ticket_notes";


    protected $fillable = [
        'employees_id',
        'type',
        'type_id',
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
            'employees_id' => 'required',
            'type' => 'required',
            'type_id' => 'required',
        ];
    }

    public function employee()
    {
        return $this->hasOne('App\Models\Employess', 'employees_id');
    }

}


