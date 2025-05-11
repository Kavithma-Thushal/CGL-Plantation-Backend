<?php

namespace App\Repositories\PackageTimeline;

use App\Repositories\CrudRepositoryInterface;

interface PackageTimelineRepositoryInterface extends CrudRepositoryInterface
{
    public function deactivateOldRecords(int $packageId) : void;
}