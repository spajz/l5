<?php namespace App\Models;

use App\BaseModel;

class ModelContent extends BaseModel {

    protected $fillable = array(
        'title',
        'model_type',
        'type',
        'lang',
        'order',
        'status'
    );

    public function values()
    {
        return $this->hasMany('App\Models\ModelContentValue', 'model_content_id');
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
