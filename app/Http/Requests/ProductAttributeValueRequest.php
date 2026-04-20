<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductAttributeValueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'attribute_id' => ['required', 'exists:attributes,id'],
            'attribute_value_id' => ['nullable', 'exists:attribute_values,id'],
            'value_text' => ['nullable', 'string'],
            'value_number' => ['nullable', 'numeric'],
        ];
    }
}
