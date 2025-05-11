<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProposalGetAllResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $packageCustomerDetail = $this->packageCustomerDetail;
        $personalDetailRecord = new PersonalDetailsResource($packageCustomerDetail->customer->personalDetails()->active()->first());
        $personalDetailRecord = $personalDetailRecord->toArray($request);
        $activeStatus = $this->getActiveTimeline();

        $data =  [
            'id' => $this->id,
            'job_code' => $this->job_code,
            'branch_id' => $this->branch_id,
            'plan_details' => [
                'plan_id' => $this->plan_id,
                'plan_name' => $this->plan->name,
                'total_amount' => $this->total_amount,
            ],
            'created_at' => $this->created_at,
            'current_status' => new PackageTimelineResource($activeStatus),
            'action_permissions'=> $this->action_permissions
        ];
        return array_merge($data, $personalDetailRecord);
    }
}
