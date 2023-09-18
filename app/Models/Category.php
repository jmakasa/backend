<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class Category extends Model
{
    use HasFactory;
    use UuidForKey;
    use CreatedUpdatedBy;
    use Validatable;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";
    

    protected $table = 'web_category';

    protected $fillable = ['name','seq','parent_id','img','desc','spec_css'];

    protected $casts = [
        'name' => 'array',
        'desc' => 'array',
    ];

    public function getValidationRules(){
        return [
            'name' => 'required',
            'seq'=> 'required',
            /*'status' => 'required|in:'.implode(',',[
                    self::STATUS_ACTIVE,
                    self::STATUS_INACTIVE,
            ]),*/
        ];
    }
    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->orderBy('seq');
    }

    public function recurringchildren()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id')->with('children');
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id')->with('parent');
    }


}
