<?php namespace App\Modules\Helper\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Helper extends BaseModel implements SluggableInterface
{
    use ValidationTrait;
    use SluggableTrait;
    static $setOrder = false;

    protected $table = 'helpers';

    protected $fillable = array(
        'title',
        'slug',
        'helper_group_id',
        'intro',
        'description',
        'type',
        'status',
        'featured',
    );

    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
    ];

    public function rulesAll()
    {
        return [
            'title' => 'required|max:255',
            'helper_group_id' => 'required',
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
        return $this->belongsTo('App\Modules\Helper\Models\HelperGroup', 'helper_group_id');
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
