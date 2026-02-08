<?php

namespace App\Livewire\Dashboard\Faqs;

use App\Models\Faq;
use Livewire\Component;

class AddFaq extends Component
{
    public $question_ar = '';
    public $question_en = '';
    public $answer_ar = '';
    public $answer_en = '';
    public $category = 'general';
    public $is_active = true;
    public $sort_order = 0;

    public function submit()
    {
        $this->validate([
            'question_ar' => 'required|string|max:500',
            'question_en' => 'required|string|max:500',
            'answer_ar' => 'required|string|max:5000',
            'answer_en' => 'required|string|max:5000',
            'category' => 'required|in:orders,shipping,payment,returns,general',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Faq::create([
            'question' => ['ar' => $this->question_ar, 'en' => $this->question_en],
            'answer' => ['ar' => $this->answer_ar, 'en' => $this->answer_en],
            'category' => $this->category,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order ?? 0,
        ]);

        $this->dispatch('createModalToggle');
        $this->dispatch('success', __('dashboard.item_created_successfully'));
        $this->dispatch('refreshData');

        // Reset inputs
        $this->reset(['question_ar', 'question_en', 'answer_ar', 'answer_en', 'category', 'sort_order']);
        $this->is_active = true;
        $this->category = 'general';
    }

    public function render()
    {
        $categories = [
            Faq::CATEGORY_GENERAL => __('dashboard.faq_general'),
            Faq::CATEGORY_ORDERS => __('dashboard.faq_orders'),
            Faq::CATEGORY_SHIPPING => __('dashboard.faq_shipping'),
            Faq::CATEGORY_PAYMENT => __('dashboard.faq_payment'),
            Faq::CATEGORY_RETURNS => __('dashboard.faq_returns'),
        ];

        return view('dashboard.faqs.add-faq', compact('categories'));
    }
}
