<?php namespace App\Library;

use Illuminate\Auth\Guard as BaseGuard;

class Guard extends BaseGuard
{
    public function admin()
    {
        if ($this->check()) {
            $group = $this->user->group;
            if (count($group) && $group->admin == 1) {
                return true;
            }
        }
        return false;
    }
}