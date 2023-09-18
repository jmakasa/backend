<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class ModifyHistorys extends Model
{
    use HasFactory;
    // use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;


    const MTYPE_CONTENT = "Main";

    protected $fillable = ['productcode','lang','from_val','to_val','mtype'];


    public function getValidationRules(){
        return [
            'productcode' => 'required',
            'lang' => 'required',
            'to_val' => 'required',
        ];
    }

}
