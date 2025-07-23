<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            // Basic Info
            'name' => 'required|string|max:255|unique:products,name',
            'sku' => 'nullable|string|max:100',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',

            // Pricing & Inventory
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'stock_quantity' => 'nullable|integer|min:0',

            // Category & Brand
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'child_category_id' => 'nullable|exists:child_categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive,out_of_stock,discontinued',
            'is_featured' => 'required|boolean',

            // Product Images
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',

            // Attributes
            'attribute_values' => 'nullable|array',
            'attribute_values.*' => 'nullable|exists:attribute_values,id',
        ];
    }
}
