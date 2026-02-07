<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Coupon extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit',
        'usage_limit_per_user',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the usage records for the coupon.
     */
    public function usage()
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Get the orders using this coupon.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if coupon is valid.
     */
    public function isValid($subtotal = 0, $userId = null)
    {
        // Check if active
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'الكوبون غير نشط'];
        }

        // Check date range
        if ($this->start_date && now()->lt($this->start_date)) {
            return ['valid' => false, 'message' => 'الكوبون لم يبدأ بعد'];
        }
        if ($this->end_date && now()->gt($this->end_date)) {
            return ['valid' => false, 'message' => 'الكوبون منتهي الصلاحية'];
        }

        // Check usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'تم استخدام الكوبون الحد الأقصى من المرات'];
        }

        // Check minimum order amount
        if ($this->min_order_amount && $subtotal < $this->min_order_amount) {
            return ['valid' => false, 'message' => "الحد الأدنى للطلب هو {$this->min_order_amount} جنيه"];
        }

        // Check per-user limit
        if ($userId && $this->usage_limit_per_user) {
            $userUsageCount = $this->usage()->where('user_id', $userId)->count();
            if ($userUsageCount >= $this->usage_limit_per_user) {
                return ['valid' => false, 'message' => 'لقد استخدمت هذا الكوبون الحد الأقصى من المرات'];
            }
        }

        return ['valid' => true, 'message' => 'الكوبون صالح'];
    }

    /**
     * Calculate discount amount.
     */
    public function calculateDiscount($subtotal)
    {
        if ($this->discount_type === 'percentage') {
            $discount = $subtotal * ($this->discount_value / 100);
        } else {
            $discount = $this->discount_value;
        }

        // Apply max discount limit
        if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
            $discount = $this->max_discount_amount;
        }

        return min($discount, $subtotal);
    }

    /**
     * Scope for active coupons.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for valid coupons (active and within date range).
     */
    public function scopeValid($query)
    {
        return $query->active()
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>=', now());
            });
    }
}
