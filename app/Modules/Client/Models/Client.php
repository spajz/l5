<?php namespace App\Modules\Client\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Client extends BaseModel implements SluggableInterface
{
    use ValidationTrait;
    use SluggableTrait;

    protected $table = 'clients';

    protected $fillable = array(
        'title',
        'slug',
        'description',
        'industry',
        'order',
        'featured',
        'status'
    );

    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
    ];

    public function rulesAll()
    {
        return [
            'title' => 'required|max:255',
        ];
    }

    public function rulesUpdate()
    {
        return [
            'slug' => 'required|max:255',
        ];
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
        });
    }

}
