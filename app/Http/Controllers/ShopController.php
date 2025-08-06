<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::withRelations()->paginate(12);
        return view('frontend.shop', compact('products'));
    }
}
