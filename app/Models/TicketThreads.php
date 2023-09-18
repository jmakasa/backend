<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class TicketThreads extends Model
{
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;

    const STATUS_PENDING = "Pending";
    const STATUS_SENT = "Sent";
    const STATUS_RESEND = "Resend";

    const TICKET_ATTACHMENTS_PATH = "";


    const TICKET_TYPE = "Main";


    protected $fillable = [
        'tickets_id',
        'subject',
        'content',
        'content_language',
        'content_type',
        'attachment',
        'attachment_cnt',
        'to_email',
        'to_cc',
        'to_bcc',
        'from_email',
        'account_contact_id',
        'sent_datetime',
        'message_id',
        'status',
    ];

    protected $casts = [
        'to_email' => 'array',
        'to_cc' => 'array',
        'to_bcc' => 'array',
    ];

    public function getValidationRules()
    {
        return [
            'subject' => 'required',
            'content' => 'required',
            'to_email' => 'required',
        ];
    }

    
}
