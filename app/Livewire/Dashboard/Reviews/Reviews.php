<?php

namespace App\Livewire\Dashboard\Reviews;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class Reviews extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshData' => '$refresh'];

    public $search = '';
    public $filter = 'all'; // all, approved, pending

    public function toggleApproval($id)
    {
        $review = Review::find($id);

        if ($review) {
            $review->is_approved = !$review->is_approved;
            $review->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = Review::query()
            ->with(['user', 'product'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($userQuery) {
                        $userQuery->where('name', 'like', '%' . $this->search . '%');
                    })
                        ->orWhereHas('product', function ($productQuery) {
                            $productQuery->where('name->ar', 'like', '%' . $this->search . '%')
                                ->orWhere('name->en', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('comment', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filter === 'approved', function ($query) {
                $query->where('is_approved', true);
            })
            ->when($this->filter === 'pending', function ($query) {
                $query->where('is_approved', false);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.dashboard.reviews.reviews', compact('data'));
    }
}
