<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedAtOnly;

class ProductChangeLogs extends Model
{
    use HasFactory;
  //  use UuidForKey;
    use Validatable;
    use CreatedAtOnly;
    const UPDATED_AT = null;

    protected $table = 'product_change_logs';

    protected $fillable = [
      'id',
        'partno',
        'tablename',
        'fieldname',
        'orgvalue',
        'newvalue',
        'created_by', 
        'created_at',
    ];


}
