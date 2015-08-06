<?php namespace App\Modules\Work\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
use Dimsav\Translatable\Translatable;

class Work extends BaseModel
{
    use ValidationTrait;
    use Translatable;

    protected $table = 'works';

    protected $appends = array('full_title');

    protected $fillable = array(
        'title',
        'sub_title',
        'slug',
        'intro',
        'description',
        'order',
        'featured',
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
            return $this->getTranslation()->title . $this->getTranslation()->sub_title != '' ? ' ' . $this->getTranslation()->sub_title : null;
        }
        return null;
    }

    public function contentable()
    {
        return $this->morphMany('App\Models\Content', 'model')
            ->orderBy('order')
            ->orderBy('id', 'desc');
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

            // Delete related
            foreach ($model->contentable as $item) {
                $item->delete();
            }
        });
    }

    public function scopeTranslated($query, $lang = null)
    {
        return $this->joinTranslations($query, $lang);
    }

}
