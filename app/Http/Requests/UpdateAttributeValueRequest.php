<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAttributeValueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $attributeId = $this->input('attribute_id');
        $attributeValueId = $this->route('attributeValue')->id;

        return [
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique('attribute_values')
                    ->where(function ($query) use ($attributeId) {
                        return $query->where('attribute_id', $attributeId);
                    })
                    ->ignore($attributeValueId),
            ],
        ];
    }
}
