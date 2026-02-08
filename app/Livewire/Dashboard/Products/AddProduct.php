<?php

namespace App\Livewire\Dashboard\Products;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class AddProduct extends Component
{
    use WithFileUploads;

    public $name_ar = '';
    public $name_en = '';
    public $description_ar = '';
    public $description_en = '';
    public $sku = '';
    public $barcode = '';
    public $brand_id = '';
    public $category_id = '';
    public $price = 0;
    public $sale_price = '';
    public $cost_price = '';
    public $stock_quantity = 0;
    public $min_order_quantity = 1;
    public $max_order_quantity = '';
    public $unit_ar = 'قطعة';
    public $unit_en = 'piece';
    public $weight = '';
    public $is_active = true;
    public $is_featured = false;
    public $track_stock = true;
    public $sort_order = 0;
    public $images = [];

    public function updatedImages()
    {
        $this->validate([
            'images.*' => 'image|max:2048',
        ]);
    }

    public function removeImage($index)
    {
        array_splice($this->images, $index, 1);
    }

    public function submit()
    {
        $this->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'sku' => 'nullable|string|max:50|unique:products,sku',
            'barcode' => 'nullable|string|max:50',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_order_quantity' => 'required|integer|min:1',
            'max_order_quantity' => 'nullable|integer|min:1',
            'weight' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'images.*' => 'image|max:2048',
        ]);

        // Generate slug from English name
        $slug = Str::slug($this->name_en);
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $product = Product::create([
            'name' => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'description' => ['ar' => $this->description_ar, 'en' => $this->description_en],
            'slug' => $slug,
            'sku' => $this->sku ?: null,
            'barcode' => $this->barcode ?: null,
            'brand_id' => $this->brand_id ?: null,
            'category_id' => $this->category_id ?: null,
            'price' => $this->price,
            'sale_price' => $this->sale_price ?: null,
            'cost_price' => $this->cost_price ?: null,
            'stock_quantity' => $this->stock_quantity,
            'min_order_quantity' => $this->min_order_quantity,
            'max_order_quantity' => $this->max_order_quantity ?: null,
            'unit' => ['ar' => $this->unit_ar, 'en' => $this->unit_en],
            'weight' => $this->weight ?: null,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'track_stock' => $this->track_stock,
            'sort_order' => $this->sort_order ?? 0,
        ]);

        // Upload images
        if (!empty($this->images)) {
            foreach ($this->images as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        $this->dispatch('createModalToggle');
        $this->dispatch('success', __('dashboard.item_created_successfully'));
        $this->dispatch('refreshData');

        $this->reset();
        $this->is_active = true;
        $this->min_order_quantity = 1;
        $this->unit_ar = 'قطعة';
        $this->unit_en = 'piece';
    }

    public function render()
    {
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();

        return view('dashboard.products.add-product', compact('categories', 'brands'));
    }
}
