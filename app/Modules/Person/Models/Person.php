<?php namespace App\Modules\Person\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
use App\Traits\TransTrait;

class Person extends BaseModel
{
    use ValidationTrait;
    use TransTrait;

    protected $table = 'persons';

    protected $appends = array('full_name');

    protected $fillable = array(
        'first_name',
        'last_name',
        'job_title',
        'description',
        'lang',
        'trans_id',
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

    public function contentable()
    {
        return $this->morphMany('App\Models\ModelContent', 'model')
            ->orderBy('order')
            ->orderBy('id', 'desc');
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            // Delete images
            foreach ($model->images as $image) {
                $image->delete();
            }

            // Delete related
            foreach ($model->contentable as $item) {
                $item->delete();
            }

            // Delete trans childeren
            $transChildren = $model->transChildren;

            if (count($transChildren)) {
                foreach ($transChildren as $item) {
                    $item->delete();
                }
            }
        });
    }

}
