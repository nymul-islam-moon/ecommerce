<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttributeValueRequest extends FormRequest
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
        // here use the attribute_id for the attribute this value belongs to and the attribute value will be unique within that attribute
        return [
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255|unique:attribute_values,value,NULL,id,attribute_id,' . $this->attribute_id,
        ];
    }
}
