<?php

namespace App\Livewire\Dashboard\Products;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshData' => '$refresh'];

    public $search = '';
    public $categoryFilter = '';
    public $brandFilter = '';
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingBrandFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->is_active = !$product->is_active;
            $product->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function toggleFeatured($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->is_featured = !$product->is_featured;
            $product->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            $this->dispatch('success', __('dashboard.item_deleted_successfully'));
        }
    }

    public function render()
    {
        $data = Product::query()
            ->with(['brand', 'category', 'primaryImage'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name->ar', 'like', '%' . $this->search . '%')
                        ->orWhere('name->en', 'like', '%' . $this->search . '%')
                        ->orWhere('sku', 'like', '%' . $this->search . '%')
                        ->orWhere('barcode', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->when($this->brandFilter, function ($query) {
                $query->where('brand_id', $this->brandFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter);
            })
            ->ordered()
            ->paginate(10);

        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();

        return view('dashboard.products.products', compact('data', 'categories', 'brands'));
    }
}
