<?php namespace App\Modules\Person\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;

class Person extends BaseModel
{
    use ValidationTrait;

    protected $table = 'persons';

    protected $fillable = array(
        'first_name',
        'last_name',
        'job_title',
        'description',
        'order',
        'status'
    );

    protected $useTransParentImages = true;

    public function rulesAll()
    {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'job_title' => 'required|max:255',
        ];
    }

    public function images()
    {
        if ($this->useTransParentImages && $this->trans_id != 0) {
            return $this->imagesFromTransParent();
        }

        return $this->imagesFromSelf();
    }

    public function imagesFromTransParent()
    {
        $transParent = $this->transParent()->first();
        if ($transParent) {
            return $transParent->imagesMorph()->get();
        }
    }

    public function imagesFromSelf()
    {
        return $this->imagesMorph();
    }

    protected function imagesMorph()
    {
        return $this->morphMany('App\Models\Image', 'model');
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

    public function transParent()
    {
        return $this->belongsTo(__CLASS__, 'trans_id', 'id');
    }

    public function transChildren()
    {
        return $this->hasMany(__CLASS__, 'trans_id', 'id');
    }

    public function transRelated()
    {
        $query = $this->newQuery();

        if ($this->trans_id == 0) {
            $query->where('id', $this->id)
                ->orWhere('trans_id', $this->id);
        } else {
            $query->where('id', $this->trans_id)
                ->orWhere('trans_id', $this->trans_id);
        }

        return $query->get()
            ->keyBy('lang');
    }

    public function scopeHasTrans($query, $id, $lang)
    {
        return $query->where('trans_id', $id)
            ->where('lang', $lang);
    }

}
