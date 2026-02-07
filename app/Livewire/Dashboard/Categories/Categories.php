<?php

namespace App\Livewire\Dashboard\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\FileHelper;

class Categories extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshData' => '$refresh', 'delete'];

    public $search = '';

    public function delete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return;
        }

        // Check if category has products
        if ($category->products()->count() > 0) {
            $this->dispatch('cannotDeleteCategory');
            return;
        }

        // Check if category has children
        if ($category->children()->count() > 0) {
            $this->dispatch('cannotDeleteCategoryHasChildren');
            return;
        }

        // Delete image using FileHelper
        if ($category->image) {
            FileHelper::delete($category->image);
        }

        $category->delete();

        $this->dispatch('success', __('dashboard.item_deleted_successfully'));
    }

    public function toggleStatus($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->is_active = !$category->is_active;
            $category->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = Category::with('parent')
            ->withCount(['products', 'children'])
            ->where(function ($query) {
                $query->where('name->ar', 'like', '%' . $this->search . '%')
                    ->orWhere('name->en', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->ordered()
            ->paginate(10);

        return view('dashboard.categories.categories', compact('data'));
    }
}
