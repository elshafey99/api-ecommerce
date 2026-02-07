<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class PointsTransaction extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'user_id',
        'order_id',
        'type',
        'points',
        'balance_after',
        'reason',
        'description',
        'expiry_date',
        'created_by',
    ];

    public $translatable = ['description'];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    // Transaction types
    const TYPE_EARNED = 'earned';
    const TYPE_REDEEMED = 'redeemed';
    const TYPE_EXPIRED = 'expired';
    const TYPE_ADJUSTMENT = 'adjustment';

    // Reasons
    const REASON_ORDER_COMPLETION = 'order_completion';
    const REASON_REDEMPTION = 'redemption';
    const REASON_REFERRAL = 'referral';
    const REASON_ADMIN_ADJUSTMENT = 'admin_adjustment';
    const REASON_EXPIRED = 'expired';

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the admin who created this transaction.
     */
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Get type label in Arabic.
     */
    public function getTypeLabelAttribute()
    {
        return [
            'earned' => 'مكتسبة',
            'redeemed' => 'مستخدمة',
            'expired' => 'منتهية',
            'adjustment' => 'تعديل',
        ][$this->type] ?? $this->type;
    }

    /**
     * Scope for earned points.
     */
    public function scopeEarned($query)
    {
        return $query->where('type', self::TYPE_EARNED);
    }

    /**
     * Scope for redeemed points.
     */
    public function scopeRedeemed($query)
    {
        return $query->where('type', self::TYPE_REDEEMED);
    }

    /**
     * Scope for non-expired points.
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expiry_date')->orWhere('expiry_date', '>=', now());
        });
    }
}
