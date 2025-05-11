<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'plan_template_id' => $this->plan_template_id,
            'duration' => $this->duration,
            'minimum_amount' => $this->minimum_amount,
            'benefit_per_month' => $this->benefit_per_month,
            'profit_per_month' => $this->profit_per_month,
            'description' => $this->description,
            'code' => $this->code,
            'count' => $this->userPackages()->count()
        ];

        if (isset($this->planTemplate))
            $response['plan_template'] = new PlanTemplateResource($this->planTemplate);

        if (isset($this->planBenefitRates))
            $response['interest_rates'] = PlanBenefitRateResource::collection($this->planBenefitRates);

        return $response;
    }
}
