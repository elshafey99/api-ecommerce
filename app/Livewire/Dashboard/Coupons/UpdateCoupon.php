<?php

namespace App\Livewire\Dashboard\Coupons;

use App\Models\Coupon;
use Livewire\Component;

class UpdateCoupon extends Component
{
    public $coupon_id;
    public $code;
    public $name_ar;
    public $name_en;
    public $description_ar;
    public $description_en;
    public $discount_type;
    public $discount_value;
    public $min_order_amount;
    public $max_discount_amount;
    public $usage_limit;
    public $usage_limit_per_user;
    public $start_date;
    public $end_date;
    public $is_active;

    protected $listeners = ['editItem' => 'edit'];

    protected function rules()
    {
        return [
            'code' => 'required|string|max:50|unique:coupons,code,' . $this->coupon_id,
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

    public function edit($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            $this->dispatch('somethingFailed');
            return;
        }

        $this->coupon_id = $coupon->id;
        $this->code = $coupon->code;
        $this->name_ar = $coupon->getTranslation('name', 'ar');
        $this->name_en = $coupon->getTranslation('name', 'en');
        $this->description_ar = $coupon->getTranslation('description', 'ar');
        $this->description_en = $coupon->getTranslation('description', 'en');
        $this->discount_type = $coupon->discount_type;
        $this->discount_value = $coupon->discount_value;
        $this->min_order_amount = $coupon->min_order_amount;
        $this->max_discount_amount = $coupon->max_discount_amount;
        $this->usage_limit = $coupon->usage_limit;
        $this->usage_limit_per_user = $coupon->usage_limit_per_user;
        $this->start_date = $coupon->start_date?->format('Y-m-d');
        $this->end_date = $coupon->end_date?->format('Y-m-d');
        $this->is_active = $coupon->is_active;

        $this->dispatch('updateModalToggle');
    }

    public function submit()
    {
        $validated = $this->validate();

        $coupon = Coupon::find($this->coupon_id);

        if (!$coupon) {
            $this->dispatch('somethingFailed');
            return;
        }

        $coupon->update([
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

        $this->dispatch('refreshData');
        $this->dispatch('updateModalToggle');
        $this->dispatch('success', __('dashboard.item_updated_successfully'));
    }

    public function render()
    {
        return view('dashboard.coupons.update-coupon');
    }
}
