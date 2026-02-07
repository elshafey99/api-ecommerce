<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class WalletTransaction extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'user_id',
        'order_id',
        'type',
        'amount',
        'balance_after',
        'reason',
        'description',
        'reference_number',
        'created_by',
    ];

    public $translatable = ['description'];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    // Transaction types
    const TYPE_CREDIT = 'credit';
    const TYPE_DEBIT = 'debit';

    // Reasons
    const REASON_ORDER_PAYMENT = 'order_payment';
    const REASON_REFUND = 'refund';
    const REASON_ADMIN_ADJUSTMENT = 'admin_adjustment';
    const REASON_RECHARGE = 'recharge';

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
            'credit' => 'إيداع',
            'debit' => 'سحب',
        ][$this->type] ?? $this->type;
    }

    /**
     * Get reason label in Arabic.
     */
    public function getReasonLabelAttribute()
    {
        return [
            'order_payment' => 'دفع طلب',
            'refund' => 'استرجاع',
            'admin_adjustment' => 'تعديل إداري',
            'recharge' => 'شحن رصيد',
        ][$this->reason] ?? $this->reason;
    }

    /**
     * Scope for credits.
     */
    public function scopeCredits($query)
    {
        return $query->where('type', self::TYPE_CREDIT);
    }

    /**
     * Scope for debits.
     */
    public function scopeDebits($query)
    {
        return $query->where('type', self::TYPE_DEBIT);
    }
}
