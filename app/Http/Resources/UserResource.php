<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $personalDetail = $this->getPersonalDetail();
        return [
            'id' => $this->id,
            'username' => $this->username,
            'first_name' => $personalDetail->first_name,
            'last_name' => $personalDetail->last_name,
            'middle_name' => $personalDetail->middle_name,
            'family_name' => $personalDetail->family_name,
            'media_array' => $this->avatar ? new MediaResource($this->avatar) : null,
        ];
    }
}
