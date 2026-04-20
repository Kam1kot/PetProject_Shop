<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => "required|string|min:3|max:255",
            'slug' => "required|string|min:3|max:255|unique:products,slug",
            'sku' => "required|string|min:3|max:255|unique:products,sku",

            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',

            'description' => 'string',

            'price' => "required|numeric|min:0",
            'old_price' => "required|numeric|min:0|ne:price",

            'quantity' => "required|min:0|numeric",
            'status' => "required|Rule:in(['В наличии', 'Не в наличии, Снят с производства'])",

            'is_new' => 'boolean',
            'is_hit' => 'boolean',

            'rating_avg' => "nullable|numeric|between:0,5",
            'review_count' => 'nullable|numeric',
            
            'published_at' => ['nullable', 'date']
        ];
    }
}
