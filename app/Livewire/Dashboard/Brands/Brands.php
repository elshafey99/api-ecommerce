<?php

namespace App\Livewire\Dashboard\Brands;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\FileHelper;

class Brands extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['itemAdded' => '$refresh', 'refreshData' => '$refresh', 'delete'];

    public $search = '';

    public function delete($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return;
        }

        // Check if brand has products
        if ($brand->products()->count() > 0) {
            $this->dispatch('cannotDeleteBrand');
            return;
        }

        // Delete image using FileHelper
        if ($brand->image) {
            FileHelper::delete($brand->image);
        }

        $brand->delete();

        $this->dispatch('success', __('dashboard.item_deleted_successfully'));
    }

    public function toggleStatus($id)
    {
        $brand = Brand::find($id);

        if ($brand) {
            $brand->is_active = !$brand->is_active;
            $brand->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = Brand::withCount('products')
            ->where(function ($query) {
                $query->where('name->ar', 'like', '%' . $this->search . '%')
                    ->orWhere('name->en', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->ordered()
            ->paginate(10);

        return view('dashboard.brands.brands', compact('data'));
    }
}
