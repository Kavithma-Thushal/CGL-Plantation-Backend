<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BenefitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $customer = $this->userPackage->packageCustomerDetail->customer;
        $personalDetails = $customer->getPersonalDetail();
        return [
            'id'=>$this->id,
            'user_package_id'=>$this->user_package_id,
            'customer_name'=>$personalDetails->name,
            'package_code'=>$this->userPackage->job_code,
            'package_name'=>$this->userPackage->plan->name,
            'package_total'=>number_format($this->userPackage->total_amount,2),
            'benefit_type'=> ucwords(strtolower(str_replace('_',' ',$this->benefit_type))) ,
            'payment_term'=> $this->term_name,
            'paid_at'=> $this->paid_at,
            'payment_reference'=> $this->payment_reference,
            'amount'=> number_format($this->amount,2)
        ];
    }
}
