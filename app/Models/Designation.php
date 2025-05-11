<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Designation extends Model
{
    use HasFactory;
    protected $guarded = [];
    private $parentIds = [];

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
}
