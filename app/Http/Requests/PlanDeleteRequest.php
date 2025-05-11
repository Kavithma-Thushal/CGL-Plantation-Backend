<?php

namespace App\Http\Requests;

use App\Models\Plan;
use App\Classes\ErrorResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Services\AdministrativeLevelService;

class PlanDeleteRequest extends FormRequest
{
    public function __construct(private AdministrativeLevelService $service)
    {
    }

    protected function failedValidation(Validator $validator)
    {
        ErrorResponse::validationError($validator);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) return;
        $validator->after(function ($validator) {
            $hasChildren = $this->hasChildren();
            if (!$this->isExists()) $validator->errors()->add(config('common.generic_error'), 'Invalid id');
            if ( $hasChildren != null) $validator->errors()->add(config('common.generic_error'), $hasChildren);
        });
    }

    private function isExists()
    {
        return Plan::where('id', $this->id)->exists();
    }

    private function hasChildren() : ?string
    {
        if ($this->isExists()) {
            $plan = Plan::find($this->id);
            if($plan->userPackages()->exists()) return 'The plan cannot be deleted because there are user packages associated with it';
            if($plan->quotations()->exists()) return 'The plan cannot be deleted because there are quotations associated with it';
            // do not check plan benefits relation here. that need to be deleted when delete the plan
        }
        return null;
    }
}
