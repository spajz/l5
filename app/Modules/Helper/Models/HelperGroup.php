<?php namespace App\Modules\Helper\Models;

use App\BaseBaumModel;
use App\Traits\ValidationTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class HelperGroup extends BaseBaumModel implements SluggableInterface
{
    use ValidationTrait;
    use SluggableTrait;

    protected $table = 'helper_groups';

    protected $appends = ['text'];

    protected $fillable = array(
        'title',
        'slug',
        'intro',
        'description',
        'status',
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

    public function helpers()
    {
        return $this->hasMany('App\Modules\Helper\Models\helper', 'helper_group_id');
    }

    public function getTextAttribute()
    {
        return $this->attributes['title'];
    }

}
