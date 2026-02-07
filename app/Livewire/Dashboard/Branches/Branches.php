<?php

namespace App\Livewire\Dashboard\Branches;

use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;

class Branches extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['refreshData' => '$refresh', 'delete'];

    public $search = '';

    public function delete($id)
    {
        $branch = Branch::find($id);

        if (!$branch) {
            return;
        }

        // Check if branch has orders
        if ($branch->orders()->count() > 0) {
            $this->dispatch('cannotDeleteBranch');
            return;
        }

        $branch->delete();

        $this->dispatch('success', __('dashboard.item_deleted_successfully'));
    }

    public function toggleStatus($id)
    {
        $branch = Branch::find($id);

        if ($branch) {
            $branch->is_active = !$branch->is_active;
            $branch->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function toggleMain($id)
    {
        $branch = Branch::find($id);

        if ($branch) {
            // If setting as main, unset other main branches
            if (!$branch->is_main) {
                Branch::where('is_main', true)->update(['is_main' => false]);
            }
            $branch->is_main = !$branch->is_main;
            $branch->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = Branch::withCount('orders')
            ->where(function ($query) {
                $query->where('name->ar', 'like', '%' . $this->search . '%')
                    ->orWhere('name->en', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->ordered()
            ->paginate(10);

        return view('dashboard.branches.branches', compact('data'));
    }
}
