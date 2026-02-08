<?php

namespace App\Livewire\Dashboard\Coupons;

use App\Models\Coupon;
use Livewire\Component;
use Livewire\WithPagination;

class Coupons extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['itemAdded' => '$refresh', 'refreshData' => '$refresh', 'delete'];

    public $search = '';
    public $statusFilter = 'all'; // all, active, inactive
    public $typeFilter = 'all'; // all, percentage, fixed

    public function delete($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return;
        }

        $coupon->delete();

        $this->dispatch('success', __('dashboard.item_deleted_successfully'));
    }

    public function toggleStatus($id)
    {
        $coupon = Coupon::find($id);

        if ($coupon) {
            $coupon->is_active = !$coupon->is_active;
            $coupon->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = Coupon::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                        ->orWhere('name->ar', 'like', '%' . $this->search . '%')
                        ->orWhere('name->en', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('is_active', $this->statusFilter === 'active');
            })
            ->when($this->typeFilter !== 'all', function ($query) {
                $query->where('discount_type', $this->typeFilter);
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.coupons.coupons', compact('data'));
    }
}
