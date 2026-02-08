<?php

namespace App\Livewire\Dashboard\Pages;

use App\Models\Page;
use Livewire\Component;
use Illuminate\Support\Str;

class UpdatePage extends Component
{
    protected $listeners = ['editItem' => 'edit'];

    public $page_id;
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

    public function edit($id)
    {
        $page = Page::find($id);

        if (!$page) {
            $this->dispatch('somethingFailed');
            return;
        }

        $this->page_id = $page->id;
        $this->title_ar = $page->getTranslation('title', 'ar');
        $this->title_en = $page->getTranslation('title', 'en');
        $this->content_ar = $page->getTranslation('content', 'ar');
        $this->content_en = $page->getTranslation('content', 'en');
        $this->slug = $page->slug;
        $this->meta_title_ar = $page->getTranslation('meta_title', 'ar') ?? '';
        $this->meta_title_en = $page->getTranslation('meta_title', 'en') ?? '';
        $this->meta_description_ar = $page->getTranslation('meta_description', 'ar') ?? '';
        $this->meta_description_en = $page->getTranslation('meta_description', 'en') ?? '';
        $this->is_active = $page->is_active;
        $this->sort_order = $page->sort_order;

        $this->dispatch('updateModalToggle');
        $this->dispatch('setEditorContent', [
            'content_ar' => $this->content_ar,
            'content_en' => $this->content_en
        ]);
    }

    public function submit()
    {
        $this->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'required|string',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $this->page_id,
            'meta_title_ar' => 'nullable|string|max:255',
            'meta_title_en' => 'nullable|string|max:255',
            'meta_description_ar' => 'nullable|string|max:500',
            'meta_description_en' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $page = Page::find($this->page_id);

        if (!$page) {
            $this->dispatch('somethingFailed');
            return;
        }

        $page->update([
            'title' => ['ar' => $this->title_ar, 'en' => $this->title_en],
            'content' => ['ar' => $this->content_ar, 'en' => $this->content_en],
            'slug' => $this->slug,
            'meta_title' => ['ar' => $this->meta_title_ar, 'en' => $this->meta_title_en],
            'meta_description' => ['ar' => $this->meta_description_ar, 'en' => $this->meta_description_en],
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order ?? 0,
        ]);

        $this->dispatch('updateModalToggle');
        $this->dispatch('success', __('dashboard.item_updated_successfully'));
        $this->dispatch('refreshData');

        // Reset inputs
        $this->reset([
            'page_id',
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
    }

    public function render()
    {
        return view('dashboard.pages.update-page');
    }
}
