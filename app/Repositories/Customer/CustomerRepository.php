<?php

namespace App\Repositories\Customer;

use App\Models\Customer;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Collection;

class CustomerRepository extends CrudRepository implements CustomerRepositoryInterface
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }

    public function getAll(array $filters = [], array $relations = [], array $sortBy = []): Collection
    {
        $query = $this->model->query();

        // Filtering logic here
        if (isset($filters['first_name'])) {
            $query->whereHas('personalDetails', function ($q) use ($filters) {
                $q->where('first_name', 'like', '%' . $filters['first_name'] . '%')->active();
            });
        }
        if (isset($filters['nic'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('nic', $filters['nic']);
            });
        }
        if (isset($filters['customer_number'])) {
            $query->where('customer_number', $filters['customer_number']);
        }

        return $query->get();
    }
}
