<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'user_package_id'=>$this->user_package_id,
            'package_code'=>$this->userPackage->job_code,
            'payment_method'=>$this->payment_method,
            'receipt_number'=>$this->receipt_number,
            'ref_number'=>$this->ref_number,
            'amount'=>$this->amount,
            'payment_date'=>$this->payment_date,
            'is_email'=>$this->is_email,
            'is_download'=>$this->is_download
        ];
    }
}
