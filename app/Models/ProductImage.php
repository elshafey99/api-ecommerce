<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class ProductImage extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'product_id',
        'image',
        'alt_text',
        'is_primary',
        'sort_order',
    ];

    public $translatable = ['alt_text'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the product for the image.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
