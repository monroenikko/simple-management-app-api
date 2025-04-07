<?php

namespace App\Http\Requests\Task;

use App\Models\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskStoreRequest extends FormRequest
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
            'title' => 'required|max:100',
            'content' => 'required',
            'status_id' => ['required', Rule::in(Status::pluck('id')->toArray())],
            'is_draft' => ['required', 'boolean'],
            'is_published' => ['required', 'boolean'],
            'images' => ['sometimes', 'array'],
            'images.*' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],
        ];
    }
}
