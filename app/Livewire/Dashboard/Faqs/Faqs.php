<?php

namespace App\Livewire\Dashboard\Faqs;

use App\Models\Faq;
use Livewire\Component;
use Livewire\WithPagination;

class Faqs extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['itemAdded' => '$refresh', 'refreshData' => '$refresh', 'delete'];

    public $search = '';
    public $category = '';

    public function delete($id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return;
        }

        $faq->delete();

        $this->dispatch('success', __('dashboard.item_deleted_successfully'));
    }

    public function toggleStatus($id)
    {
        $faq = Faq::find($id);

        if ($faq) {
            $faq->is_active = !$faq->is_active;
            $faq->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = Faq::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('question->ar', 'like', '%' . $this->search . '%')
                        ->orWhere('question->en', 'like', '%' . $this->search . '%')
                        ->orWhere('answer->ar', 'like', '%' . $this->search . '%')
                        ->orWhere('answer->en', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->category, function ($query) {
                $query->where('category', $this->category);
            })
            ->ordered()
            ->paginate(10);

        $categories = [
            Faq::CATEGORY_GENERAL => __('dashboard.faq_general'),
            Faq::CATEGORY_ORDERS => __('dashboard.faq_orders'),
            Faq::CATEGORY_SHIPPING => __('dashboard.faq_shipping'),
            Faq::CATEGORY_PAYMENT => __('dashboard.faq_payment'),
            Faq::CATEGORY_RETURNS => __('dashboard.faq_returns'),
        ];

        return view('dashboard.faqs.faqs', compact('data', 'categories'));
    }
}
