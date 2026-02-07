<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'question',
        'answer',
        'category',
        'is_active',
        'sort_order',
    ];

    public $translatable = ['question', 'answer'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // FAQ categories
    const CATEGORY_ORDERS = 'orders';
    const CATEGORY_SHIPPING = 'shipping';
    const CATEGORY_PAYMENT = 'payment';
    const CATEGORY_RETURNS = 'returns';
    const CATEGORY_GENERAL = 'general';

    /**
     * Get category label in Arabic.
     */
    public function getCategoryLabelAttribute()
    {
        return [
            'orders' => 'الطلبات',
            'shipping' => 'الشحن والتوصيل',
            'payment' => 'الدفع',
            'returns' => 'الاسترجاع',
            'general' => 'عام',
        ][$this->category] ?? $this->category;
    }

    /**
     * Scope for active FAQs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for ordered FAQs.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
