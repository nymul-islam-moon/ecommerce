<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributesRequest;
use App\Http\Requests\UpdateAttributesRequest;
use App\Models\Attribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attribute::paginate(10);
        return view('admin.products.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributesRequest $request)
    {
        $formData = $request->validated();        
        DB::beginTransaction();
        
        try {

            // Create slug for the attribute
            $formData['slug'] = Str::slug($formData['name']);

            Attribute::create($formData);
            DB::commit();
            return redirect()->route('admin.attributes.index')->with('success', 'Attribute created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to create attribute: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        // here attributes will comes with attribute values
        $attribute->load('values');
        return view('admin.products.attributes.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {

        return view('admin.products.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributesRequest $request, Attribute $attribute)
    {
        $formData = $request->validated();
        DB::beginTransaction();
        try {
            // Update slug for the attribute
            $formData['slug'] = Str::slug($formData['name']);
            
            $attribute->update($formData);
            DB::commit();
            return redirect()->route('admin.attributes.index')->with('success', 'Attribute updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to update attribute: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        DB::beginTransaction();

        try {
            $attribute->delete();
            DB::commit();
            return redirect()->route('admin.attributes.index')->with('error', 'Attribute deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to delete attribute: ' . $e->getMessage()]);
        }
    }
}
