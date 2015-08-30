<?php namespace App\Modules\Page\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
use Dimsav\Translatable\Translatable;

class Page extends BaseModel
{
    use ValidationTrait;
    use Translatable;

    protected $table = 'pages';

    protected $appends = array('full_title');

    protected $fillable = array(
        'title',
        'sub_title',
        'slug',
        'intro',
        'description',
        'order',
        'status'
    );

    public $translatedAttributes = [
        'title',
        'sub_title',
        'slug',
        'intro',
        'description',
    ];

    protected $useTransParentImages = false;

    public function rulesAll()
    {
        return [
            'title' => 'required|max:255',
        ];
    }

    public function getFullTitleAttribute()
    {
        if ($this->hasTranslation()) {
            return $this->getTranslation()->sub_title != '' ? $this->getTranslation()->title .  ' ' . $this->getTranslation()->sub_title : $this->getTranslation()->title;
        }
        return null;
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
