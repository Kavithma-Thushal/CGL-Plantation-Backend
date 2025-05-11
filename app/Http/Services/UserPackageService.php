<?php

namespace App\Http\Services;

use App\Models\UserPackage;
use App\Classes\CodeGenerator;
use App\Enums\PackageStatusesEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Repositories\UserPackage\UserPackageRepositoryInterface;
use Illuminate\Support\Facades\Log;

class UserPackageService
{
    public function __construct(
        private CustomerService $customerService,
        private StakeholderService $stakeholderService,
        private BankAccountService $bankAccountService,
        private PackageTimelineService $packageTimelineService,
        private PackageCustomerDetailService $packageCustomerDetailService,
        private UserPackageRepositoryInterface $userPackageRepositoryInterface,
    ) {}

    public function getAll(array $data)
    {
        $packages =  $this->userPackageRepositoryInterface->getAll($data);
        $packages->map(function ($item) {
            $item['action_permissions'] = $this->getPackageActionPermissions($item);
            return $item;
        });
        return $packages;
    }

    public function getPaginate(array $data)
    {
        $packages =  $this->userPackageRepositoryInterface->getPaginate($data);
        $packages->getCollection()->transform(function ($item) {
            $item['action_permissions'] = $this->getPackageActionPermissions($item);
            return $item;
        });
        return $packages;
    }

    private function getPackageActionPermissions($package)
    {
        $edit = false;
        $uploadDocuments = false;
        $submitToSupervisor = false;
        $supervisorApproval = false;
        $documentVerify = false;
        $print = false;
        $readyToSign = false;
        $sign = false;
        $start = false;
        $mature = false;

        $currentStatus = $package->getActiveTimeline()->packageStatus->name;

        if ($currentStatus == PackageStatusesEnum::SUBMITTED_FOR_SUPERVISOR) {
            // package created user has access to edit it till supervisor approval
            if (Auth::id() == $package->created_user_id) {
                $edit = true;
                $uploadDocuments = true;
            }
            // supervisor has access to edit and approve or reject
            else if ($package->user->employee->getActiveEmployeeDesignation()->reportingPerson != null && Auth::id() == $package->user->employee->getActiveEmployeeDesignation()->reportingPerson->user_id) {
                $edit = true;
                $uploadDocuments = true;
                $supervisorApproval = true;
            }
        } else if ($currentStatus == PackageStatusesEnum::SUPERVISOR_REJECTED) {
            // package created user has access to edit and re-submit for supervisor approval when supervisor rejected the package
            if (Auth::id() == $package->created_user_id) {
                $edit = true;
                $uploadDocuments = true;
                $submitToSupervisor = true;
            }
        } else if ($currentStatus == PackageStatusesEnum::SUPERVISOR_APPROVED) {
            // supervisor
            if ($package->user->employee->getActiveEmployeeDesignation()->reportingPerson != null && Auth::id() == $package->user->employee->getActiveEmployeeDesignation()->reportingPerson->user_id) {
                $edit = true;
                $uploadDocuments = true;
            }
        } else if ($currentStatus == PackageStatusesEnum::DOCUMENT_VERIFICATION) {
            // head office admin executive
            if (Auth::user()->employee->getActiveEmployeeDesignation()->designation->name == 'Admin Executive') {
                $documentVerify = true;
                $uploadDocuments = true;
            }
        } else if ($currentStatus == PackageStatusesEnum::DOCUMENT_VERIFIED) {
            // no permission
        } else if ($currentStatus == PackageStatusesEnum::DOCUMENT_REJECTED) {
            // supervisor
            if (Auth::user()->employee->getActiveEmployeeDesignation()->designation->name == 'Admin Executive') {
                $documentVerify = true;
                $uploadDocuments = true;
            }
        } else if ($currentStatus == PackageStatusesEnum::AGREEMENT_PRINT) {
            // supervisor
            if (Auth::user()->employee->getActiveEmployeeDesignation()->designation->name == 'Admin Executive') {
                $print = true;
            }
        } else if ($currentStatus == PackageStatusesEnum::READY_TO_SIGN) {
            // supervisor
            if (Auth::user()->employee->getActiveEmployeeDesignation()->designation->name == 'Admin Executive') {
                $readyToSign = true;
            }
        } else if ($currentStatus == PackageStatusesEnum::SIGNED) {
            // supervisor
            if (Auth::user()->employee->getActiveEmployeeDesignation()->designation->name == 'Admin Executive') {
                $start = true;
            }
        } else if ($currentStatus == PackageStatusesEnum::STARTED) {
            // supervisor
            if (Auth::user()->employee->getActiveEmployeeDesignation()->designation->name == 'Admin Executive') {
                $mature = true;
            }
        }


        return [
            'edit' => $edit,
            'upload_documents' => $uploadDocuments,
            'submit_to_supervisor' => $submitToSupervisor,
            'supervisor_approval' => $supervisorApproval,
            'document_verify' => $documentVerify,
            'print' => $print,
            'ready_to_sign' => $readyToSign,
            'sign' => $sign,
            'start' => $start,
            'mature' => $mature,
        ];
    }

