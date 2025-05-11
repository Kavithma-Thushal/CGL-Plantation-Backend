<?php

namespace App\Http\Services;

use App\Classes\CodeGenerator;
use App\Models\Employee;
use App\Enums\EmployeeStatusEnum;
use App\Repositories\Branch\BranchRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\EmployeeBranch\EmployeeBranchRepositoryInterface;
use App\Repositories\EmployeeDesignation\EmployeeDesignationRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class EmployeeService
{
    public function __construct(
        private UserService                            $userService,
        private PersonalDetailService                  $personalDetailService,
        private EmployeeRepositoryInterface            $employeeRepositoryInterface,
        private EmployeeBankDetailService              $employeeBankDetailService,
        private EmployeeDesignationRepositoryInterface $employeeDesignationRepositoryInterface,
        private EmployeeBranchRepositoryInterface      $employeeBranchRepositoryInterface,
        private BranchRepositoryInterface              $branchRepositoryInterface,
        private EmployeeDesignationService             $employeeDesignationService,
        private EmployeeBranchService                  $employeeBranchService,
    )
    {
    }

    public function add(array $data): Employee
    {
        DB::beginTransaction();
        try {
            $user = $this->userService->add($data);
            $employee = $this->addEmployee($user->id, $data);
            $this->personalDetailService->add($employee->id, Employee::class, $data);
            $this->employeeBankDetailService->add($employee->id, $data);
            $this->employeeDesignationService->add($employee->id, $data);
            $this->updateEmployeeCode($employee->id);
            $this->employeeBranchService->add($employee->id, $data['operating_branches']);
            $this->updateCurrentBranch($employee->id, $data['base_branch_id']);
            DB::commit();
            return $employee;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // select the base branch as the default operating branch.
    private function updateCurrentBranch(int $employeeId, int $branchId)
    {
        $employeeBranch = $this->employeeBranchService->firstOrCreate($employeeId, $branchId);
        $this->employeeRepositoryInterface->update($employeeId, ['current_employee_branch_id' => $employeeBranch->id]);
    }

    //create and update employee branch code
    public function updateEmployeeCode(int $employeeId)
    {
        $employeeDesignation = $this->employeeDesignationRepositoryInterface->findActiveByEmployeeId($employeeId);
        if ($employeeDesignation == null) return null;
        $employee = $this->employeeRepositoryInterface->find($employeeId);
        $employeeEpf = $employee->epf_number;
        $branchCode = $this->branchRepositoryInterface->find($employeeDesignation->base_branch_id)->branch_code;
        $employeeBranchCode = CodeGenerator::generateEmployeeCode($employeeEpf, $branchCode);
        $this->employeeRepositoryInterface->update($employeeId, ['employee_code' => $employeeBranchCode]);
        $this->employeeDesignationRepositoryInterface->update($employeeId, ['employee_code' => $employeeBranchCode]);
    }

    public function update(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            $employee = $this->employeeRepositoryInterface->find($id);
            $user = $employee->user;

            // Check if password_reset_at is null or not
            if ($user->password_reset_at === null) {
                $this->userService->update($user->id, $data);
            } else {
                $dataWithoutPassword = $data;
                unset($dataWithoutPassword['password']);
                $this->userService->update($user->id, $dataWithoutPassword);
            }

            $employee = $this->updateEmployee($id, $data);
            $this->personalDetailService->add($id, Employee::class, $data);
            $this->employeeBankDetailService->add($id, $data);
            $this->employeeDesignationService->add($id, $data);
            $this->updateEmployeeCode($id);
            $this->employeeBranchService->add($id, $data['operating_branches']);
            $this->updateCurrentBranch($id, $data['base_branch_id']);

            DB::commit();
            return $employee;
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function changeAuthUserCurrentBranch(int $employeeBranchId)
    {
        $this->employeeRepositoryInterface->update(Auth::user()->employee->id, ['current_employee_branch_id' => $employeeBranchId]);
        return $this->employeeBranchService->getBranchesForEmployee(Auth::user()->employee->id);
    }

    private function updateEmployee($employeeId, $data)
    {
        $employeeData = [
            'epf_number' => $data['epf_number'],
            'commenced_date' => $data['commenced_date'],
            'email' => $data['email'] ?? null,
        ];
        return $this->employeeRepositoryInterface->update($employeeId, $employeeData);
    }

    private function addEmployee($userId, $data)
    {
        $employeeData = [
            'user_id' => $userId,
            'epf_number' => strtoupper($data['epf_number']),
            'commenced_date' => $data['commenced_date'],
            'status' => EmployeeStatusEnum::ACTIVE,
            'email' => $data['email'] ?? null,
        ];
        return $this->employeeRepositoryInterface->add($employeeData);
    }

    public function delete(int $id): void
    {
        DB::beginTransaction();
        try {
            $this->employeeRepositoryInterface->update($id, ['current_employee_branch_id' => null]);
            $this->employeeBranchRepositoryInterface->deleteByEmployee($id);
            $this->employeeDesignationRepositoryInterface->deleteByEmployee($id);
            $this->employeeBankDetailService->deleteByEmployee($id);
            $this->employeeRepositoryInterface->delete($id);
            DB::commit();
        } catch (HttpException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getAll(array $filters)
    {
        return $this->employeeRepositoryInterface->getAll($filters);
    }

    public function getByMobile($mobile)
    {
        return $this->employeeRepositoryInterface->getByMobile($mobile);
    }

    public function getByNIC($nic)
    {
        return $this->employeeRepositoryInterface->getByNIC($nic);
    }

    public function getById($id)
    {
        return $this->employeeRepositoryInterface->find($id);
    }

    public function getByUserId($id)
    {
        return $this->employeeRepositoryInterface->getByUserId($id);
    }
}
