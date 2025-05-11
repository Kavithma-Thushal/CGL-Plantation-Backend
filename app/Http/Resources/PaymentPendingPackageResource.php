<?php

namespace App\Http\Resources;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentPendingPackageResource extends JsonResource
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
        $paidTotal = $this->receipts()->sum('amount');

        $data =  [
            'id' => $this->id,
            'job_code' => $this->job_code,
            'branch_id' => $this->branch_id,
            'due_amount' => round($this->total_amount - $paidTotal,2),
            'plan_details' => [
                'plan_id' => $this->plan_id,
                'plan_name' => $this->plan->name,
                'duration' => $this->plan->duration
            ],
            'last_payment_date'=> now(),
            'created_at' => $this->created_at,
            'current_status' => new PackageTimelineResource($activeStatus),
            'action_permissions'=> $this->action_permissions,
            'is_email'=> !empty($packageCustomerDetail->email)
        ];
        return array_merge($data, $personalDetailRecord);
    }
}
