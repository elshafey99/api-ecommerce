<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Banner extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'mobile_image',
        'link_type',
        'link_id',
        'external_url',
        'position',
        'start_date',
        'end_date',
        'is_active',
        'sort_order',
    ];

    public $translatable = ['title', 'subtitle'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Positions
    const POSITION_HOME_SLIDER = 'home_slider';
    const POSITION_HOME_BANNER = 'home_banner';
    const POSITION_CATEGORY_BANNER = 'category_banner';

    // Link types
    const LINK_TYPE_PRODUCT = 'product';
    const LINK_TYPE_CATEGORY = 'category';
    const LINK_TYPE_BRAND = 'brand';
    const LINK_TYPE_EXTERNAL = 'external';
    const LINK_TYPE_NONE = 'none';

    /**
     * Get the linked entity (product, category, or brand).
     */
    public function linkedProduct()
    {
        return $this->belongsTo(Product::class, 'link_id');
    }

    public function linkedCategory()
    {
        return $this->belongsTo(Category::class, 'link_id');
    }

    public function linkedBrand()
    {
        return $this->belongsTo(Brand::class, 'link_id');
    }

    /**
     * Get the link URL based on link type.
     */
    public function getLinkUrlAttribute()
    {
        if ($this->link_type === self::LINK_TYPE_EXTERNAL) {
            return $this->external_url;
        }
        return null; // The mobile app will handle internal links
    }

    /**
     * Scope for active banners.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for valid banners (active and within date range).
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

    /**
     * Scope for position.
     */
    public function scopePosition($query, $position)
    {
        return $query->where('position', $position);
    }

    /**
     * Scope for ordered banners.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
