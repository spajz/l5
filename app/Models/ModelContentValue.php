<?php namespace App\Models;

use App\BaseModel;

class ModelContentValue extends BaseModel
{
    public $timestamps = false;

    protected $attributes = array(
        'order' => 0,
    );

    protected $fillable = array(
        'model_content_id',
        'value',
        'value_type',
        'order',
    );

    public function content()
    {
        return $this->belongsTo('App\Models\ModelContentValue', 'model_content_id');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('value_type', $type);
    }

}
