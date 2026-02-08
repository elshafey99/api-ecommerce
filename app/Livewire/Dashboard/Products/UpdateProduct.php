<?php

namespace App\Livewire\Dashboard\Products;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UpdateProduct extends Component
{
    use WithFileUploads;

    protected $listeners = ['editItem' => 'edit'];

    public $product_id;
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
    public $unit_ar = '';
    public $unit_en = '';
    public $weight = '';
    public $is_active = true;
    public $is_featured = false;
    public $track_stock = true;
    public $sort_order = 0;
    public $newImages = [];
    public $existingImages = [];

    public function edit($id)
    {
        $product = Product::with('images')->find($id);

        if (!$product) {
            $this->dispatch('somethingFailed');
            return;
        }

        $this->product_id = $product->id;
        $this->name_ar = $product->getTranslation('name', 'ar');
        $this->name_en = $product->getTranslation('name', 'en');
        $this->description_ar = $product->getTranslation('description', 'ar') ?? '';
        $this->description_en = $product->getTranslation('description', 'en') ?? '';
        $this->sku = $product->sku ?? '';
        $this->barcode = $product->barcode ?? '';
        $this->brand_id = $product->brand_id ?? '';
        $this->category_id = $product->category_id ?? '';
        $this->price = $product->price;
        $this->sale_price = $product->sale_price ?? '';
        $this->cost_price = $product->cost_price ?? '';
        $this->stock_quantity = $product->stock_quantity;
        $this->min_order_quantity = $product->min_order_quantity;
        $this->max_order_quantity = $product->max_order_quantity ?? '';
        $this->unit_ar = $product->getTranslation('unit', 'ar') ?? '';
        $this->unit_en = $product->getTranslation('unit', 'en') ?? '';
        $this->weight = $product->weight ?? '';
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->track_stock = $product->track_stock;
        $this->sort_order = $product->sort_order;
        $this->existingImages = $product->images->toArray();
        $this->newImages = [];

        $this->dispatch('updateModalToggle');
    }

    public function updatedNewImages()
    {
        $this->validate([
            'newImages.*' => 'image|max:2048',
        ]);
    }

    public function removeNewImage($index)
    {
        array_splice($this->newImages, $index, 1);
    }

    public function deleteExistingImage($imageId)
    {
        $image = ProductImage::find($imageId);
        if ($image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
            $this->existingImages = array_filter($this->existingImages, fn($img) => $img['id'] != $imageId);
            $this->existingImages = array_values($this->existingImages);
        }
    }

    public function setPrimaryImage($imageId)
    {
        ProductImage::where('product_id', $this->product_id)->update(['is_primary' => false]);
        ProductImage::where('id', $imageId)->update(['is_primary' => true]);

        foreach ($this->existingImages as &$img) {
            $img['is_primary'] = ($img['id'] == $imageId);
        }
    }

    public function submit()
    {
        $this->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'sku' => 'nullable|string|max:50|unique:products,sku,' . $this->product_id,
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
            'newImages.*' => 'image|max:2048',
        ]);

        $product = Product::find($this->product_id);

        if (!$product) {
            $this->dispatch('somethingFailed');
            return;
        }

        $product->update([
            'name' => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'description' => ['ar' => $this->description_ar, 'en' => $this->description_en],
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

        // Upload new images
        if (!empty($this->newImages)) {
            $maxSortOrder = $product->images()->max('sort_order') ?? -1;
            foreach ($this->newImages as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image' => $path,
                    'is_primary' => false,
                    'sort_order' => $maxSortOrder + $index + 1,
                ]);
            }
        }

        $this->dispatch('updateModalToggle');
        $this->dispatch('success', __('dashboard.item_updated_successfully'));
        $this->dispatch('refreshData');

        $this->reset();
    }

    public function render()
    {
        $categories = Category::active()->ordered()->get();
        $brands = Brand::active()->ordered()->get();

        return view('dashboard.products.update-product', compact('categories', 'brands'));
    }
}
