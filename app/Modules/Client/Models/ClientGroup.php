<?php namespace App\Modules\Client\Models;

use App\BaseModel;
use App\Traits\ValidationTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Input;

class ClientGroup extends BaseModel implements SluggableInterface
{
    use ValidationTrait;
    use SluggableTrait;

    protected $table = 'client_groups';

    protected $fillable = array(
        'title',
        'slug',
        'color',
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

    public function clients()
    {
        return $this->hasMany('App\Modules\Client\Models\Client', 'group_id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Set order
            if (!$model->exists && is_null(Input::get('order'))) {
                $item = $model->orderBy('order', 'desc')->first();
                if ($item) {
                    $model->attributes['order'] = $item->order + 1;
                }
            }
        });
    }

}
