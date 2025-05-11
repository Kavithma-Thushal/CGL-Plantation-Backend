<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request): array
    {
        $personalDetails = $this->getPersonalDetail();
        $packageCustomerDetail = $this->packageCustomerDetails;
        return [
            'id'=> $this->id,
            'first_name' => $personalDetails->first_name ?: null,
            'last_name' => $personalDetails->last_name ?: null,
            'middle_name' => $personalDetails->middle_name ?: null,
            'full_name' => $personalDetails->name,
            'nic' => $this->user->nic ?? null,
            'customer_number' => $this->customer_number ?? null,
            'status' => $this->status ? true : false,
            'mobile_number' => $personalDetails->mobile_number ?? null,
            'proposal_count' => $this->packageCustomerDetails()->count(),
        ];
    }
}
