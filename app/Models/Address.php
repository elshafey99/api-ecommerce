<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Address extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'user_id',
        'title',
        'recipient_name',
        'phone',
        'governorate',
        'city',
        'area',
        'street_address',
        'building_number',
        'floor_number',
        'apartment_number',
        'landmark',
        'latitude',
        'longitude',
        'is_default',
    ];

    public $translatable = ['title'];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_default' => 'boolean',
    ];

    /**
     * Get the user for the address.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted full address.
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->street_address,
            $this->building_number ? "مبنى {$this->building_number}" : null,
            $this->floor_number ? "طابق {$this->floor_number}" : null,
            $this->apartment_number ? "شقة {$this->apartment_number}" : null,
            $this->area,
            $this->city,
            $this->governorate,
        ]);
        return implode(', ', $parts);
    }

    /**
     * Scope for default address.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
