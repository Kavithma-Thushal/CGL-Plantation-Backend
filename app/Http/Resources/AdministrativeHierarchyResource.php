<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdministrativeHierarchyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'administrative_level_id' => $this->administrative_level_id,
            'administrative_level' => ucwords(strtolower($this->administrativeLevel->name)),
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'breadcrumb'=>$this->getBreadcrumb()
        ];
    }
}
