<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateChildCategoryRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('child_categories')
                    ->where(function ($query) {
                        return $query->where('subcategory_id', $this->input('subcategory_id'));
                    })
                    ->ignore($this->route('childcategory')->id),
            ],
            'description' => 'nullable|string',
            'subcategory_id' => 'required|exists:sub_categories,id',
        ];
    }
}