    public function getById(int $id)
    {
        return $this->userPackageRepositoryInterface->find($id);
    }

    public function getFullDetail(int $id): array
    {
        $userPackage = $this->userPackageRepositoryInterface->find($id);
        $customer = $userPackage->packageCustomerDetail->customer;
        $beneficiary = $userPackage->beneficiary;

        return [
            'full_name' => $customer->getPersonalDetail()->name,
            'name_with_initials' => $customer->getPersonalDetail()->name_with_initials,
            'address' => $customer->getPersonalDetail()->address,
            'nic' => $customer->user->nic,
            'plan_name' => $userPackage->plan->name,
            'job_code' => $userPackage->job_code,
            'beneficiary_name' => $beneficiary->getPersonalDetail()->name,
            'total_amount' => $userPackage->total_amount,
            'term' => $userPackage->term,
            'lang' => $userPackage->lang,
        ];
    }

    public function updatePaymentTerm(int $id)
    {
        $currentDate = now();
        $day = $currentDate->day > 28 ? 28 : $currentDate->day;
        $paymentTermDate = $currentDate->copy()->day($day);
        return $this->userPackageRepositoryInterface->update($id, ['benefit_term_date' => $paymentTermDate]);
    }

    // get  proposals that created by auth user in the current branch
    public function getAgent()
    {
        $data['created_user_id'] = Auth::id();
        $data['branch_id'] = Auth::user()->employee->currentEmployeeBranch->branch_id;
        return $this->userPackageRepositoryInterface->getAll($data);
    }

    public function getSupervisor()
    {
        $data['supervisor_employee_id'] = Auth::user()->employee->id;
        $data['branch_id'] = Auth::user()->employee->currentEmployeeBranch->branch_id;
        return $this->userPackageRepositoryInterface->getAll($data);
    }

    public function getPaymentPending()
    {
        $data['branch_id'] = Auth::user()->employee->currentEmployeeBranch->branch_id;
        return $this->userPackageRepositoryInterface->getPaymentPending($data);
    }

    public function delete(int $id)
    {
        return $this->userPackageRepositoryInterface->delete($id);
    }

