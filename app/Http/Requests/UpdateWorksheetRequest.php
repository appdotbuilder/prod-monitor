<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorksheetRequest extends FormRequest
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
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'production_type' => 'nullable|in:internal,fob',
            'status' => 'sometimes|in:pending,approved,rejected',
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
            'product_name.required' => 'Product name is required.',
            'production_type.in' => 'Production type must be either internal or FOB.',
            'status.in' => 'Status must be pending, approved, or rejected.',
        ];
    }
}