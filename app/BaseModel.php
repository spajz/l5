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

}