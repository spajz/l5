<?php namespace App\Library;

use Illuminate\Auth\Guard as BaseGuard;

class Guard extends BaseGuard
{
    public function admin()
    {
        if ($this->check()) {
            return $this->user->group->admin ? true : false;
        }
        return false;
    }
}