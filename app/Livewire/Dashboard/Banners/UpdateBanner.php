<?php

namespace App\Livewire\Dashboard\Banners;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Helpers\FileHelper;

class UpdateBanner extends Component
{
    use WithFileUploads;

    protected $listeners = ['editItem' => 'edit'];

    public $banner_id;
    public $title_ar = '';
    public $title_en = '';
    public $subtitle_ar = '';
    public $subtitle_en = '';
    public $image;
    public $mobile_image;
    public $old_image;
    public $old_mobile_image;
    public $link_type = 'none';
    public $link_id = null;
    public $external_url = '';
    public $position = 'home_slider';
    public $start_date = null;
    public $end_date = null;
    public $is_active = true;
    public $sort_order = 0;

    public function edit($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            $this->dispatch('somethingFailed');
            return;
        }

        $this->banner_id = $banner->id;
        $this->title_ar = $banner->getTranslation('title', 'ar') ?? '';
        $this->title_en = $banner->getTranslation('title', 'en') ?? '';
        $this->subtitle_ar = $banner->getTranslation('subtitle', 'ar') ?? '';
        $this->subtitle_en = $banner->getTranslation('subtitle', 'en') ?? '';
        $this->old_image = $banner->image;
        $this->old_mobile_image = $banner->mobile_image;
        $this->link_type = $banner->link_type ?? 'none';
        $this->link_id = $banner->link_id;
        $this->external_url = $banner->external_url ?? '';
        $this->position = $banner->position;
        $this->start_date = $banner->start_date?->format('Y-m-d');
        $this->end_date = $banner->end_date?->format('Y-m-d');
        $this->is_active = $banner->is_active;
        $this->sort_order = $banner->sort_order;
        $this->image = null;
        $this->mobile_image = null;

        $this->dispatch('updateModalToggle');
    }

    public function updatedLinkType()
    {
        $this->link_id = null;
        $this->external_url = '';
    }

    public function submit()
    {
        $rules = [
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'subtitle_ar' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'link_type' => 'required|in:product,category,brand,external,none',
            'position' => 'required|in:home_slider,home_banner,category_banner',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'sort_order' => 'nullable|integer|min:0',
        ];

        if ($this->link_type === 'external') {
            $rules['external_url'] = 'required|url|max:500';
        } elseif (in_array($this->link_type, ['product', 'category', 'brand'])) {
            $rules['link_id'] = 'required|integer';
        }

        $this->validate($rules);

        $banner = Banner::find($this->banner_id);

        if (!$banner) {
            $this->dispatch('somethingFailed');
            return;
        }

        $data = [
            'title' => ['ar' => $this->title_ar, 'en' => $this->title_en],
            'subtitle' => ['ar' => $this->subtitle_ar, 'en' => $this->subtitle_en],
            'link_type' => $this->link_type,
            'link_id' => in_array($this->link_type, ['product', 'category', 'brand']) ? $this->link_id : null,
            'external_url' => $this->link_type === 'external' ? $this->external_url : null,
            'position' => $this->position,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order ?? 0,
        ];

        // Handle image upload
        try {
            if ($this->image) {
                if ($banner->image) {
                    FileHelper::delete($banner->image);
                }
                $data['image'] = FileHelper::uploadImage($this->image, 'uploads/banners');
            }

            if ($this->mobile_image) {
                if ($banner->mobile_image) {
                    FileHelper::delete($banner->mobile_image);
                }
                $data['mobile_image'] = FileHelper::uploadImage($this->mobile_image, 'uploads/banners');
            }
        } catch (\Exception $e) {
            $this->dispatch('somethingFailed');
            return;
        }

        $banner->update($data);

        $this->dispatch('updateModalToggle');
        $this->dispatch('success', __('dashboard.item_updated_successfully'));
        $this->dispatch('refreshData');

        // Reset inputs
        $this->reset([
            'banner_id',
            'title_ar',
            'title_en',
            'subtitle_ar',
            'subtitle_en',
            'image',
            'mobile_image',
            'old_image',
            'old_mobile_image',
            'link_type',
            'link_id',
            'external_url',
            'position',
            'start_date',
            'end_date',
            'sort_order'
        ]);
    }

    public function render()
    {
        $products = Product::active()->ordered()->get();
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();

        $positions = [
            Banner::POSITION_HOME_SLIDER => __('dashboard.home_slider'),
            Banner::POSITION_HOME_BANNER => __('dashboard.home_banner'),
            Banner::POSITION_CATEGORY_BANNER => __('dashboard.category_banner'),
        ];

        $linkTypes = [
            Banner::LINK_TYPE_NONE => __('dashboard.none'),
            Banner::LINK_TYPE_PRODUCT => __('dashboard.product'),
            Banner::LINK_TYPE_CATEGORY => __('dashboard.category'),
            Banner::LINK_TYPE_BRAND => __('dashboard.brand'),
            Banner::LINK_TYPE_EXTERNAL => __('dashboard.external_link'),
        ];

        return view('dashboard.banners.update-banner', compact('products', 'categories', 'brands', 'positions', 'linkTypes'));
    }
}
