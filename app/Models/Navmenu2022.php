<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class Navmenu2022 extends Model
{
    use HasFactory;    
    use CreatedUpdatedBy;
    use Validatable;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $table = '2022_navmenu';

    protected $fillable = ['id','parent_id','parent','submenu','has_child','smenu','seqno','title',
    'display_name','json','desc','docname','is_display_image','css_style','tpl','status'];

    protected $casts = [
        'json' => 'array',
   ];

    public function children()
    {
        return $this->hasMany('App\Models\Navmenu2022', 'parent_id', 'id')->with('children')->orderBy('seqno');
    }

    public function recurringchildren()
    {
        return $this->hasMany('App\Models\Navmenu2022', 'parent_id', 'id')->with('children')->orderBy('seqno');
    }
    public function recurringActiveChildren()
    {
        return $this->hasMany('App\Models\Navmenu2022', 'parent_id', 'id')->whereStatus(self::STATUS_ACTIVE)->with('children',function($query) {
            return $query->whereStatus(self::STATUS_ACTIVE);
        })->orderBy('seqno');
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\Navmenu2022', 'parent_id')->with('parent');
    }
}
