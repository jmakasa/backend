<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class Tasks extends Model
{
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;

    const STATUS_OPEN = "Open";
    const STATUS_PRIOR = "Prioritized";
    const STATUS_IN_PROGRESS = "In Progress";
    const STATUS_REVIEW = "Review";
    const STATUS_CLOSED = "Closed";
    const STATUS_REOPEN = "Re-Open";



    const TASK_TYPE = "Main";


    protected $fillable = [
        'parent_task_id',
        'email_id',
        'subject',
        'content',
        'attachment',
        'task_desc',
        'remarks',
        'start_datetime',
        'due_datetime',
        'from_email',
        'account_contact_id',
        'assignor',
        'assignee',
        'status',
        'type',
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
            'subject' => 'required',
            'contents' => 'required',
            'assignee' => 'required',
        ];
    }

    public function webEmailContactus()
    {
        return $this->belongsTo('App\Models\WebEmailContactus', 'email_id');
    }
    
}


