<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => 'required|string|min:10',
            'status' => 'required|in:created,in_progress,completed,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Поле заголовка обязательно.',
            'title.min' => 'Заголовок должен быть не короче 10 символов.',
            'status.required' => 'Статус обязателен.',
            'status.in' => 'Недопустимое значение статуса.',
        ];
    }
}
