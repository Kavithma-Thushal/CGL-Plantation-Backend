<?php

namespace App\Http\Services;

use App\Models\PackageCustomerDetail;
use App\Repositories\PackageCustomerDetail\PackageCustomerDetailRepositoryInterface;

class PackageCustomerDetailService
{
    public function __construct(
        private PackageCustomerDetailRepositoryInterface $packageCustomerDetailRepositoryInterface,
    ) {
    }

    public function addOrUpdate(int $userPackageId, array $data): PackageCustomerDetail
    {
        $keys = [
            'user_package_id' => $userPackageId,
        ];

        $updateData = [
            'customer_id' => $data['customer_id'] ?? null,
            'country_id' => $data['country_id'] ?? null,
            'race_id' => $data['race_id'] ?? null,
            'nationality_id' => $data['nationality_id'] ?? null,
            'occupation_id' => $data['occupation_id'] ?? null,
            'bank_account_id' => $data['bank_account_id'] ?? null,
            'mobile_number' => $data['mobile_number'] ?? null,
            'landline_number' => $data['landline_number'] ?? null,
            'email' => $data['email'] ?? null,
            'address_si' => $data['address_si'] ?? null,
            'name_with_initial_si' => $data['name_with_initial_si'] ?? null,
            'family_name_si' => $data['family_name_si'] ?? null,
            'first_name_si' => $data['first_name_si'] ?? null,
            'middle_name_si' => $data['middle_name_si'] ?? null,
            'last_name_si' => $data['last_name_si'] ?? null
        ];

        return $this->packageCustomerDetailRepositoryInterface->updateOrCreate($keys, $updateData);
    }
}
