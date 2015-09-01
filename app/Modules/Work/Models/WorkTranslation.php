<?php namespace App\Modules\Work\Models;

use App\BaseModel;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class WorkTranslation extends BaseModel implements SluggableInterface
{
    public $timestamps = false;

    protected $appends = array('full_title');

    use SluggableTrait;

    protected $fillable = [
        'title',
        'sub_title',
        'slug',
        'intro',
        'description',
    ];

    protected $sluggable = [
        'build_from' => 'full_title',
        'save_to' => 'slug',
    ];

    public function getFullTitleAttribute()
    {
        return $this->attributes['title'] . ' ' . $this->attributes['sub_title'];
    }

    public function work()
    {
        return $this->belongsTo('App\Modules\Work\Models\Work', 'work_id');
    }
}
