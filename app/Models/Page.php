<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use App\BaseModel;

class Page extends BaseModel implements SluggableInterface
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
