<?php

namespace App\Http\Services;

use App\Classes\CodeGenerator;
use App\Classes\NICConverter;
use App\Models\Customer;
use App\Repositories\Customer\CustomerRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CustomerService
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepositoryInterface,
        private UserService $userService,
        private UserRepositoryInterface $userRepositoryInterface,
        private PersonalDetailService $personalDetailService
    ) {
    }

    public function firstOrCreate(string $nic, array $data): Customer
    {
        $user = $this->userRepositoryInterface->findByNIC($nic);
        if ($user == null) {
            $userData['mobile_number'] = $data['mobile_number'];
            $userData['first_name'] = $data['first_name'];
            $userData['license_number'] = $data['license_number'] ?? null;
            $userData['passport_number'] = $data['passport_number'] ?? null;
            $userData['nic'] = $nic;
            $userData['dob'] =  NICConverter::getDOB($nic);
            $user = $this->userService->add($userData);
        }

        $customerData = [
            'customer_number' => CodeGenerator::getCustomerCode(),
            'license_number' => $data['license_number'] ?? null,
            'passport_number' => $data['passport_number'] ?? null,
            'status' => 1
        ];
        $customer = $this->customerRepositoryInterface->updateOrCreate(['user_id' => $user->id], $customerData);
        $this->addPersonalData($customer->id,$data, Customer::class);
        return $customer;
    }

    /* store personal details in polymorphic table */
    private function addPersonalData($recordId, $data, $model)
    {
        $personalData = [
            'title_id' => $data['title_id'],
            'name_with_initials' => $data['name_with_initials'] ?? null,
            'family_name' => $data['family_name'] ?? null,
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'address' => $data['address'] ?? null,
        ];
        $this->personalDetailService->add($recordId, $model, $personalData);
    }

    public function getAll(array $filters): Collection
    {
        return $this->customerRepositoryInterface->getAll($filters);
    }

    public function find(int $customerId): ?object
    {
        return $this->customerRepositoryInterface->find($customerId);
    }

    public function update($customerId, array $data) {

        $customerData = [
            'status' => $data['status'],
        ];

        return $this->customerRepositoryInterface->update($customerId,$customerData);
    }

}
