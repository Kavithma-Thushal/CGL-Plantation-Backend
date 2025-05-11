<?php

namespace App\Repositories\PackageTimeline;

use App\Models\PackageTimeline;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Collection;

class PackageTimelineRepository extends CrudRepository implements PackageTimelineRepositoryInterface
{
    public function __construct(PackageTimeline $model)
    {
        parent::__construct($model);
    }

    public function deactivateOldRecords(int $packageId) : void
    {
        $this->model->where('user_package_id',$packageId)->update(['status'=>0]);
    }

    public function getAll(array $filters = [],array $relations = [],array $sortBy = []): Collection
    {
        $query = PackageTimeline::query();
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