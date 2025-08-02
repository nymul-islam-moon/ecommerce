<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json($validator->errors(), 422));
    }


    public function rules(): array
    {
        return [
            // Basic Info
            'name'                  => ['required', 'string', 'max:255', 'unique:products,name'],
            'sku'                   => ['nullable', 'string', 'max:100', 'unique:products,sku'],
            'slug'                  => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'short_description'     => ['required', 'string', 'max:1000'],
            'description'           => ['nullable', 'string'],

            // // Product Type
            'product_type'          => ['required', Rule::in(['simple', 'variable'])],

            // Simple Product
            'price'                 => ['required_if:product_type,simple', 'nullable', 'numeric', 'min:0'], // in view you can see it Redular Price label
            'sale_price'            => ['nullable', 'numeric', 'min:0', 'lte:price'], // Same as sale price
            'stock_quantity'        => ['required_if:product_type,simple', 'nullable', 'integer', 'min:0'],
            'low_stock_threshold'   => ['nullable', 'numeric', 'min:0'],
            'weight'                => ['nullable', 'numeric', 'min:0'],
            'height'                => ['nullable', 'numeric', 'min:0'],
            'depth'                 => ['nullable', 'numeric', 'min:0'],
            'width'                 => ['nullable', 'numeric', 'min:0'],
            'main_image'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'gallery_images'        => ['nullable', 'array'],
            'gallery_images.*'      => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],

            // // Category & Brand
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'exists:sub_categories,id'],
            'child_category_id' => ['nullable', 'exists:child_categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'status' => ['required', Rule::in(['active', 'inactive', 'out_of_stock', 'discontinued'])],
            'is_featured' => ['required', 'boolean'],


            // Attributes (Variable Products)
            'attribute_values' => ['nullable', 'array'],
            'attribute_values.*' => ['nullable', 'exists:attribute_values,id'],

            // Variant Combinations (only if variable)
            'combinations' => ['required_if:product_type,variable', 'array'],
            'combinations.*.price' => ['required_with:combinations', 'numeric', 'min:0'],
            'combinations.*.sale_price' => ['nullable', 'numeric', 'min:0', 'lte:combinations.*.price'],
            'combinations.*.stock_quantity' => ['required_with:combinations', 'integer', 'min:0'],
            'combinations.*.sku' => ['nullable', 'string', 'max:100'],
            'combinations.*.weight' => ['nullable', 'numeric', 'min:0'],
            'combinations.*.height' => ['nullable', 'numeric', 'min:0'],
            'combinations.*.width' => ['nullable', 'numeric', 'min:0'],
            'combinations.*.depth' => ['nullable', 'numeric', 'min:0'],
            'combinations.*.main_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'combinations.*.gallery_images' => ['nullable', 'array'],
            'combinations.*.gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'combinations.*.gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}
