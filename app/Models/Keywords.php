<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\UuidForKey;
use App\Traits\Validatable;
use App\Traits\CreatedUpdatedBy;

class Keywords extends Model
{
    use HasFactory;
    // use UuidForKey;
    use Validatable;
    use CreatedUpdatedBy;
    protected $table = 'keyword_list';
    const STATUS_ACTIVE = "Active";
    const STATUS_INACTIVE = "Inactive";

    const TYPE_NUC = 2;
    const TYPE_GEN = 3;
    const TYPE_AMD = 4;
    const TYPE_INTEL = 5;
    const TYPE_FAN_SIZE = 6;
    const TYPE_TDP = 7;
    const TYPE_CABLE = 8;
    const TYPE_INPUT1 = 11;
    const TYPE_INPUT2 = 12;


    protected $fillable = ['skey','display_name','type','seqno','status'];


    public function getValidationRules(){
        return [
            'skey' => 'required',
            'display_name' => 'required',
        ];
    }

    public function scopeTypeNuc($query){
        return $query->where('type',Keywords::TYPE_NUC)->orderBy('seqno','asc');
    }
    public function scopeTypeGen($query){
        return $query->where('type',Keywords::TYPE_GEN)->orderBy('seqno','asc');
    }
    
    public function scopeTypeAmd($query){
        return $query->where('type',Keywords::TYPE_AMD)->orderBy('seqno','asc');
    }
    public function scopeTypeIntel($query){
        return $query->where('type',Keywords::TYPE_INTEL)->orderBy('seqno','asc');
    }
    public function scopeTypeFanSize($query){
        return $query->where('type',Keywords::TYPE_FAN_SIZE)->orderBy('seqno','asc');
    }
    public function scopeTypeTdp($query){
        return $query->where('type',Keywords::TYPE_TDP)->orderBy('seqno','asc');
    }
    public function scopeTypeCable($query){
        return $query->where('type',Keywords::TYPE_CABLE)->orderBy('seqno','asc');
    }
}
