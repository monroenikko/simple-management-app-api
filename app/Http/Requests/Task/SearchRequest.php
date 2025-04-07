<?php

namespace App\Http\Requests\Task;

use App\Models\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
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
            'keyword' => ['string', 'max:100'],
            'status_id' => ['integer', Rule::in(Status::pluck('id')->toArray())],
            'per_page' => 'integer|min:1|max:100',
            'ordering' => ['string', Rule::in($this->getOrdering())],
            'field' => ['string', Rule::in('created_at', 'title')],
        ];
    }

    private function getOrdering()
    {
        return ['asc', 'desc'];
    }
}
