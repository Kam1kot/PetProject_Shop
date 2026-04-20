<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryRequest extends FormRequest
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
        $deliveryId = $this->route('delivery')?->id;

        return [
            'order_id' => ['required', 'exists:orders,id'],
            'service_name' => ['required', 'string', 'max:255'],
            'tracking_number' => ['required', 'string', 'max:255', Rule::unique('deliveries')->ignore($deliveryId)],
            'status' => ['required', 'string', Rule::in(['ожидание','отправленный','в пути','доставлен','отменен'])],
            'shipped_at' => ['required', 'date'],
            'delivered_at' => ['required', 'date', 'after_or_equal:shipped_at'],
            'payload_json' => ['required', 'json'],
        ];
    }
}
