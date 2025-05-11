<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class QuotationResource extends JsonResource
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
            'nic' => $this->quotationRequest->nic,
            'name_with_initials' => $this->quotationRequest->name_with_initials,
            'mobile_number' => $this->quotationRequest->mobile_number,
            'title_id' => $this->quotationRequest->title_id,
            'title' => $this->quotationRequest->title->name,
            'first_name' => $this->quotationRequest->first_name,
            'middle_name' => $this->quotationRequest->middle_name,
            'middle_name' => $this->quotationRequest->middle_name,
            'last_name' => $this->quotationRequest->last_name,
            'email' => $this->quotationRequest->email,
            'landline_number' => $this->quotationRequest->landline_number,
            'address' => $this->quotationRequest->address,
            'amount' => $this->amount,
            'expire_date' => $this->expire_date,
            'quotation_number' => $this->quotation_number,
        ];
    }
}
