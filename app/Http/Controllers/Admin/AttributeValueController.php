<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use App\Models\AttributeValue;
use App\Models\Attribute;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($attributeId)
    {
        $attribute = Attribute::findOrFail($attributeId);
        return view('admin.products.attributes.values.create', compact('attribute'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeValueRequest $request)
    {
        $formData = $request->validated();

        try {
            $attributeValue = AttributeValue::create($formData);
            return redirect()->route('admin.attributes.show', $attributeValue->attribute_id)
                ->with('success', 'Attribute value created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create attribute value: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeValue $attributeValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttributeValue $attributeValue)
    {
        return view('admin.products.attributes.values.edit', compact('attributeValue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeValueRequest $request, AttributeValue $attributeValue)
    {
        $formData = $request->validated();

        try {
            $attributeValue->update($formData);
            return redirect()->route('admin.attributes.show', $attributeValue->attribute_id)
                ->with('success', 'Attribute value updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update attribute value: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttributeValue $attributeValue)
    {
        try {
            $attributeValue->delete();
            return redirect()->route('admin.attributes.show', $attributeValue->attribute_id)
                ->with('success', 'Attribute value deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete attribute value: ' . $e->getMessage()]);
        }
    }
}
