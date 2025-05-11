<?php

namespace App\Repositories\EmployeeBranch;

use App\Models\EmployeeBranch;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Collection;

class EmployeeBranchRepository extends CrudRepository implements EmployeeBranchRepositoryInterface
{
    public function __construct(EmployeeBranch $model)
    {
        parent::__construct($model);
    }

    public function deactivateUnRelatedRecords(int $employeeId, array $branchIds): void
    {
        $this->model->where('employee_id',$employeeId)->whereNotIn('branch_id',$branchIds)->update(['status'=>0]);
    }

    public function firstOrCreate(array $keys,array $values) : EmployeeBranch
    {
        return $this->model->firstOrCreate($keys,$values);
    }

    public function deleteByEmployee(int $employeeId): void
    {
        $this->model->where('employee_id',$employeeId)->delete();
    }

    public function getAll(array $filters = [],array $relations = [],array $sortBy = []): Collection
    {
        $query = EmployeeBranch::query();
        if(isset($filters['employee_id'])){
            $query->where('employee_id',$filters['employee_id']);
        }
        if(!empty($relations)){
            $query->with($relations);
        }
        if(!empty($sortBy)){
            foreach($sortBy as $column=>$direction){
                $query->orderBy($column,$direction);
            }
        }
        return $query->get();
    }
}
