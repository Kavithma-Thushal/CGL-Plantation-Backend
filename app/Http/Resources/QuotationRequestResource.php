<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationRequestResource extends JsonResource
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
            'nic' => $this->nic,
            'mobile_number' => $this->mobile_number,
            'title_id' => $this->title_id,
            'title' => $this->title->name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'landline_number' => $this->landline_number,
            'address' => $this->address,
            'created_at' => $this->created_at,
            'quotations'=> QuotationForRequestResource::collection($this->quotations)
        ];
    }
}
