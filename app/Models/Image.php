<?php namespace App\Models;

use App\BaseModel;

class Image extends BaseModel{

    protected $table = 'images';

    protected $fillable = array(
        'alt',
        'description',
        'image',
        'model_id',
        'model_type',
        'order',
        'status'
    );

    public static function boot()
    {
        parent::boot();

//        static::deleted(function ($model) {
//            $imageApi = new ImageApi();
//            $class = strtolower(class_basename($model->model_type));
//            $module = explode('\\', $model->model_type);
//            $module = strtolower($module[0]);
//            if (Config::get($class . '::' . 'image')) {
//                $imageApi->setConfig($class . '::' . 'image');
//            } elseif (Config::get($class . '::' . $module . '.image')) {
//                $imageApi->setConfig($class . '::' . $module . '.image');
//            } else {
//                $imageApi->setConfig($module . '::' . 'image');
//            }
//            $imageApi->delete($model->image);
//        });
    }

    public function model()
    {
        return $this->morphTo();
    }

}