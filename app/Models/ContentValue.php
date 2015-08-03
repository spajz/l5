<?php namespace App\Models;

use App\BaseModel;

class ContentValue extends BaseModel
{
    public $timestamps = false;

    protected $attributes = array(
        'order' => 0,
    );

    protected $fillable = array(
        'content_id',
        'value',
        'value_type',
        'value_sub_type',
        'order',
    );

    public function content()
    {
        return $this->belongsTo('App\Models\ContentValue', 'content_id');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('value_type', $type);
    }

}
