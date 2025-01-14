<?php

namespace App\Traits;
use Carbon\Carbon;

trait CreatedAtOnly
{
    public static function bootCreatedAtOnly()
    {
        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            $model->created_at = Carbon::now();
        });
    }
}
