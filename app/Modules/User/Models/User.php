<?php namespace App\Modules\User\Modules;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\BaseModel;

class People extends BaseModel implements SluggableInterface
{
    protected $table = 'pages';

    use SluggableTrait;

    protected $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

    protected $fillable = array(
        'title',
        'slug',
        'status',
    );

}
