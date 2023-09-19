<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class ProdKeywords extends Model
{
    use HasFactory;
    use Validatable;
    // use CreatedUpdatedBy;
    public $timestamps= false;

    protected $table = 'prod_keywords';

    protected $fillable = ['partno','skey',];

    public function getValidationRules(){
        return [
            'partno' => 'required',
            'skey' => 'required',
        ];
    }

    // has Many
    public function partno()
    {
        return $this->hasMany('App\Models\Products', 'partno', 'partno');
    }

    public function keywords()
    {
        return $this->hasMany('App\Models\Keywords', 'skey', 'skey');
    }

}