<?php

namespace App\Livewire\Dashboard\Banners;

use App\Models\Banner;
use Livewire\Component;
use Livewire\WithPagination;
use App\Helpers\FileHelper;

class Banners extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['itemAdded' => '$refresh', 'refreshData' => '$refresh', 'delete'];

    public $search = '';
    public $position = '';

    public function delete($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return;
        }

        // Delete images using FileHelper
        if ($banner->image) {
            FileHelper::delete($banner->image);
        }
        if ($banner->mobile_image) {
            FileHelper::delete($banner->mobile_image);
        }

        $banner->delete();

        $this->dispatch('success', __('dashboard.item_deleted_successfully'));
    }

    public function toggleStatus($id)
    {
        $banner = Banner::find($id);

        if ($banner) {
            $banner->is_active = !$banner->is_active;
            $banner->save();

            $this->dispatch('success', __('dashboard.status_updated_successfully'));
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPosition()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = Banner::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title->ar', 'like', '%' . $this->search . '%')
                        ->orWhere('title->en', 'like', '%' . $this->search . '%')
                        ->orWhere('subtitle->ar', 'like', '%' . $this->search . '%')
                        ->orWhere('subtitle->en', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->position, function ($query) {
                $query->where('position', $this->position);
            })
            ->ordered()
            ->paginate(10);

        $positions = [
            Banner::POSITION_HOME_SLIDER => __('dashboard.home_slider'),
            Banner::POSITION_HOME_BANNER => __('dashboard.home_banner'),
            Banner::POSITION_CATEGORY_BANNER => __('dashboard.category_banner'),
        ];

        return view('dashboard.banners.banners', compact('data', 'positions'));
    }
}
