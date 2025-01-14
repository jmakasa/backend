<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;
use App\Traits\LogsChangeAndHistoryTrait;

class Blogs extends Model
{
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;
    use LogsChangeAndHistoryTrait;

    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    const PSTATUS_EOL = 6;

    const TYPE_MAIN = "Main";


    protected $fillable = [
        'title',
        'subtitle',
        'contents',
        'btype',
        'releasedate',
        'topimage',
        'caption',
        'seqno',
        'lang',
        'featured_blog',
        'status',
        'related_products',
        'slug',
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
            'title' => 'required',
            'contents' => 'required',
            'lang' => 'required',
            'btype' => 'required',
        ];
    }

    
}
