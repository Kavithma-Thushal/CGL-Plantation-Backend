<?php

namespace App\Http\Resources;

use App\Enums\PackageMediaTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageMediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customer' => [
                'nic_front' => $this->getPackageMediaViaType(PackageMediaTypeEnum::CUSTOMER_NIC_FRONT),
                'nic_back' => $this->getPackageMediaViaType(PackageMediaTypeEnum::CUSTOMER_NIC_BACK),
            ],
            'beneficiary' => [
                'nic_front' => $this->getPackageMediaViaType(PackageMediaTypeEnum::BENEFICIARY_NIC_FRONT),
                'nic_back' => $this->getPackageMediaViaType(PackageMediaTypeEnum::BENEFICIARY_NIC_BACK),
                'passport' => $this->getPackageMediaViaType(PackageMediaTypeEnum::BENEFICIARY_PASSPORT),
            ],
            'nominee' => [
                'nic_front' => $this->getPackageMediaViaType(PackageMediaTypeEnum::NOMINEE_NIC_FRONT),
                'nic_back' => $this->getPackageMediaViaType(PackageMediaTypeEnum::NOMINEE_NIC_BACK),
            ],
            'other' => [
                'proposal_hard_copy' => $this->getPackageMediaViaType(PackageMediaTypeEnum::OTHER_PROPOSAL_HARD_COPY),
            ]
        ];
    }
}
