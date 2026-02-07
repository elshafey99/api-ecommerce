<?php

namespace App\Livewire\Dashboard\Brands;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Helpers\FileHelper;

class UpdateBrand extends Component
{
    use WithFileUploads;

    protected $listeners = ['editItem' => 'edit'];

    public $brand_id;
    public $name_ar = '';
    public $name_en = '';
    public $slug = '';
    public $is_active = true;
    public $sort_order = 0;
    public $image;
    public $old_image;

    public function edit($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            $this->dispatch('somethingFailed');
            return;
        }

        $this->brand_id = $brand->id;
        $this->name_ar = $brand->getTranslation('name', 'ar');
        $this->name_en = $brand->getTranslation('name', 'en');
        $this->slug = $brand->slug;
        $this->is_active = $brand->is_active;
        $this->sort_order = $brand->sort_order;
        $this->old_image = $brand->image;
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
            'slug' => 'required|string|max:255|unique:brands,slug,' . $this->brand_id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $brand = Brand::find($this->brand_id);

        if (!$brand) {
            $this->dispatch('somethingFailed');
            return;
        }

        $data = [
            'name' => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'slug' => $this->slug,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order ?? 0,
        ];

        // Handle image upload using FileHelper
        if ($this->image) {
            try {
                // Delete old image
                if ($brand->image) {
                    FileHelper::delete($brand->image);
                }
                $data['image'] = FileHelper::uploadImage($this->image, 'uploads/brands');
            } catch (\Exception $e) {
                $this->dispatch('somethingFailed');
                return;
            }
        }

        $brand->update($data);

        $this->dispatch('updateModalToggle');
        $this->dispatch('success', __('dashboard.item_updated_successfully'));
        $this->dispatch('refreshData');

        // Reset inputs
        $this->reset(['brand_id', 'name_ar', 'name_en', 'slug', 'is_active', 'sort_order', 'image', 'old_image']);
    }

    public function render()
    {
        return view('dashboard.brands.update-brand');
    }
}
