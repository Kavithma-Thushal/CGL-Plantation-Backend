<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationForRequestResource extends JsonResource
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
            'plan_id' => $this->plan_id,
            'quotation_request_id' => $this->quotation_request_id,
            'plan_name' => $this->plan->name,
            'amount' => $this->amount,
            'expire_date' => $this->expire_date,
            'quotation_number' => $this->quotation_number,
        ];
    }
}
