<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Input;

class BaseModel extends Model
{
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

    public function joinTranslations($query, $lang = null, $class = null)
    {
        if (is_null($lang)) {
            $lang = app()->getLocale();
        }
        if (is_null($class)) {
            $class = get_class($this);
        }
        $className = strtolower(class_basename($class));
        $joinTable = $className . '_translations';
        $plural = str_plural($className);
        if (strpos($plural, $className) !== 0) {
            $tableName = $className . 's';
        } else {
            $tableName = $plural;
        }
        return $query->leftJoin($joinTable, function ($join) use ($className, $tableName, $joinTable, $lang) {
            $join->on($joinTable . '.' . $className . '_id', '=', $tableName . '.id')
                ->where($joinTable . '.locale', '=', $lang);
        });
    }

}