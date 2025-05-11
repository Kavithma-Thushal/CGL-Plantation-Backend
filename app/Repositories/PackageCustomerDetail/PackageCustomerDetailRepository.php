<?php

namespace App\Repositories\PackageCustomerDetail;

use App\Models\PackageCustomerDetail;
use App\Repositories\CrudRepository;

class PackageCustomerDetailRepository extends CrudRepository implements PackageCustomerDetailRepositoryInterface
{
    public function __construct(PackageCustomerDetail $model)
    {
        parent::__construct($model);
    }
}