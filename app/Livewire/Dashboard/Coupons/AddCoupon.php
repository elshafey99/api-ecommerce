<?php

namespace App\Livewire\Dashboard\Coupons;

use App\Models\Coupon;
use Livewire\Component;

class AddCoupon extends Component
{
    public $code;
    public $name_ar;
    public $name_en;
    public $description_ar;
    public $description_en;
    public $discount_type = 'percentage';
    public $discount_value;
    public $min_order_amount;
    public $max_discount_amount;
    public $usage_limit;
    public $usage_limit_per_user = 1;
    public $start_date;
    public $end_date;
    public $is_active = true;

    protected function rules()
    {
        return [
            'code' => 'required|string|max:50|unique:coupons,code',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'usage_limit_per_user' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ];
    }

    public function submit()
    {
        $validated = $this->validate();

        Coupon::create([
            'code' => strtoupper($validated['code']),
            'name' => [
                'ar' => $validated['name_ar'],
                'en' => $validated['name_en'],
            ],
            'description' => [
                'ar' => $validated['description_ar'] ?? null,
                'en' => $validated['description_en'] ?? null,
            ],
            'discount_type' => $validated['discount_type'],
            'discount_value' => $validated['discount_value'],
            'min_order_amount' => $validated['min_order_amount'],
            'max_discount_amount' => $validated['max_discount_amount'],
            'usage_limit' => $validated['usage_limit'],
            'usage_limit_per_user' => $validated['usage_limit_per_user'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $validated['is_active'],
        ]);

        $this->reset();
        $this->dispatch('itemAdded');
        $this->dispatch('createModalToggle');
        $this->dispatch('success', __('dashboard.item_created_successfully'));
    }

    public function render()
    {
        return view('dashboard.coupons.add-coupon');
    }
}
