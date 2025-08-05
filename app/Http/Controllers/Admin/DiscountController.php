<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display all discounts
     */
    public function index()
    {
        $discounts = Discount::with(['products', 'users'])->latest()->paginate(10);
        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $products = Product::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();
        return view('admin.discounts.create', compact('products', 'users'));
    }

    /**
     * Store new discount
     */
    public function store(Request $request)
    {
        $data = $this->validateDiscount($request);

        $discount = Discount::create($data);

        // Sync products & users
        $discount->products()->sync($request->products ?? []);
        $discount->users()->sync($request->users ?? []);

        return redirect()->route('admin.discounts.index')->with('success', 'Discount created successfully.');
    }

    /**
     * Show edit form
     */
    public function edit(Discount $discount)
    {
        $products = Product::select('id', 'name')->get();
        $users = User::select('id', 'name')->get();

        // Load relationships
        $discount->load(['products', 'users']);

        return view('admin.discounts.edit', compact('discount', 'products', 'users'));
    }

    /**
     * Update discount
     */
    public function update(Request $request, Discount $discount)
    {
        $data = $this->validateDiscount($request);

        $discount->update($data);

        // Sync products & users
        $discount->products()->sync($request->products ?? []);
        $discount->users()->sync($request->users ?? []);

        return redirect()->route('admin.discounts.index')->with('success', 'Discount updated successfully.');
    }

    /**
     * Delete discount
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discounts.index')->with('success', 'Discount deleted successfully.');
    }

    /**
     * Validation logic for create/update
     */
    private function validateDiscount(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:product,cart,bogo,bulk',
            'discount_type' => 'nullable|in:fixed,percent',
            'amount' => 'nullable|numeric',
            'buy_quantity' => 'nullable|integer|min:1',
            'get_quantity' => 'nullable|integer|min:1',
            'free_product_id' => 'nullable|exists:products,id',
            'coupon_code' => 'nullable|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'products' => 'nullable|array',
            'products.*' => 'exists:products,id',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);
    }
}
