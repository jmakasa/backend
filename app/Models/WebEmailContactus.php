<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class WebEmailContactus extends Model
{
    use HasFactory;
    use Validatable;
    use CreatedUpdatedBy;

    const TASK_AWAIT = 0;
    const TICKETS_AWAIT = 0;


    protected $connection = 'mysql_web';

    protected $table = 'email_contactus';

    protected $fillable = [
        'tasks_id',
    ];

    public function hasTask(){
        return $this->hasOne('App\Models\Tasks', 'email_id', 'id');
    }

    public function ticketDetail()
    {
        return $this->belongsTo('App\Models\Tickets', 'tickets_id');
    }

}
