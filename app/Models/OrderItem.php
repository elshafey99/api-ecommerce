<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class OrderItem extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_sku',
        'product_image',
        'unit_price',
        'sale_price',
        'quantity',
        'subtotal',
        'discount_amount',
        'total',
    ];

    public $translatable = ['product_name'];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Get the order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get effective price used in this order item.
     */
    public function getEffectivePriceAttribute()
    {
        return $this->sale_price ?? $this->unit_price;
    }
}
