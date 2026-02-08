<?php

namespace App\Livewire\Dashboard\Coupons;

use App\Models\Coupon;
use Livewire\Component;

class ViewCoupon extends Component
{
    public $coupon;
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
    public $used_count;
    public $start_date;
    public $end_date;
    public $is_active;

    protected $listeners = ['viewItem' => 'view'];

    public function view($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            $this->dispatch('somethingFailed');
            return;
        }

        $this->coupon = $coupon;
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
        $this->used_count = $coupon->used_count;
        $this->start_date = $coupon->start_date;
        $this->end_date = $coupon->end_date;
        $this->is_active = $coupon->is_active;

        $this->dispatch('viewModalToggle');
    }

    public function render()
    {
        return view('dashboard.coupons.view-coupon');
    }
}
