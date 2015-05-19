<?php namespace App\Models;

use App\BaseModel;

class ModelContent extends BaseModel {

    public function values()
    {
        return $this->hasMany('App\Models\ModelContentValue', 'content_id');
    }

}
