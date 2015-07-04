<?php namespace App\Modules\Client\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
use App\Traits\TransTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Client extends BaseModel implements SluggableInterface
{
    use ValidationTrait;
    use TransTrait;
    use SluggableTrait;

    protected $table = 'clients';

    protected $fillable = array(
        'title',
        'slug',
        'description',
        'industry',
        'lang',
        'trans_id',
        'order',
        'featured',
        'status'
    );

    protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    protected $useTransParentImages = false;

    public function rulesAll()
    {
        return [
            'title' => 'required|max:255',
        ];
    }

    public function contentable()
    {
        return $this->morphMany('App\Models\ModelContent', 'model')
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
