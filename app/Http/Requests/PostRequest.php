<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
        $postId = $this->route('post')?->id;

        return [
            'author_id' => ['required', 'exists:users,id'],
            'category_id' => ['required', 'exists:post_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts')->ignore($postId),
            ],
            'content' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', Rule::in(['редактирование','опубликован','архивирован'])],
            'published_at' => ['required', 'date'],
            'views_count' => ['required', 'integer', 'min:0'],
        ];
    }
}
