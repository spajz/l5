<?php namespace App\Modules\Person\Models;

use App\BaseModel;

class PersonTranslation extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'description',
    ];
}
