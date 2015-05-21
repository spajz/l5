<?php namespace App\Models;

use App\BaseModel;

class ModelContent extends BaseModel {

    public function values()
    {
        return $this->hasMany('App\Models\ModelContentValue', 'content_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            foreach ($model->values as $value) {
                $value->delete();
            }
        });
    }
}
