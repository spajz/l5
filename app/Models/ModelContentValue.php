<?php namespace App\Models;

use App\BaseModel;

class ModelContentValue extends BaseModel {

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Models\ModelContentValue', 'content_id');
    }

}
