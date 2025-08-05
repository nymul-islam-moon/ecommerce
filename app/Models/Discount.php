<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Discount extends Model
{
    protected $fillable = [
        'title',
        'type',
        'discount_type',
        'amount',
        'buy_quantity',
        'get_quantity',
        'free_product_id',
        'coupon_code',
        'start_date',
        'end_date',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Products linked to this discount
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'discount_products');
    }

    /**
     * Users linked to this discount
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'discount_users');
    }

    /**
     * Free product for BOGO
     */
    public function freeProduct()
    {
        return $this->belongsTo(Product::class, 'free_product_id');
    }

    /**
     * Check if discount is currently active & within date range
     */
    public function isValid(): bool
    {
        $now = Carbon::now();
        return $this->active && $now->between($this->start_date, $this->end_date);
    }

    /**
     * Apply discount to a price
     */
    public function applyDiscount(float $originalPrice): float
    {
        if (!$this->isValid() || !$this->discount_type || !$this->amount) {
            return $originalPrice;
        }

        if ($this->discount_type === 'percent') {
            return max(0, $originalPrice - ($originalPrice * ($this->amount / 100)));
        }

        if ($this->discount_type === 'fixed') {
            return max(0, $originalPrice - $this->amount);
        }

        return $originalPrice;
    }
}
