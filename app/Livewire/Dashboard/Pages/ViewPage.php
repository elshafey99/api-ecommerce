<?php

namespace App\Livewire\Dashboard\Pages;

use App\Models\Page;
use Livewire\Component;

class ViewPage extends Component
{
    protected $listeners = ['viewItem' => 'view'];

    public $page;
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

    public function view($id)
    {
        $page = Page::find($id);

        if (!$page) {
            $this->dispatch('somethingFailed');
            return;
        }

        $this->page = $page;
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

        $this->dispatch('viewModalToggle');
    }

    public function render()
    {
        return view('dashboard.pages.view-page');
    }
}
