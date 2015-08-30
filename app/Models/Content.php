<?php namespace App\Models;

use App\BaseModel;
use Dimsav\Translatable\Translatable;

class Content extends BaseModel
{
    use Translatable;

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
        'class',
    );

    public $translatedAttributes = [
        'title',
        'content',
    ];

    public function values()
    {
        return $this->hasMany('App\Models\ContentValue', 'content_id')
            ->orderBy('content_id')
            ->orderBy('order')
            ->orderBy('value_type')
            ->orderBy('value_sub_type');
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