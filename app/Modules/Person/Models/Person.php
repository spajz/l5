<?php namespace App\Modules\Person\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
use Dimsav\Translatable\Translatable;

class Person extends BaseModel
{
    use ValidationTrait;
    use Translatable;
    static $setOrder = true;

    protected $table = 'persons';

    protected $appends = array('full_name');

    protected $fillable = array(
        'first_name',
        'last_name',
        'job_title',
        'description',
        'color',
        'text_color',
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
            'text_color' => 'required|max:255',
        ];
    }

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

    public function images()
    {
        return $this->morphMany('App\Models\Image', 'model')
            ->orderBy('order')
            ->orderBy('id', 'desc');
    }

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            // Delete images
            foreach ($model->images as $image) {
                $image->delete();
            }
        });
    }

    public function scopeTranslated($query, $lang = null)
    {
        return $this->joinTranslations($query, $lang);
    }
}