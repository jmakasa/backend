<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class KeywordTypes extends Model
{
    use HasFactory;
    use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    protected $fillable = ['parent_id','kt_key','keyword_types','keyword_name','json','status'];

    protected $casts = [
        'name' => 'array',
        'display_name' => 'array',
    ];

    public function getValidationRules(){
        return [
            'name' => 'required',
            'display_name' => 'required',
        ];
    }
    public function children()
    {
        return $this->hasMany('App\Models\KeywordTypes', 'parent_id', 'id')->with('children');
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\KeywordTypes', 'parent_id')->with('parent');
    }


}
