<?php namespace App\Modules\Work\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
//use App\Traits\TransTrait;
use Dimsav\Translatable\Translatable;
//use Cviebrock\EloquentSluggable\SluggableInterface;
//use Cviebrock\EloquentSluggable\SluggableTrait;

class Work extends BaseModel //implements SluggableInterface
{
    use ValidationTrait;
//    use TransTrait;
    use Translatable;
//    use SluggableTrait;

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

//    protected $sluggable = [
//        'build_from' => 'full_title',
//        'save_to'    => 'slug',
//    ];

    protected $useTransParentImages = false;

    public function rulesAll()
    {
        return [
            'title' => 'required|max:255',
        ];
    }

    public function contentable()
    {
        return $this->morphMany('App\Models\Content', 'model')
            ->orderBy('order')
            ->orderBy('id', 'desc');
    }

    public function getFullTitleAttribute()
    {
//        return $this->attributes['title'] . ' ' . $this->attributes['sub_title'];
        return 'full name';
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
