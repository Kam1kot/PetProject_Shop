<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
        $orderId = $this->route('order')?->id;

        return [
            'user_id' => ['nullable', 'exists:users,id'],
            'order_number' => ['required', 'integer'],
            'status' => ['required', 'string', Rule::in(['ожидание','в процессе','завершено','отменено'])],
            'payment_status' => ['required', 'string', Rule::in(['ожидание','успешно','провалено','возврат'])],
            'delivery_status' => ['required', 'string', Rule::in(['ожидание','отправленный','доставлен','отменено'])],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'delivery_method' => ['required', 'string', 'max:100'],
            'payment_method' => ['required', 'string', 'max:100'],
            'delivery_city' => ['required', 'string', 'max:100'],
            'delivery_address' => ['required', 'string', 'max:255'],
            'delivery_postal_code' => ['required', 'string', 'max:20'],
            'comment' => ['nullable', 'string'],
            'subtotal' => ['required', 'numeric', 'min:0'],
            'discount_amount' => ['required', 'numeric', 'min:0'],
            'delivery_amount' => ['required', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
        ];
    }
}
