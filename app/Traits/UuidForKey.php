<?php
namespace App\Traits;
use Ramsey\Uuid\Uuid;

trait UuidForKey
{
   /**
     * Boot function from Laravel.
     */
    protected static function bootUuidForKey()
    {
        static::creating(function ($model) {
            $model->incrementing = false;
            if (!(@$model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Uuid::uuid4();
            }
        });
    }
    /**
     * Get the casts array 
     * 
     * @return array
     */
    public function getCasts(){
        return $this->casts;
    }
}