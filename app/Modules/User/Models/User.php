<?php namespace App\Modules\User\Models;

use App\User as UserModel;

class User extends UserModel
{

    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'group_id',
    ];

    public function group()
    {
        return $this->belongsTo('App\Modules\User\Models\Group', 'group_id', 'id');
    }
}
