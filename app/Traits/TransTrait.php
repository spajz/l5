<?php namespace App\Traits;

trait TransTrait
{
    protected $useTransParentImagesDefault = true;

    public function transParent()
    {
        return $this->belongsTo(__CLASS__, 'trans_id', 'id');
    }

    public function transChildren()
    {
        return $this->hasMany(__CLASS__, 'trans_id', 'id');
    }

    public function transRelated()
    {
        $query = $this->newQuery();

        if ($this->trans_id == 0) {
            $query->where('id', $this->id)
                ->orWhere('trans_id', $this->id);
        } else {
            $query->where('id', $this->trans_id)
                ->orWhere('trans_id', $this->trans_id);
        }

        return $query->get()
            ->keyBy('lang');
    }

    public function scopeHasTrans($query, $id, $lang)
    {
        return $query->where('trans_id', $id)
            ->where('lang', $lang);
    }

    protected function useTransParentImages()
    {
        if (property_exists($this, 'useTransParentImages')) {
            return $this->useTransParentImages;
        }
        return $this->useTransParentImagesDefault;
    }

    /**
     * Return image collection from self or parent item.
     *
     * @return mixed
     */
    public function images()
    {
        if ($this->useTransParentImages() && $this->trans_id != 0) {
            return $this->imagesFromTransParent();
        }
        return $this->imagesFromSelf();
    }

    public function imagesFromTransParent()
    {
        $transParent = $this->transParent()->first();
        if ($transParent) {
            return $transParent->imagesMorph();
        }
    }

    public function imagesFromSelf()
    {
        return $this->imagesMorph();
    }

    protected function imagesMorph()
    {
        return $this->morphMany('App\Models\Image', 'model')->orderBy('order');
    }
}

