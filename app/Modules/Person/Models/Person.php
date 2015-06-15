<?php namespace App\Modules\Person\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
use App\Traits\TransTrait;

class Person extends BaseModel
{
    use ValidationTrait;
    use TransTrait;

    protected $table = 'persons';

    protected $fillable = array(
        'first_name',
        'last_name',
        'job_title',
        'description',
        'order',
        'status'
    );

   protected $useTransParentImages = false;

    public function rulesAll()
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'job_title' => 'required|max:255',
        ];
    }

    public static function boot()
    {
        parent::boot();

//        static::deleted(function ($model) {
//            foreach ($model->images as $image) {
//                $image->delete();
//            }
//        });
    }

    public function contentable()
    {
        return $this->morphMany('App\Models\ModelContent', 'model')
            ->orderBy('order')
            ->orderBy('id', 'desc');
    }

}
