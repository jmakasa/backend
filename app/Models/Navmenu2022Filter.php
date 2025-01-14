<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class Navmenu2022Filter extends Model
{
    use HasFactory;    
  //  use CreatedUpdatedBy;
    use Validatable;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $table = '2022_navmenu_filter';

    protected $fillable = ['id','ktype','menucat'];

}
