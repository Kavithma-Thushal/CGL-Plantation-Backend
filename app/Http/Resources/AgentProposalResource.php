<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentProposalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $personalDetailRecord = new PersonalDetailsResource($this->packageCustomerDetail->customer->personalDetails()->active()->first());
        $personalDetailRecord = $personalDetailRecord->toArray($request);

        $data =  [
            'id' => $this->id,
            // 'lang' => $this->lang,
            // 'email' => $this->packageCustomerDetail->email,
            // 'landline_number' => $this->packageCustomerDetail->landline_number,
            // 'mobile_number' => $this->packageCustomerDetail->mobile_number,
            // 'driving_license' => $this->packageCustomerDetail->customer->license_number,
            // 'passport_number' => $this->packageCustomerDetail->customer->passport_number,
            // 'occupation_id' => $this->packageCustomerDetail->occupation_id,
            // 'occupation_name' => $this->packageCustomerDetail->occupation->name,
            // 'race_id' => $this->packageCustomerDetail->race_id,
            // 'race_name' => $this->packageCustomerDetail->race->name,
            // 'nationality_id' => $this->packageCustomerDetail->nationality_id,
            // 'nationality_name' => $this->packageCustomerDetail->nationality->name,
            // 'country_id' => $this->packageCustomerDetail->country_id,
            // 'country_name' => $this->packageCustomerDetail->country->name,
            // 'bank_details' => [
            //     'bank_account_id' => $this->packageCustomerDetail->bank_account_id,
            //     'bank_id' => $this->packageCustomerDetail->bankAccount->bank_id,
            //     'bank_name' => $this->packageCustomerDetail->bankAccount->bank->name,
            //     'account_number' => $this->packageCustomerDetail->bankAccount->account_number,
            //     'branch_name' => $this->packageCustomerDetail->bankAccount->branch_name,
            // ],
            // 'details_in_sinhala' => [
            //     'name_with_initial_si' => $this->packageCustomerDetail->name_with_initial_si,
            //     'family_name_si' => $this->packageCustomerDetail->family_name_si,
            //     'first_name_si' => $this->packageCustomerDetail->first_name_si,
            //     'middle_name_si' => $this->packageCustomerDetail->middle_name_si,
            //     'last_name_si' => $this->packageCustomerDetail->last_name_si,
            //     'address_si' => $this->packageCustomerDetail->address_si,
            // ],
            'job_code' => $this->job_code,
            'branch_id' => $this->branch_id,
            'plan_details' => [
                'plan_id' => $this->plan_id,
                'plan_name' => $this->plan->name,
                'total_amount' => $this->total_amount,
                // 'land_size' => $this->land_size,
                // 'land_value' => $this->land_value,
                'term' => $this->term,
                // 'tree_brand_id' => $this->tree_brand_id,
                // 'tree_brand_name' => $this->treeBrand->name ?? null,
                // 'number_of_trees' => $this->number_of_trees,
            ],
            // 'beneficiary' => new BeneficiaryResource($this->beneficiary),
            // 'nominees' => NomineeResource::collection($this->nominees),
            // 'introducer' => new IntroducerResource($this->introducer),
            'created_at' => $this->created_at,
            'status' => $this->getActiveTimeline()->packageStatus->name
        ];
        return array_merge($data, $personalDetailRecord);
    }
}
