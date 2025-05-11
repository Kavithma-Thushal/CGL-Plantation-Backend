<?php

namespace App\Repositories\Quotation;

use App\Models\Quotation;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Collection;

class QuotationRepository extends CrudRepository implements QuotationRepositoryInterface
{

    public function __construct(Quotation $model)
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
            $query->whereHas('quotationRequest', function ($query) use ($filters) {
                $query->where('employee_branch_id', $filters['branch_id']);
            });
        }


        return $query->get();
    }
}
