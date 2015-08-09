<?php namespace App\Modules\Client\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Client extends BaseModel implements SluggableInterface
{
    use ValidationTrait;
    use SluggableTrait;
    static $setOrder = true;

    protected $table = 'clients';

    protected $fillable = array(
        'title',
        'slug',
        'description',
        'client_group_id',
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
            'client_group_id' => 'required',
        ];
    }

    public function rulesUpdate()
    {
        return [
            'slug' => 'required|max:255',
        ];
    }

    public function images()
    {
        return $this->morphMany('App\Models\Image', 'model')
            ->orderBy('order')
            ->orderBy('id', 'desc');
    }

    public function group()
    {
        return $this->belongsTo('App\Modules\Client\Models\ClientGroup', 'client_group_id');
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

}
