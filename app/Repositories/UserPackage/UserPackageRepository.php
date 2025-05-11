<?php

namespace App\Repositories\UserPackage;

use App\Models\UserPackage;
use App\Models\PackageStatus;
use App\Enums\PackageStatusesEnum;
use App\Repositories\CrudRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class UserPackageRepository extends CrudRepository implements UserPackageRepositoryInterface
{

    public function __construct(UserPackage $model)
    {
        parent::__construct($model);
    }

    public function getPaginate(array $filters = [], array $relations = [],array $sortBy = [])
    {
        $query =  UserPackage::query();
        $query = $this->applyFilters($query, $filters, $relations);
        $query->latest();
        return $query->paginate(request('ppg') ?? 10);
    }
   
    public function getAll(array $filters = [], array $relations = [],array $sortBy = []): Collection
    {
        $query =  UserPackage::query();
        $query = $this->applyFilters($query, $filters, $relations);
        $query->latest();
        return $query->get();
    }

    public function getPaymentPending(array $filters = [], array $relations = []): Collection
    {
        // Apply initial query with filters and relations
        $query = UserPackage::query()
            ->with(['packageTimeline.packageStatus', 'receipts'])
            ->whereHas('packageTimeline.packageStatus', function ($q) {
                $q->where('name', PackageStatusesEnum::SIGNED);
            })
            ->whereDoesntHave('packageTimeline.packageStatus', function ($q) {
                $q->whereIn('name', [PackageStatusesEnum::MATURED, PackageStatusesEnum::CANCELLED]);
            });

        $query = $this->applyFilters($query, $filters, $relations);

        // Retrieve the filtered collection
        $userPackages = $query->get();

        // Filter for payment pending
        return $userPackages->filter(function ($item) {
            $netTotal = $item->total_amount;
            $paidTotal = $item->receipts()->sum('amount');
            if (round($netTotal, 2) - round($paidTotal, 2) > 0) {
                return $item;
            }
        });
    }


    private function applyFilters($query, $filters, $relations)
    {
        if (isset($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }
        if (isset($filters['created_user_id'])) {
            $query->where('created_user_id', $filters['created_user_id']);
        }
        if (isset($filters['supervisor_employee_id'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->whereHas('employee', function ($q) use ($filters) {
                    $q->whereHas('employeeDesignations', function ($q) use ($filters) {
                        $q->where('reporting_person_id', $filters['supervisor_employee_id']);
                    });
                });
            });
        }
        if (isset($filters['has_status'])) {
            $query->whereHas('packageTimeline', function ($q) use ($filters) {
                $q->whereHas('packageStatus', function ($q) use ($filters) {
                    $q->where('name', $filters['status']);
                });
            });
        }
        if (isset($filters['has_not_status'])) {
            $query->whereHas('packageTimeline', function ($q) use ($filters) {
                $q->whereHas('packageStatus', function ($q) use ($filters) {
                    $q->where('name', $filters['status']);
                });
            });
        }
        return $query;
    }
}
