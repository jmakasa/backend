<?php

namespace App\Traits;
use Carbon\Carbon;

trait LoggedAtOnly
{
    public static function bootCreatedAtOnly()
    {
        static::creating(function ($model) {
            $model->logged_at = Carbon::now();
        });
    }
}
