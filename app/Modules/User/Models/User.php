<?php namespace App\Modules\User\Models;

use App\User as UserModel;
use App\Traits\ValidationTrait;

class User extends UserModel
{
    use ValidationTrait;

    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'group_id',
        'status',
    ];

    public function rulesAll()
    {
        return [
            'group_id' => 'required',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function rulesUpdate()
    {
        return [
            'email' => 'required|email|max:255|unique:users,id,:id',
            'password' => 'required_if:change_password,1|min:6',
        ];
    }

    public function rulesStore()
    {
        return [
            'password' => 'required|min:6',
        ];
    }

    public function group()
    {
        return $this->belongsTo('App\Modules\User\Models\Group', 'group_id', 'id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

}
