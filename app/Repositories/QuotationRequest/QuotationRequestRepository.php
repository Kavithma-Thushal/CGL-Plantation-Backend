<?php

namespace App\Repositories\QuotationRequest;

use App\Models\QuotationRequest;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Collection;

class QuotationRequestRepository extends CrudRepository implements QuotationRequestRepositoryInterface
{

    public function __construct(QuotationRequest $model)
    {
        parent::__construct($model);
    }

    public function getAll(array $filters = [], array $relations = [], array $sortBy = []): Collection
    {
        $query = $this->model->query();

        if (!empty($relations)) {
            $query->with($relations);
        }

        if (isset($filters['branch_id'])) {
            $query->where('employee_branch_id', $filters['branch_id']);
        }


        return $query->get();
    }
}
