<?php

namespace App\Repositories\Employee;

use App\Models\Employee;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository extends CrudRepository implements EmployeeRepositoryInterface
{
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    public function getByNIC(string $nic): ?object
    {
        return Employee::whereHas('user', function ($q) use ($nic) {
            $q->where('nic', $nic);
        })->first();
    }

    public function getByUserId(string $userId): ?object
    {
        return Employee::where('user_id', $userId)->first();
    }

    public function getByMobile(string $mobile): ?object
    {
        return Employee::whereHas('personalDetails', function ($q) use ($mobile) {
            $q->where('mobile_number', $mobile)->where('status',1);
        })->first();
    }

    public function getAll(array $filters = [], array $relations = [],array $sortBy = []): Collection
    {
        $query = $this->model->query();

        if(isset($filters['branch_id'])){
            $query->where('current_employee_branch_id', $filters['branch_id']);
        }

        if (isset($filters['username'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('username', $filters['username']);
            });
        }

        if (isset($filters['name'])) {
            $query->whereHas('personalDetails', function ($q) use ($filters) {
                $q->where('first_name', 'ilike', '%' . $filters['name'] . '%')->where('status',1);;
            });
        }

        if (isset($filters['nic'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('nic', $filters['nic']);
            });
        }

        if (isset($filters['employee_code'])) {
            $query->where('employee_code', $filters['employee_code']);
        }

        if (isset($filters['mobile_number'])) {
            $query->whereHas('personalDetails', function ($q) use ($filters) {
                $q->where('mobile_number', 'ilike', '%' . $filters['mobile_number'] . '%')->where('status',1);;
            });
        }


        return $query->get();
    }
}
