<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => 'required|min:3|max:50',
            'email' => ['required','email',Rule::unique('users', 'email')->ignore($this->user)],
            'phone' => ['required','string','regex:/^\+?[0-9]{7,15}$/',Rule::unique('users', 'phone')->ignore($this->user)],
            'password' => 'required|min:6|confirmed',
            'is_active' => 'boolean'
        ];
    }
}
