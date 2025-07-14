<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributesRequest;
use App\Http\Requests\UpdateAttributesRequest;
use App\Models\Attributes;
use Illuminate\Support\Facades\DB;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = Attributes::paginate(10);
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
            Attributes::create($formData);
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
    public function show(Attributes $attributes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attributes $attributes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributesRequest $request, Attributes $attributes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attributes $attributes)
    {
        //
    }
}
