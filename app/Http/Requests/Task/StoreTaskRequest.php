<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1024'],
            'user_id' => ['required', 'int'],
            'category_id' => ['required', 'int', Rule::exists('categories', 'id')]
        ];
    }
}
