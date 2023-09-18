<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class Tags extends Model
{
    use HasFactory;
    use UuidForKey;
    use CreatedUpdatedBy;
    use Validatable;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    protected $fillable = ['name','parent_id'];

    protected $casts = [
        'name' => 'array',
    ];

    public function getValidationRules(){
        return [
            'name' => 'required',
        ];
    }
    public function children()
    {
        return $this->hasMany('App\Models\Tags', 'parent_id', 'id')->with('children');
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\Tags', 'parent_id')->with('parent');
    }
}
