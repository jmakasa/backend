<?php

namespace App\Traits;

trait CreatorMod
{
    public static function bootCreatorMod()
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
            if (!$model->isDirty('creator')) {
                $model->creator = $name;
            }
            if (!$model->isDirty('modauthor')) {
                $model->modauthor = $name;
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
            if (!$model->isDirty('modauthor')) {
                $model->modauthor = $name;
            }
        });
    }
}
