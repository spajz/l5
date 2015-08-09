<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Input;
use App\Traits\TranslateTrait;

class BaseModel extends Model
{
    use TranslateTrait;

    static $setOrder = null;

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

        if (static::$setOrder) {
            static::creating(function ($model) {
                // Set order
                if (!$model->exists && is_null(Input::get('order'))) {
                    $item = $model->orderBy('order', 'desc')->first();
                    if ($item) {
                        $model->attributes['order'] = $item->order + 1;
                    } else {
                        $model->attributes['order'] = 1;
                    }
                }
            });
        }
    }



}