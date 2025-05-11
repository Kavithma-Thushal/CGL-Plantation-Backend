<?php

namespace App\Http\Services;

use App\Models\PersonalDetails;
use App\Repositories\PersonalDetails\PersonalDetailsRepositoryInterface;
use Illuminate\Support\Facades\Log;

class PersonalDetailService
{
    public function __construct(
        private PersonalDetailsRepositoryInterface $personalDetailsRepositoryInterface
    ) {
    }

    public function add(int $modelId, string $model, array $data): PersonalDetails
    {
        $this->personalDetailsRepositoryInterface->deactivateOldRecords($modelId,$model);
        $personalDetails = [
            'title_id' => $data['title_id'] ?? null,
            'userable_id' => $modelId,
            'userable_type' => $model,
            'name_with_initials' => $data['name_with_initials'] ?? null,
            'family_name' => $data['family_name'] ?? null,
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'address' => $data['address'] ?? null,
            'mobile_number' => $data['mobile_number'] ?? null,
            'status' => 1
        ];
        return $this->personalDetailsRepositoryInterface->add($personalDetails);
    }
}
