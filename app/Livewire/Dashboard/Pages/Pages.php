<?php

namespace App\Livewire\Dashboard\Pages;

use App\Models\Page;
use Livewire\Component;
use Livewire\WithPagination;

class Pages extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['itemAdded' => '$refresh', 'refreshData' => '$refresh', 'delete'];

    public $search = '';

    public function delete($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return;
        }

        $page->delete();

        $this->dispatch('success', __('dashboard.item_deleted_successfully'));
    }

    public function toggleStatus($id)
    {
        $page = Page::find($id);

        if ($page) {
            $page->is_active = !$page->is_active;
            $page->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = Page::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title->ar', 'like', '%' . $this->search . '%')
                        ->orWhere('title->en', 'like', '%' . $this->search . '%')
                        ->orWhere('slug', 'like', '%' . $this->search . '%');
                });
            })
            ->ordered()
            ->paginate(10);

        return view('dashboard.pages.pages', compact('data'));
    }
}
