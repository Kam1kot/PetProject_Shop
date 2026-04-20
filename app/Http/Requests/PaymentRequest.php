<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
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
        $paymentId = $this->route('payment')?->id;

        return [
            'order_id' => ['required', 'exists:orders,id'],
            'provider' => ['required', 'string', 'max:255'],
            'method' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', Rule::in(['ожидание','оплачено','провалено','возврат'])],
            'transaction_id' => ['required', 'string', 'max:255', Rule::unique('payments')->ignore($paymentId)],
            'amount' => ['required', 'numeric', 'min:0'],
            'paid_at' => ['required', 'date'],
            'payload_json' => ['required', 'json'],
        ];
    }
}
