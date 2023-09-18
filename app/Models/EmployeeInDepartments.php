<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class EmployeeInDepartments extends Model
{
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    const ACCESS_RIGHT_DEFAULT = "00,10";

    protected $fillable = [
        'parent_id',
        'name',
        'department_email',
        'head_id',
        'status',

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
            'name' => 'required',
        ];
    }

    public function children()
    {
        return $this->hasMany('App\Models\EmployeeDepartments', 'parent_id', 'id')->with('children');
    }

    public function recurringchildren()
    {
        return $this->hasMany('App\Models\EmployeeDepartments', 'parent_id', 'id')->with('children');
    }
    public function recurringActiveChildren()
    {
        return $this->hasMany('App\Models\EmployeeDepartments', 'parent_id', 'id')->whereStatus(self::STATUS_ACTIVE)->with('children',function($query) {
            return $query->whereStatus(self::STATUS_ACTIVE);
        });
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\Navmenu2022', 'parent_id')->with('parent');
    }
    
}


