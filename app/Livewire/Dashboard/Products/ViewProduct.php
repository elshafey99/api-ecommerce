<?php

namespace App\Livewire\Dashboard\Products;

use App\Models\Product;
use Livewire\Component;

class ViewProduct extends Component
{
    protected $listeners = ['viewItem' => 'view'];

    public $product;
    public $images = [];

    public function view($id)
    {
        $this->product = Product::with(['brand', 'category', 'images'])->find($id);

        if (!$this->product) {
            $this->dispatch('somethingFailed');
            return;
        }

        $this->images = $this->product->images->toArray();
        $this->dispatch('viewModalToggle');
    }

    public function render()
    {
        return view('dashboard.products.view-product');
    }
}
