<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Branch extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'whatsapp',
        'email',
        'latitude',
        'longitude',
        'working_hours',
        'delivery_fee',
        'min_order_amount',
        'free_delivery_threshold',
        'is_active',
        'is_main',
        'sort_order',
    ];

    public $translatable = ['name', 'address'];

    protected $casts = [
        'working_hours' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'delivery_fee' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'free_delivery_threshold' => 'decimal:2',
        'is_active' => 'boolean',
        'is_main' => 'boolean',
    ];

    /**
     * Get the orders for the branch.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Calculate delivery fee based on order amount.
     */
    public function calculateDeliveryFee($orderAmount)
    {
        if ($this->free_delivery_threshold && $orderAmount >= $this->free_delivery_threshold) {
            return 0;
        }
        return $this->delivery_fee;
    }

    /**
     * Scope for active branches.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for main branch.
     */
    public function scopeMain($query)
    {
        return $query->where('is_main', true);
    }

    /**
     * Scope for ordered branches.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
