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

    protected $connection = 'mysql_web';

    protected $table = 'email_contactus';
}
