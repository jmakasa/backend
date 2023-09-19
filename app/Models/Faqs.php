<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Validatable;

class Faqs extends Model
{
    use HasFactory;
    use Validatable;
    protected $table = 'faq';
    protected $fillable = ['partno','question','answer','lang','questioncat','faqcatid'];

    public function getValidationRules(){
        return [
            'partno' => 'required',
            'question' => 'required',
            'answer' => 'required',
            'lang' => 'required',
        ];
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Products', 'partno');
    }
}
