<?php namespace App\Models;

use App\BaseModel;

class Content extends BaseModel
{

    protected $attributes = array(
        'status' => 1,
    );

    protected $fillable = array(
        'title',
        'content',
        'model_type',
        'type',
        'sub_type',
        'lang',
        'order',
        'status',
        'encoded',
    );

    public function values()
    {
        return $this->hasMany('App\Models\ContentValue', 'content_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            foreach ($model->values as $value) {
                $value->delete();
            }

            foreach ($model->images as $image) {
                $image->delete();
            }
        });
    }

    public function getContentAttribute($value)
    {
        if ($this->attributes['encoded'] == 1) {
            return json_decode($value, true);
        }
        return $value;
    }

    public function images()
    {
        return $this->morphMany('App\Models\Image', 'model')
            ->orderBy('order')
            ->orderBy('id', 'desc');
    }

    public function model()
    {
        return $this->morphTo();
    }
}