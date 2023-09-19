<?php

namespace App\Traits;

trait CreatedUpdatedBy
{
    public static function bootCreatedUpdatedBy()
    {

        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            $name = "SYSTEM";
            if (auth()->user()) {
                $name = auth()->user()->name;
            }
            if (isset($_SESSION['username']) && $_SESSION['username']){
                $name =$_SESSION['username'];
            };
            if (!$model->isDirty('created_by')) {
                $model->created_by = $name;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = $name;
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            $name = "SYSTEM";
            if (isset($_SESSION['username']) && $_SESSION['username']){
                $name =$_SESSION['username'];
            };
            if (auth()->user()) {
                $name = auth()->user()->name;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = $name;
            }
        });
    }
}
