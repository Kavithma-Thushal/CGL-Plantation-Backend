<?php

namespace App\Repositories\Receipt;

use App\Models\Receipt;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Collection;

class ReceiptRepository extends CrudRepository implements ReceiptRepositoryInterface
{
    public function __construct(Receipt $model)
    {
        parent::__construct($model);
    }

    public function getAll(array $filters = [],array $relations = [],array $sortBy = []): Collection
    {
        $query = Receipt::query();
        if(isset($filters['user_package_id'])){
            $query->where('user_package_id',$filters['user_package_id']);
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