<?php namespace App\Library;

use Illuminate\Auth\Guard as BaseGuard;

class Guard extends BaseGuard
{
    public function admin()
    {
        if ($this->check()) {
            $adminGroups = array(1, 2);
            if (in_array($this->user->group_id, $adminGroups)) return true;
            return false;
        }
        return false;
    }
}