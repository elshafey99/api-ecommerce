<?php

namespace App\Livewire\Dashboard\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Helpers\FileHelper;

class AddCategory extends Component
{
    use WithFileUploads;

    public $name_ar = '';
    public $name_en = '';
    public $description_ar = '';
    public $description_en = '';
    public $slug = '';
    public $parent_id = '';
    public $is_active = true;
    public $sort_order = 0;
    public $image;

    public function updatedNameEn($value)
    {
        $this->slug = Str::slug($value);
    }

    public function submit()
    {
        $this->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'name' => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'description' => ['ar' => $this->description_ar, 'en' => $this->description_en],
            'slug' => $this->slug,
            'parent_id' => $this->parent_id ?: null,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order ?? 0,
        ];

        // Handle image upload using FileHelper
        if ($this->image) {
            try {
                $data['image'] = FileHelper::uploadImage($this->image, 'uploads/categories');
            } catch (\Exception $e) {
                $this->dispatch('somethingFailed');
                return;
            }
        }

        Category::create($data);

        $this->dispatch('createModalToggle');
        $this->dispatch('success', __('dashboard.item_created_successfully'));
        $this->dispatch('refreshData');

        // Reset inputs
        $this->reset(['name_ar', 'name_en', 'description_ar', 'description_en', 'slug', 'parent_id', 'is_active', 'sort_order', 'image']);
        $this->is_active = true;
    }

    public function render()
    {
        $categories = Category::root()->active()->ordered()->get();
        return view('dashboard.categories.add-category', compact('categories'));
    }
}
