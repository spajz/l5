<?php namespace App\Modules\User\Models;

use App\BaseModel;

class Group extends BaseModel {

    protected $fillable = [
        'name',
        'status',
    ];

    public function users()
    {
        return $this->hasMany('App\Modules\User\Models\User', 'group_id', 'id');
    }

}
