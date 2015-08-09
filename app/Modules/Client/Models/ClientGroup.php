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
        'text_color',
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
            'color' => 'required|max:255',
            'text_color' => 'required|max:255',
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
        return $this->hasMany('App\Modules\Client\Models\Client', 'client_group_id');
    }

}