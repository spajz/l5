<?php namespace App\Library;

use Illuminate\Support\Collection;

class Transformer
{
    protected $collection;
    protected $transformer;
    protected $transformers;
    protected $collectionIgnoreKeys = [];
    public $items;

    public function transformCollection($collection)
    {
        $thisObj = $this;
        if (!$collection instanceof Collection) {
            $collection = collect($collection);
        }

        return $collection->transform(function ($item, $key) use ($thisObj) {
            $transformer = null;
            if (is_array($item)) {
                foreach ($item as $itemKey => $itemValue) {

                    $transformerByKey = null;
                    if (isset($this->transformers[$itemKey])) {
                        $transformerByKey = $this->transformers[$itemKey];
                    }

                    if (in_array($itemKey, $this->collectionIgnoreKeys)) {
                        continue;
                    }

                    if (is_array($itemValue)) {
                        if (is_callable($transformerByKey)) {
                            $item[$itemKey] = $thisObj->transformCollection($transformerByKey($itemValue));
                        } else {
                            $item[$itemKey] = $thisObj->transformCollection($itemValue);
                        }
                    }
                }
            }

            if ($this->transformer) {
                $transformer = $this->transformer;
            };

            if (is_callable($transformer)) {
                return $transformer($item);
            }
            return $item;
        });
    }

    public function transformArray($array)
    {
        $cb = $this->transformer;

        if (is_array($array)) {
            foreach ($array as $k => &$v) {
                $v = $cb($v, $this);
            }
        }

        return $array;
    }

    public function setCollectionIgnoreKeys($keys)
    {
        $this->collectionIgnoreKeys = $keys;
    }

    public function setTransformerByKey($key, $transformer, $parentKey = null)
    {
        $this->transformers[$key] = $transformer;
    }

    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;
    }

} 