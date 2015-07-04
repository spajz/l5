<?php namespace App\Models;

use App\BaseModel;
use App\Library\ImageApi;

class Image extends BaseModel
{

    protected $table = 'images';

    protected $fillable = array(
        'alt',
        'description',
        'image',
        'model_id',
        'model_type',
        'order',
        'status',
    );

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $imageApi = new ImageApi();
            $imageApi->forceDelete($model->image);
        });
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function sameParent()
    {
        $query = $this->newQuery();

        return $query->where('model_id', $this->model_id)
            ->where('model_type', $this->model_type)
            ->get();
    }

}