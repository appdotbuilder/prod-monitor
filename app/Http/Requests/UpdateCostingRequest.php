<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCostingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'material_cost' => 'required|numeric|min:0',
            'labor_cost' => 'required|numeric|min:0',
            'overhead_cost' => 'required|numeric|min:0',
            'approval_status' => 'sometimes|in:pending,production_approved,finance_approved,rejected',
            'approval_notes' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'material_cost.required' => 'Material cost is required.',
            'material_cost.numeric' => 'Material cost must be a valid number.',
            'material_cost.min' => 'Material cost cannot be negative.',
            'labor_cost.required' => 'Labor cost is required.',
            'labor_cost.numeric' => 'Labor cost must be a valid number.',
            'labor_cost.min' => 'Labor cost cannot be negative.',
            'overhead_cost.required' => 'Overhead cost is required.',
            'overhead_cost.numeric' => 'Overhead cost must be a valid number.',
            'overhead_cost.min' => 'Overhead cost cannot be negative.',
            'approval_status.in' => 'Invalid approval status.',
        ];
    }
}