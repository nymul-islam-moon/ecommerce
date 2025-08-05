<?php

namespace App\Services;

use App\Models\Discount;

class DiscountService
{
    public function getActiveDiscounts()
    {
        return Discount::where('active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();
    }

    public function applyCartDiscount($cart, $coupon = null)
    {
        $discount = Discount::where('type', 'cart')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->when($coupon, fn($q) => $q->where('coupon_code', $coupon))
            ->first();

        if (!$discount) return $cart->total;

        if ($discount->discount_type === 'percent') {
            return $cart->total - ($cart->total * $discount->amount / 100);
        }

        return max(0, $cart->total - $discount->amount);
    }

    public function applyBogoDiscount($cart)
    {
        foreach ($cart->items as $item) {
            $discount = $item->product->discounts()
                ->where('type', 'bogo')
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->first();

            if ($discount && $item->quantity >= $discount->buy_quantity) {
                $cart->addFreeProduct($discount->free_product_id, $discount->get_quantity);
            }
        }
        return $cart;
    }
}
