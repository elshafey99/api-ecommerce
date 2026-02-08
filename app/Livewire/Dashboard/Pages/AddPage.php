<?php

namespace App\Livewire\Dashboard\Pages;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Support\Str;

class AddPage extends Component
{
    public $title_ar = '';
    public $title_en = '';
    public $content_ar = '';
    public $content_en = '';
    public $slug = '';
    public $meta_title_ar = '';
    public $meta_title_en = '';
    public $meta_description_ar = '';
    public $meta_description_en = '';
    public $is_active = true;
    public $sort_order = 0;

    public function updatedTitleEn($value)
    {
        $this->slug = Str::slug($value);
    }

    public function submit()
    {
        $this->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'required|string',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'meta_title_ar' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_ar' => 'nullable|string|max:500',
            'meta_description_en' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Page::create([
            'title' => ['ar' => $this->title_ar, 'en' => $this->title_en],
            'content' => ['ar' => $this->content_ar, 'en' => $this->content_en],
            'slug' => $this->slug,
            'meta_title' => ['ar' => $this->meta_title_ar, 'en' => $this->meta_title_en],
            'meta_description' => ['ar' => $this->meta_description_ar, 'en' => $this->meta_description_en],
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order ?? 0,
        ]);

        $this->dispatch('createModalToggle');
        $this->dispatch('success', __('dashboard.item_created_successfully'));
        $this->dispatch('refreshData');

        // Reset inputs
        $this->reset([
            'title_ar',
            'title_en',
            'content_ar',
            'content_en',
            'slug',
            'meta_title_ar',
            'meta_title_en',
            'meta_description_ar',
            'meta_description_en',
            'sort_order'
        ]);
        $this->is_active = true;
    }

    public function render()
    {
        return view('dashboard.pages.add-page');
    }
}
