<?php

namespace App\Livewire\Dashboard\PaymentMethods;

use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentMethods extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $paymentMethod = PaymentMethod::find($id);

        if ($paymentMethod) {
            $paymentMethod->is_active = !$paymentMethod->is_active;
            $paymentMethod->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function render()
    {
        $data = PaymentMethod::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('code', 'like', '%' . $this->search . '%')
                        ->orWhere('name->ar', 'like', '%' . $this->search . '%')
                        ->orWhere('name->en', 'like', '%' . $this->search . '%');
                });
            })
            ->ordered()
            ->paginate(10);

        return view('dashboard.paymentmethods.payment-methods', compact('data'));
    }
}
