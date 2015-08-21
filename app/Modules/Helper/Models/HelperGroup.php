<?php namespace App\Modules\Helper\Models;

use App\BaseNestedsetModel;
use App\Traits\ValidationTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class HelperGroup extends BaseNestedsetModel implements SluggableInterface
{
    use ValidationTrait;
    use SluggableTrait;

    protected $table = 'helper_groups';

    protected $appends = ['text'];

    protected $fillable = array(
        'title',
        'slug',
        'intro',
        'description',
        'status',
        'parent_id',
    );

    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
    ];

    public static function transform()
    {
        return function ($item, $transformer) {
            return [
                'id' => $item['id'],
                'title' => $item['text'],
                'children' => $transformer->transformArray($item['children']),
            ];
        };
    }

    public function rulesAll()
    {
        return [
            'title' => 'required|max:255',
        ];
    }

    public function rulesUpdate()
    {
        return [
            'slug' => 'required|max:255',
        ];
    }

    public function helpers()
    {
        return $this->hasMany('App\Modules\Helper\Models\helper', 'helper_group_id');
    }

    public function getTextAttribute()
    {
        return $this->attributes['title'];
    }


    //////////////////////////////////////

    /**
     * Save roots only
     * @param type $items
     * @return type
     */
    public static function updateTreeRoots($items)
    {
        if (is_array($items)) {
            foreach ($items as $item) {
                $node = self::find($item['id']);
                $node->parent_id = null;
                $node->save();
            }
        }
    }

    /**
     * Rebuilds the tree: update descendants and their order
     * @param type $items
     * @return type
     */
    public static function rebuildTree($items)
    {
        if (is_array($items)) {

            foreach ($items as $key => $item) {
                $node = self::find($item['id']);
                $shift = count($node->getNextSiblings());
                $node->down($shift);

                // Loop recursively through the children
                if (isset($item['children']) && is_array($item['children'])) {
                    foreach ($item['children'] as $child) {

                        // Append the children to their (old/new)parents
                        $descendant = self::find($child['id']);
                        $node->appendNode($descendant);

                        // Ordering trick here, shift the descendants to the bottom to get the right order at the end
                        $shift = count($descendant->getNextSiblings());
                        $descendant->down($shift);
                        self::rebuildTree($item['children']);
                    }
                }
            }
        }
    }

    /**
     * a method to get the children by order
     * @param type $categories
     * @return type
     */
    public function getChildren()
    {
        return $this->children()->orderBy('_lft')->get();
    }

}
