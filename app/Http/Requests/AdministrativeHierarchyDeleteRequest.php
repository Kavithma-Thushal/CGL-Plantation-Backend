<?php

namespace App\Http\Requests;

use App\Classes\ErrorResponse;
use App\Models\AdministrativeHierarchy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Services\AdministrativeLevelService;
use Illuminate\Support\Facades\DB;

class AdministrativeHierarchyDeleteRequest extends FormRequest
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
        $validator->after(function ($validator) {
            if (!$this->isExists()) {
                $validator->errors()->add(config('common.generic_error'), 'Invalid id');
            } elseif ($this->hasChildren() || $this->hasBranchReferences()) {
                $validator->errors()->add(config('common.generic_error'), 'Administrative level cannot be deleted because it has associated child records or branches.');
            }
        });
    }

    private function isExists(): bool
    {
        return AdministrativeHierarchy::where('id', $this->id)->exists();
    }

    private function hasChildren(): bool
    {
        $administrativeHierarchy = AdministrativeHierarchy::find($this->id);
        return $administrativeHierarchy && ($administrativeHierarchy->branches()->exists() || $administrativeHierarchy->hasChildren());
    }

    private function hasBranchReferences(): bool
    {
        return DB::table('branches')->where('administrative_hierarchy_id', $this->id)->exists();
    }
}
