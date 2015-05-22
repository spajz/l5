<?php namespace App\Models;

use App\BaseModel;

class ModelContentValue extends BaseModel {

    public $timestamps = false;

    protected $fillable = array(
        'model_content_id',
        'value',
        'order',
        'status'
    );

    public function user()
    {
        return $this->belongsTo('App\Models\ModelContentValue', 'model_content_id');
    }

}
