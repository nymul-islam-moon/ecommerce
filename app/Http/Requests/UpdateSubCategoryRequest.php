<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubCategoryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValhiidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Ensure the name is unique within the same category, excluding the current subcategory
        return [
            'name' => 'required|string|max:255|unique:sub_categories,name,' . $this->route('subcategory')->id . ',id,category_id,' . $this->input('category_id'),
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}
