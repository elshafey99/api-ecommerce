<x-createcomponent title="{{ __('dashboard.create-product') }}" size="modal-xl">
    <div class="row">
        {{-- Basic Info --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.name_ar') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name_ar') is-invalid @enderror" wire:model="name_ar"
                placeholder="{{ __('dashboard.name_ar') }}" dir="rtl">
            @error('name_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.name_en') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name_en') is-invalid @enderror" wire:model="name_en"
                placeholder="{{ __('dashboard.name_en') }}">
            @error('name_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.description_ar') }}</label>
            <textarea class="form-control @error('description_ar') is-invalid @enderror" wire:model="description_ar"
                placeholder="{{ __('dashboard.description_ar') }}" dir="rtl" rows="3"></textarea>
            @error('description_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.description_en') }}</label>
            <textarea class="form-control @error('description_en') is-invalid @enderror" wire:model="description_en"
                placeholder="{{ __('dashboard.description_en') }}" rows="3"></textarea>
            @error('description_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Category & Brand --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.category') }}</label>
            <select class="form-select @error('category_id') is-invalid @enderror" wire:model="category_id">
                <option value="">{{ __('dashboard.select_category') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.brand') }}</label>
            <select class="form-select @error('brand_id') is-invalid @enderror" wire:model="brand_id">
                <option value="">{{ __('dashboard.select_brand') }}</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
            @error('brand_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- SKU & Barcode --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.sku') }}</label>
            <input type="text" class="form-control @error('sku') is-invalid @enderror" wire:model="sku"
                placeholder="{{ __('dashboard.sku') }}">
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.barcode') }}</label>
            <input type="text" class="form-control @error('barcode') is-invalid @enderror" wire:model="barcode"
                placeholder="{{ __('dashboard.barcode') }}">
            @error('barcode')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Pricing --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.price') }} <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                    wire:model="price" placeholder="0.00" min="0">
                <span class="input-group-text">{{ __('dashboard.currency') }}</span>
            </div>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.sale_price') }}</label>
            <div class="input-group">
                <input type="number" step="0.01" class="form-control @error('sale_price') is-invalid @enderror"
                    wire:model="sale_price" placeholder="0.00" min="0">
                <span class="input-group-text">{{ __('dashboard.currency') }}</span>
            </div>
            @error('sale_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.cost_price') }}</label>
            <div class="input-group">
                <input type="number" step="0.01" class="form-control @error('cost_price') is-invalid @enderror"
                    wire:model="cost_price" placeholder="0.00" min="0">
                <span class="input-group-text">{{ __('dashboard.currency') }}</span>
            </div>
            @error('cost_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Stock --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.stock_quantity') }} <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror"
                wire:model="stock_quantity" placeholder="0" min="0">
            @error('stock_quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.min_order_quantity') }}</label>
            <input type="number" class="form-control @error('min_order_quantity') is-invalid @enderror"
                wire:model="min_order_quantity" placeholder="1" min="1">
            @error('min_order_quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.max_order_quantity') }}</label>
            <input type="number" class="form-control @error('max_order_quantity') is-invalid @enderror"
                wire:model="max_order_quantity" placeholder="{{ __('dashboard.unlimited') }}" min="1">
            @error('max_order_quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Unit & Weight --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.unit_ar') }}</label>
            <input type="text" class="form-control" wire:model="unit_ar" placeholder="قطعة" dir="rtl">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.unit_en') }}</label>
            <input type="text" class="form-control" wire:model="unit_en" placeholder="piece">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.weight') }}</label>
            <div class="input-group">
                <input type="number" step="0.001" class="form-control" wire:model="weight" placeholder="0.000"
                    min="0">
                <span class="input-group-text">{{ __('dashboard.kg') }}</span>
            </div>
        </div>

        {{-- Images --}}
        <div class="col-12 mb-3">
            <label class="form-label fw-bold">{{ __('dashboard.product_images') }}</label>
            <input type="file" class="form-control @error('images.*') is-invalid @enderror" wire:model="images"
                multiple accept="image/*">
            @error('images.*')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">{{ __('dashboard.first_image_primary') }}</small>

            @if (!empty($images))
                <div class="d-flex flex-wrap mt-2 gap-2">
                    @foreach ($images as $index => $image)
                        <div class="position-relative" style="width: 80px;">
                            <img src="{{ $image->temporaryUrl() }}" class="rounded"
                                style="width: 80px; height: 80px; object-fit: cover;">
                            @if ($index === 0)
                                <span
                                    class="position-absolute top-0 start-0 badge bg-primary">{{ __('dashboard.primary') }}</span>
                            @endif
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                wire:click="removeImage({{ $index }})"
                                style="font-size: 10px; padding: 2px 5px;">×</button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Settings --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.sort_order') }}</label>
            <input type="number" class="form-control" wire:model="sort_order" placeholder="0" min="0">
        </div>

        <div class="col-md-8 mb-3">
            <label class="form-label d-block">&nbsp;</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" wire:model="is_active" id="createActive">
                <label class="form-check-label" for="createActive">{{ __('dashboard.active') }}</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" wire:model="is_featured" id="createFeatured">
                <label class="form-check-label" for="createFeatured">{{ __('dashboard.featured') }}</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" wire:model="track_stock" id="createTrackStock">
                <label class="form-check-label" for="createTrackStock">{{ __('dashboard.track_stock') }}</label>
            </div>
        </div>
    </div>
</x-createcomponent>
