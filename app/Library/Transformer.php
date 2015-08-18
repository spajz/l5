<?php namespace App\Library;

use Illuminate\Support\Collection;

class Transformer
{
    protected $collection;
    protected $transformer;
    protected $transformers;
    protected $collectionIgnoreKeys = [];

    public function setCollectionIgnoreKeys($keys)
    {
        $this->collectionIgnoreKeys = $keys;
    }

    public function makeCollection($collection)
    {
        $thisObj = $this;
        $keys = [];
        $depth = 0;
        if (!$collection instanceof Collection) {
            $collection = collect($collection);
        }


        return $collection->transform(function ($item, $key) use ($thisObj, &$keys) {
            $transformer = null;
            if (is_array($item)) {
                foreach ($item as $itemKey => $itemValue) {

                    ee($itemKey);

                    $transformer2 = null;
                    if(isset($this->transformers[$itemKey])){
                        $transformer2 = $this->transformers[$itemKey];
                    }

                    if (in_array($itemKey, $this->collectionIgnoreKeys)) {
                        //continue;
                    }
                    if (is_array($itemValue)) {
                        if(is_callable($transformer2)){
                            $item[$itemKey] = $thisObj->makeCollection($transformer2($itemValue));
                        } else {
                            $item[$itemKey] = $thisObj->makeCollection($itemValue);
                        }
                    }
                }
            }
//            if(isset($item['children'])){
//                $item['children'] = make_collection($item['children']);
//            }

//            dd($this->transformers);

            if($this->transformer){
                $transformer = $this->transformer;
            };


            if(is_callable($transformer)){
                return $transformer($item);
            }
            return $item;

        });

    }

    public function setTransformerByKey($key, $transformer, $parentKey = null)
    {
        $this->transformers[$key] = $transformer;
    }

    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;
    }


    /*
    public static function string($string = null)
    {
        return ucfirst($string);
    }

    public function index()
    {
        return 'index';
    }



    function make_collection($collection){
        if(!$collection instanceof Collection){
            $collection = collect($collection);
        }

        return $collection->transform(function ($item, $key) {
            if(isset($item['children'])){
                $item['children'] = make_collection($item['children']);
            }
            return $item;
        });
    }

    function make_fractal($collection){
        if(!$collection instanceof Collection){
            $collection = collect($collection);
        }

        return $collection->transform(function ($item, $key) {
            if(isset($item['children'])){
                $item['children'] = make_collection($item['children']);
            }
            return $item;
        });
    }
*/

} 