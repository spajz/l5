<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Input;

class BaseModel extends Model
{

    public function reorder($columns, $orderColumn = 'order')
    {
        $items = $this->where($columns)
            ->orderBy($orderColumn)
            ->get();

        if (count($items)) {
            $i = 1;
            foreach ($items as $item) {
                $item->$orderColumn = $i;
                $i++;
                $item->save();
            }
        }
    }

    public static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            if (is_array(Input::get('updated_at'))) {
                if (Input::get('updated_at.' . $model->id) != $model->updated_at) {
                    msg('This article has been changed in the meantime. Please edit again.', 'danger');
                    return false;
                }
            } elseif (!is_null(Input::get('updated_at'))) {
                if (Input::get('updated_at') != $model->updated_at) {
                    msg('This article has been changed in the meantime. Please edit again.', 'danger');
                    return false;
                }
            }
        });
    }
}