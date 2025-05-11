<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProposalResource extends JsonResource
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
            'lang' => $this->lang,
            'agent_id'=>$this->agent_id,
            'job_code' => $this->job_code,
            'nic'=>$packageCustomerDetail->customer->user->nic,
            'email' => $packageCustomerDetail->email ?? null,
            'landline_number' => $packageCustomerDetail->landline_number ?? null,
            'mobile_number' => $packageCustomerDetail->mobile_number ?? null,
            'driving_license' => $packageCustomerDetail->customer->license_number ?? null,
            'passport_number' => $packageCustomerDetail->customer->passport_number ?? null,
            'occupation_id' => $packageCustomerDetail->occupation_id ?? null,
            'occupation_name' => $packageCustomerDetail->occupation->name ?? null,
            'race_id' => $packageCustomerDetail->race_id ?? null,
            'race_name' => $packageCustomerDetail->race->name ?? null,
            'nationality_id' => $packageCustomerDetail->nationality_id ?? null,
            'nationality_name' => $packageCustomerDetail->nationality->name ?? null,
            'country_id' => $packageCustomerDetail->country_id ?? null,
            'country_name' => $packageCustomerDetail->country->name ?? null,
            'branch_id' => $this->branch_id,
            'payment_mode' => $this->payment_mode,
            'bank_details' => [
                'bank_account_id' => $packageCustomerDetail->bank_account_id,
                'bank_id' => $packageCustomerDetail->bankAccount->bank_id,
                'bank_name' => $packageCustomerDetail->bankAccount->bank->name,
                'account_number' => $packageCustomerDetail->bankAccount->account_number,
                'branch_name' => $packageCustomerDetail->bankAccount->branch_name,
            ],
            'details_in_sinhala' => [
                'name_with_initial_si' => $packageCustomerDetail->name_with_initial_si,
                'family_name_si' => $packageCustomerDetail->family_name_si,
                'first_name_si' => $packageCustomerDetail->first_name_si,
                'middle_name_si' => $packageCustomerDetail->middle_name_si,
                'last_name_si' => $packageCustomerDetail->last_name_si,
                'address_si' => $packageCustomerDetail->address_si,
            ],
            'plan_details' => [
                'plan_id' => $this->plan_id,
                'plan_name' => $this->plan->name,
                'total_amount' => $this->total_amount,
                'land_size' => $this->land_size,
                'land_value' => $this->land_value,
                'term' => $this->term,
                'tree_brand_id' => $this->tree_brand_id,
                'tree_brand_name' => $this->treeBrand->name ?? null,
                'number_of_trees' => $this->number_of_trees
            ],
            'created_at'=>$this->created_at,
            'current_status'=> new PackageTimelineResource($activeStatus),
            'beneficiary' => new BeneficiaryResource($this->beneficiary),
            'nominees' => NomineeResource::collection($this->nominees),
            'introducer' => new IntroducerResource($this->introducer)
        ];
        return array_merge($data, $personalDetailRecord);
    }
}