    public function update(int $userPackageId, array $data)
    {
        DB::beginTransaction();
        try {
            /* user package create */
            $userPackage = [
                'created_user_id' => Auth::id(),
                'agent_id' => $data['agent_id'],
                'branch_id' =>  Auth::user()->employee->currentEmployeeBranch->branch_id,
                'plan_id' => $data['plan_id'],
                'total_amount' => $data['total_amount'],
                'payment_mode' => $data['payment_mode'],
                'lang' => $data['lang'],
                'land_size' => $data['land_size'] ?? null,
                'land_value' => $data['land_value'] ?? null,
                'number_of_trees' => $data['number_of_trees'] ?? null,
                'term' => $data['term'] ?? null,
                'number_of_trees' => $data['number_of_trees'] ?? null,
                'tree_brand_id' => $data['tree_brand_id'] ?? null
            ];
            $this->userPackageRepositoryInterface->update($userPackageId, $userPackage);

            $userPackage = $this->userPackageRepositoryInterface->find($userPackageId);
            $code = $this->generateCode($userPackage);
            $this->userPackageRepositoryInterface->update($userPackage->id, ['job_code' => $code]);
            /* package timeline is not updating when package details update */

            /* customer create */
            $customer = $this->customerService->firstOrCreate($data['nic'], $data);

            if ($userPackage->packageCustomerDetail->bank_account_id) {
                /* bank account create */
                $bankAccountDetails = [
                    'bank_id' => $data['beneficiary']['bank_id'],
                    'account_number' => $data['beneficiary']['account_number'],
                    'branch_name' => $data['beneficiary']['branch_name'] ?? null
                ];
                $this->bankAccountService->update($userPackage->packageCustomerDetail->bank_account_id, $bankAccountDetails);
            }

            /* package customer details create */
            $data['customer_id'] = $customer->id;
            $data['bank_account_id'] = $userPackage->packageCustomerDetail->bank_account_id;
            $this->packageCustomerDetailService->addOrUpdate($userPackageId, $data);

            /* beneficiary create or update*/
            $this->stakeholderService->addBeneficiary($userPackageId, $data);

            /* nominee create / update or delete old */
            $this->stakeholderService->addNominees($userPackageId, $data);

            /* introducer create or update*/
            // $this->stakeholderService->updateOrCreateIntroducer($userPackageId, $data);
            $userPackage = $this->userPackageRepositoryInterface->find($userPackageId);
            DB::commit();
            return $userPackage;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function add(array $data): UserPackage
    {
        DB::beginTransaction();
        try {
            /* user package create */
            $userPackage = [
                'created_user_id' => Auth::id(),
                'agent_id' => $data['agent_id'],
                'branch_id' =>  Auth::user()->employee->currentEmployeeBranch->branch_id,
                'plan_id' => $data['plan_id'],
                'total_amount' => $data['total_amount'],
                'payment_mode' => $data['payment_mode'],
                'lang' => $data['lang'],
                'land_size' => $data['land_size'] ?? null,
                'land_value' => $data['land_value'] ?? null,
                'number_of_trees' => $data['number_of_trees'] ?? null,
                'term' => $data['term'] ?? null,
                'number_of_trees' => $data['number_of_trees'] ?? null,
                'tree_brand_id' => $data['tree_brand_id'] ?? null
            ];
            $record = $this->userPackageRepositoryInterface->add($userPackage);
            $code = $this->generateCode($record);
            $this->userPackageRepositoryInterface->update($record->id, ['job_code' => $code]);
            $record = $this->userPackageRepositoryInterface->find($record->id);

            /* package timeline records create */
            $this->packageTimelineService->addInitialRecords($record->id);

            /* customer create */
            $customer = $this->customerService->firstOrCreate($data['nic'], $data);

            /* bank account create */
            $bankAccountDetails = [
                'bank_id' => $data['beneficiary']['bank_id'],
                'account_number' => $data['beneficiary']['account_number'],
                'branch_name' => $data['beneficiary']['branch_name'] ?? null
            ];

            $bankAccount =  $this->bankAccountService->add($bankAccountDetails);

            /* package customer details create */
            $data['customer_id'] = $customer->id;
            $data['bank_account_id'] = $bankAccount->id;
            $this->packageCustomerDetailService->addOrUpdate($record->id, $data);

            /* beneficiary create or updae*/
            $this->stakeholderService->addBeneficiary($record->id, $data);

            /* nominee create / update or delete old */
            $this->stakeholderService->addNominees($record->id, $data);

            /* introducer create or update*/
            $this->stakeholderService->updateOrCreateIntroducer($record->id, $data);
            DB::commit();
            return $record;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function generateCode(UserPackage $userPackage)
    {
        $planCode =  $userPackage->plan->code;
        $branchCode =  $userPackage->branch->branch_code;
        return "CGLP-" . $planCode . "-" . $branchCode."-".str_pad($userPackage->id, 6, '0', STR_PAD_LEFT);
    }
}
