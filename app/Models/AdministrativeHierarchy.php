<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class AdministrativeHierarchy extends Model
{
    use HasFactory;
    protected $guarded = [];
    private $parentIds = [];

    public function administrativeLevel()
    {
        return $this->belongsTo(AdministrativeLevel::class, 'administrative_level_id');
    }

    public function branches()
    {
        return $this->belongsTo(Branch::class, 'administrative_hierarchy_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function checkValidParentId(int $parentId)
    {
        $childrenIds = $this->getChildrenIdArrayRecursively();
        array_push($childrenIds,$this->id);
        return !in_array($parentId, $childrenIds);
    }

    private function getChildrenIdArrayRecursively() : array
    {
        $ids = [];
        $children = $this->children;

        foreach ($children as $child) {
            $ids[] = $child->id; // Add the child's ID to the array

            // Recursively get the child IDs and merge them into the main array
            $childIds = $child->getChildrenIdArrayRecursively();
            $ids = array_merge($ids, $childIds);
        }

        return $ids;
    }

    public function hasChildren()
    {
        return $this->children()->exists();
    }

    public function getBreadcrumb()
    {
        $breadcrumbArray = [];
        $this->buildBreadcrumb($this, $breadcrumbArray);
        return array_reverse($breadcrumbArray);
    }

    private function buildBreadcrumb($node, &$breadcrumbArray = [])
    {
       // Add current node's name to the breadcrumb array
        $breadcrumbArray[] = $node->name;

       // If the current node has a parent, continue recursively
       if ($node->parent) {
           $this->buildBreadcrumb($node->parent, $breadcrumbArray);
       }
    }
}
