<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
        [
            "links" => [
                "first" => $this->url(1),
                "last" => $this->url($this->lastPage()),
                "prev" => $this->previousPageUrl(),
                "next" => $this->nextPageUrl(),
            ],
            "meta" => [
                "current_page" => $this->currentPage(),
                "last_page" =>  $this->lastPage(),
                "path" => $request->url(),
                "per_page" => $this->perPage(),
                "total" => $this->total()
            ],
        ];
    }
}
