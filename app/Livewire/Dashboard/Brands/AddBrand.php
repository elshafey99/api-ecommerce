<?php

namespace App\Livewire\Dashboard\Brands;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Helpers\FileHelper;

class AddBrand extends Component
{
    use WithFileUploads;

    public $name_ar = '';
    public $name_en = '';
    public $slug = '';
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
            'slug' => 'required|string|max:255|unique:brands,slug',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'name' => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'slug' => $this->slug,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order ?? 0,
        ];

        // Handle image upload using FileHelper
        if ($this->image) {
            try {
                $data['image'] = FileHelper::uploadImage($this->image, 'uploads/brands');
            } catch (\Exception $e) {
                $this->dispatch('somethingFailed');
                return;
            }
        }

        Brand::create($data);

        $this->dispatch('createModalToggle');
        $this->dispatch('success', __('dashboard.item_created_successfully'));
        $this->dispatch('refreshData');

        // Reset inputs
        $this->reset(['name_ar', 'name_en', 'slug', 'is_active', 'sort_order', 'image']);
        $this->is_active = true;
    }

    public function render()
    {
        return view('dashboard.brands.add-brand');
    }
}
