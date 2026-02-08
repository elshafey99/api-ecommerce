<?php

namespace App\Livewire\Dashboard\Faqs;

use App\Models\Faq;
use Livewire\Component;

class UpdateFaq extends Component
{
    protected $listeners = ['editItem' => 'edit'];

    public $faq_id;
    public $question_ar = '';
    public $question_en = '';
    public $answer_ar = '';
    public $answer_en = '';
    public $category = 'general';
    public $is_active = true;
    public $sort_order = 0;

    public function edit($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            $this->dispatch('somethingFailed');
            return;
        }

        $this->faq_id = $faq->id;
        $this->question_ar = $faq->getTranslation('question', 'ar');
        $this->question_en = $faq->getTranslation('question', 'en');
        $this->answer_ar = $faq->getTranslation('answer', 'ar');
        $this->answer_en = $faq->getTranslation('answer', 'en');
        $this->category = $faq->category ?? 'general';
        $this->is_active = $faq->is_active;
        $this->sort_order = $faq->sort_order;

        $this->dispatch('updateModalToggle');
    }

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

        $faq = Faq::find($this->faq_id);

        if (!$faq) {
            $this->dispatch('somethingFailed');
            return;
        }

        $faq->update([
            'question' => ['ar' => $this->question_ar, 'en' => $this->question_en],
            'answer' => ['ar' => $this->answer_ar, 'en' => $this->answer_en],
            'category' => $this->category,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order ?? 0,
        ]);

        $this->dispatch('updateModalToggle');
        $this->dispatch('success', __('dashboard.item_updated_successfully'));
        $this->dispatch('refreshData');

        // Reset inputs
        $this->reset(['faq_id', 'question_ar', 'question_en', 'answer_ar', 'answer_en', 'category', 'sort_order']);
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

        return view('dashboard.faqs.update-faq', compact('categories'));
    }
}
