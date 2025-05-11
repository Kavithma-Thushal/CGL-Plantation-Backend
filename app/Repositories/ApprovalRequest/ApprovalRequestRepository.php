<?php

namespace App\Repositories\ApprovalRequest;

use App\Models\ApprovalRequest;
use App\Repositories\CrudRepository;

class ApprovalRequestRepository extends CrudRepository implements ApprovalRequestRepositoryInterface
{
    public function __construct(ApprovalRequest $model)
    {
        parent::__construct($model);
    }
}