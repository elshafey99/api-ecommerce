<?php

namespace App\Livewire\Dashboard\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Helpers\FileHelper;

class UpdateCategory extends Component
{
    use WithFileUploads;

    protected $listeners = ['editItem' => 'edit'];

    public $category_id;
    public $name_ar = '';
    public $name_en = '';
    public $description_ar = '';
    public $description_en = '';
    public $slug = '';
    public $parent_id = '';
    public $is_active = true;
    public $sort_order = 0;
    public $image;
    public $old_image;

    public function edit($id)
    {
        $category = Category::find($id);

        if (!$category) {
            $this->dispatch('somethingFailed');
            return;
        }

        $this->category_id = $category->id;
        $this->name_ar = $category->getTranslation('name', 'ar');
        $this->name_en = $category->getTranslation('name', 'en');
        $this->description_ar = $category->getTranslation('description', 'ar') ?? '';
        $this->description_en = $category->getTranslation('description', 'en') ?? '';
        $this->slug = $category->slug;
        $this->parent_id = $category->parent_id ?? '';
        $this->is_active = $category->is_active;
        $this->sort_order = $category->sort_order;
        $this->old_image = $category->image;
        $this->image = null;

        $this->dispatch('updateModalToggle');
    }

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
            'slug' => 'required|string|max:255|unique:categories,slug,' . $this->category_id,
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $category = Category::find($this->category_id);

        if (!$category) {
            $this->dispatch('somethingFailed');
            return;
        }

        // Prevent setting parent to self or own child
        if ($this->parent_id == $this->category_id) {
            $this->addError('parent_id', __('dashboard.cannot_set_self_as_parent'));
            return;
        }

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
                // Delete old image
                if ($category->image) {
                    FileHelper::delete($category->image);
                }
                $data['image'] = FileHelper::uploadImage($this->image, 'uploads/categories');
            } catch (\Exception $e) {
                $this->dispatch('somethingFailed');
                return;
            }
        }

        $category->update($data);

        $this->dispatch('updateModalToggle');
        $this->dispatch('success', __('dashboard.item_updated_successfully'));
        $this->dispatch('refreshData');

        // Reset inputs
        $this->reset(['category_id', 'name_ar', 'name_en', 'description_ar', 'description_en', 'slug', 'parent_id', 'is_active', 'sort_order', 'image', 'old_image']);
    }

    public function render()
    {
        $categories = Category::where('id', '!=', $this->category_id ?? 0)
            ->root()
            ->active()
            ->ordered()
            ->get();
        return view('dashboard.categories.update-category', compact('categories'));
    }
}
