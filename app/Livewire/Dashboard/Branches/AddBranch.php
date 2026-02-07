<?php

namespace App\Livewire\Dashboard\Branches;

use App\Models\Branch;
use Livewire\Component;

class AddBranch extends Component
{
    public $name_ar = '';
    public $name_en = '';
    public $address_ar = '';
    public $address_en = '';
    public $phone = '';
    public $whatsapp = '';
    public $email = '';
    public $latitude = '';
    public $longitude = '';
    public $delivery_fee = 0;
    public $min_order_amount = 0;
    public $free_delivery_threshold = '';
    public $is_active = true;
    public $is_main = false;
    public $sort_order = 0;
    public $working_hours = [
        'saturday' => ['open' => '09:00', 'close' => '22:00'],
        'sunday' => ['open' => '09:00', 'close' => '22:00'],
        'monday' => ['open' => '09:00', 'close' => '22:00'],
        'tuesday' => ['open' => '09:00', 'close' => '22:00'],
        'wednesday' => ['open' => '09:00', 'close' => '22:00'],
        'thursday' => ['open' => '09:00', 'close' => '22:00'],
        'friday' => ['open' => '09:00', 'close' => '22:00'],
    ];

    public function submit()
    {
        $this->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'address_ar' => 'nullable|string',
            'address_en' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'delivery_fee' => 'nullable|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'free_delivery_threshold' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        // If setting as main, unset other main branches
        if ($this->is_main) {
            Branch::where('is_main', true)->update(['is_main' => false]);
        }

        $data = [
            'name' => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'address' => ['ar' => $this->address_ar, 'en' => $this->address_en],
            'phone' => $this->phone ?: null,
            'whatsapp' => $this->whatsapp ?: null,
            'email' => $this->email ?: null,
            'latitude' => $this->latitude ?: null,
            'longitude' => $this->longitude ?: null,
            'delivery_fee' => $this->delivery_fee ?? 0,
            'min_order_amount' => $this->min_order_amount ?? 0,
            'free_delivery_threshold' => $this->free_delivery_threshold ?: null,
            'working_hours' => $this->working_hours,
            'is_active' => $this->is_active,
            'is_main' => $this->is_main,
            'sort_order' => $this->sort_order ?? 0,
        ];

        Branch::create($data);

        $this->dispatch('createModalToggle');
        $this->dispatch('success', __('dashboard.item_created_successfully'));
        $this->dispatch('refreshData');

        // Reset inputs
        $this->reset();
        $this->is_active = true;
    }

    public function render()
    {
        return view('dashboard.branches.add-branch');
    }
}
