<?php namespace App\Traits;

trait TranslateTrait
{
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

