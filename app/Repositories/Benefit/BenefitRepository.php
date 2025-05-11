<?php

namespace App\Repositories\Benefit;

use App\Models\Benefit;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Collection;

class BenefitRepository extends CrudRepository implements BenefitRepositoryInterface
{
    public function __construct(Benefit $model)
    {
        parent::__construct($model);
    }

    public function getAll(array $filters = [], array $relations = [],array $sortBy = []): Collection
    {
        $query = Benefit::query();
        if(isset($filters['user_package_id'])){
            $query->where('user_package_id',$filters['user_package_id']);
        }
        if(isset($filters['payment_status']) && $filters['payment_status'] == 'PAID'){
            $query->whereNotNull('paid_at');
        }
        if(isset($filters['payment_status']) && $filters['payment_status'] == 'UNPAID'){
            $query->whereNull('paid_at');
        }
        return $query->get();
    }
}