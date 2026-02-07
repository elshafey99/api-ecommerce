<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'order_status_history';

    protected $fillable = [
        'order_id',
        'admin_id',
        'from_status',
        'to_status',
        'notes',
    ];

    /**
     * Get the order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the admin who made the change.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get from status label.
     */
    public function getFromStatusLabelAttribute()
    {
        return $this->getStatusLabel($this->from_status);
    }

    /**
     * Get to status label.
     */
    public function getToStatusLabelAttribute()
    {
        return $this->getStatusLabel($this->to_status);
    }

    /**
     * Get status label in Arabic.
     */
    private function getStatusLabel($status)
    {
        return [
            'pending' => 'قيد الانتظار',
            'confirmed' => 'مؤكد',
            'processing' => 'جاري التحضير',
            'ready' => 'جاهز',
            'out_for_delivery' => 'في الطريق',
            'delivered' => 'تم التوصيل',
            'cancelled' => 'ملغي',
            'refunded' => 'مسترجع',
        ][$status] ?? $status;
    }
}
