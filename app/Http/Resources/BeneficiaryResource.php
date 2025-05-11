<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BeneficiaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $personalDetailRecord = new PersonalDetailsResource($this->personalDetails()->active()->first());
        $personalDetailRecord = $personalDetailRecord->toArray($request);
        $data = [
            'id' => $this->id,
            'nic' => $this->nic,
            'relationship' => $this->relationship
        ];
        return array_merge($data,$personalDetailRecord);
    }
}
