<?php namespace App\Models;

use App\BaseModel;

class ContentTranslation extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'content',
    ];
}
