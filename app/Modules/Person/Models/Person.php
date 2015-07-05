<?php namespace App\Modules\Person\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
//use App\Traits\TransTrait;
use Dimsav\Translatable\Translatable;
use Input;

class Person extends BaseModel
{
    use ValidationTrait;
//    use TransTrait;
    use Translatable;

    protected $table = 'persons';

    protected $appends = array('full_name');

    protected $fillable = array(
        'first_name',
        'last_name',
        'job_title',
        'description',
        'color',
        'order',
        'status'
    );

    public $translatedAttributes = [
        'description',
    ];

    public function rulesAll()
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'job_title' => 'required|max:255',
            'color' => 'required|max:255',
        ];
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    protected function images()
    {
        return $this->morphMany('App\Models\Image', 'model')
            ->orderBy('order')
            ->orderBy('id', 'desc');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Set order
            if (!$model->exists && is_null(Input::get('order'))) {
                $item = $model->orderBy('order', 'desc')->first();
                $model->attributes['order'] = $item->order + 1;
            }
        });

        static::deleted(function ($model) {
            // Delete images
            foreach ($model->images as $image) {
                $image->delete();
            }

//            // Delete related
//            foreach ($model->contentable as $item) {
//                $item->delete();
//            }

//            // Delete trans childeren
//            $transChildren = $model->transChildren;
//
//            if (count($transChildren)) {
//                foreach ($transChildren as $item) {
//                    $item->delete();
//                }
//            }
        });
    }

}
