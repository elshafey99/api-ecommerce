<div>
    <style>
        .view-product-container {
            font-family: 'Cairo', sans-serif;
        }

        /* Card Headers */
        .card-header {
            border-radius: 12px 12px 0 0 !important;
        }

        /* Product Image Wrapper */
        .product-image-wrapper {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 1rem;
            text-align: center;
        }

        .product-image-main {
            max-height: 400px;
            width: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .product-image-main:hover {
            transform: scale(1.02);
        }

        .product-thumbnail-wrapper {
            display: flex;
            gap: 10px;
            margin-top: 1rem;
            justify-content: center;
        }

        .product-thumbnail {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .product-thumbnail:hover,
        .product-thumbnail.active {
            border-color: #7367f0;
            transform: translateY(-2px);
        }

        /* Product Details */
        .product-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #5e5873;
            margin-bottom: 0.5rem;
        }

        .product-subtitle {
            font-size: 1rem;
            color: #b9b9c3;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .price-display {
            display: flex;
            align-items: baseline;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .price-current {
            font-size: 2rem;
            font-weight: 800;
            color: #7367f0;
        }

        .price-old {
            font-size: 1.25rem;
            color: #b9b9c3;
            text-decoration: line-through;
        }

        /* Status Badges */
        .status-badges-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Info Boxes */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .info-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            border-left: 4px solid #7367f0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .info-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            background: #fff;
        }

        .info-label {
            display: block;
            font-size: 0.75rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #5e5873;
        }

        .info-value code {
            color: #7367f0;
            background: rgba(115, 103, 240, 0.1);
            padding: 0.1rem 0.3rem;
            border-radius: 4px;
        }

        /* Description Card */
        .description-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e9ecef;
        }

        .description-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #5e5873;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>

    <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true" style="display: none;" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content view-product-container border-0 shadow-lg" style="border-radius: 16px;">
                <div class="modal-header bg-white border-bottom py-3">
                    <h5 class="modal-title fw-bold text-primary">
                        <i class="fas fa-box-open me-2"></i>{{ __('dashboard.view-product') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    @if ($product)
                        <div class="row g-4">
                            {{-- Left Column: Images --}}
                            <div class="col-lg-5">
                                <div class="product-image-wrapper">
                                    @if (count($images) > 0)
                                        @php
                                            $primaryImage =
                                                collect($images)->firstWhere('is_primary', true) ?? $images[0];
                                        @endphp
                                        <img src="{{ asset('storage/' . $primaryImage['image']) }}"
                                            alt="{{ $product->name }}" class="product-image-main">

                                        @if (count($images) > 1)
                                            <div class="product-thumbnail-wrapper">
                                                @foreach ($images as $image)
                                                    <img src="{{ asset('storage/' . $image['image']) }}"
                                                        alt="{{ $product->name }}"
                                                        class="product-thumbnail {{ $image['is_primary'] ? 'active' : '' }}"
                                                        onclick="this.closest('.product-image-wrapper').querySelector('.product-image-main').src = this.src">
                                                @endforeach
                                            </div>
                                        @endif
                                    @else
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="height: 300px; background: #f8f9fa;">
                                            <div class="text-center text-muted">
                                                <i class="fas fa-image fa-4x mb-2 opacity-50"></i>
                                                <p>No Image Available</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Right Column: Details --}}
                            <div class="col-lg-7">
                                {{-- Title & Category --}}
                                <h2 class="product-title">{{ $product->getTranslation('name', 'ar') }}</h2>
                                <h4 class="product-subtitle">{{ $product->getTranslation('name', 'en') }}</h4>

                                {{-- Price --}}
                                <div class="price-display">
                                    @if ($product->sale_price)
                                        <span class="price-current">{{ number_format($product->sale_price, 2) }}
                                            <small>{{ __('dashboard.currency') }}</small></span>
                                        <span class="price-old">{{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="price-current">{{ number_format($product->price, 2) }}
                                            <small>{{ __('dashboard.currency') }}</small></span>
                                    @endif
                                </div>

                                {{-- Badges --}}
                                <div class="status-badges-wrapper">
                                    <span
                                        class="status-badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        <i
                                            class="fas {{ $product->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                        {{ $product->is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                                    </span>

                                    @if ($product->is_featured)
                                        <span class="status-badge bg-warning text-dark">
                                            <i class="fas fa-star"></i>
                                            {{ __('dashboard.featured') }}
                                        </span>
                                    @endif

                                    @if ($product->category)
                                        <span class="status-badge bg-info">
                                            <i class="fas fa-folder"></i>
                                            {{ $product->category->name }}
                                        </span>
                                    @endif

                                    @if ($product->brand)
                                        <span class="status-badge bg-primary">
                                            <i class="fas fa-tag"></i>
                                            {{ $product->brand->name }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Info Boxes --}}
                                <div class="info-grid">
                                    @if ($product->sku)
                                        <div class="info-box">
                                            <span class="info-label">{{ __('dashboard.sku') }}</span>
                                            <div class="info-value"><code>{{ $product->sku }}</code></div>
                                        </div>
                                    @endif

                                    @if ($product->barcode)
                                        <div class="info-box" style="border-left-color: #28c76f;">
                                            <span class="info-label">{{ __('dashboard.barcode') }}</span>
                                            <div class="info-value"><code>{{ $product->barcode }}</code></div>
                                        </div>
                                    @endif

                                    <div class="info-box" style="border-left-color: #ea5455;">
                                        <span class="info-label">{{ __('dashboard.stock_quantity') }}</span>
                                        <div class="info-value">
                                            @if ($product->track_stock)
                                                <span
                                                    class="{{ $product->stock_quantity <= 5 ? 'text-danger' : 'text-success' }}">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            @else
                                                <span class="text-success">{{ __('dashboard.unlimited') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($product->weight)
                                        <div class="info-box" style="border-left-color: #ff9f43;">
                                            <span class="info-label">{{ __('dashboard.weight') }}</span>
                                            <div class="info-value">{{ $product->weight }} {{ __('dashboard.kg') }}
                                            </div>
                                        </div>
                                    @endif

                                    @if ($product->cost_price)
                                        <div class="info-box" style="border-left-color: #6c757d;">
                                            <span class="info-label">{{ __('dashboard.cost_price') }}</span>
                                            <div class="info-value">{{ number_format($product->cost_price, 2) }}
                                                {{ __('dashboard.currency') }}</div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Description --}}
                                @if ($product->getTranslation('description', 'ar') || $product->getTranslation('description', 'en'))
                                    <div class="description-card">
                                        <h6 class="description-title">
                                            <i class="fas fa-align-left text-primary"></i>
                                            {{ __('dashboard.description') }}
                                        </h6>
                                        @if ($product->getTranslation('description', 'ar'))
                                            <p class="text-muted mb-2" dir="rtl" style="line-height: 1.6;">
                                                {{ $product->getTranslation('description', 'ar') }}
                                            </p>
                                        @endif
                                        @if ($product->getTranslation('description', 'en'))
                                            <p class="text-muted mb-0" style="line-height: 1.6;">
                                                {{ $product->getTranslation('description', 'en') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-spinner fa-spin fa-3x mb-3 text-primary"></i>
                            <h5 class="text-muted">Loading product details...</h5>
                        </div>
                    @endif
                </div>
                <div class="modal-footer bg-white border-top py-3">
                    <button type="button" class="btn btn-outline-secondary px-4 fw-bold" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>{{ __('dashboard.close') }}
                    </button>
                    @if ($product)
                        <button type="button" class="btn btn-primary px-4 fw-bold"
                            onclick="Livewire.dispatch('editItem', { id: {{ $product->id }} })"
                            data-bs-dismiss="modal">
                            <i class="fas fa-edit me-2"></i>{{ __('dashboard.edit') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('viewModalToggle', (event) => {
                var modalElement = document.getElementById('viewModal');
                if (!modalElement) return;

                // Move modal to body to avoid z-index/overflow issues
                if (modalElement.parentElement !== document.body) {
                    document.body.appendChild(modalElement);
                }

                var myModal = bootstrap.Modal.getOrCreateInstance(modalElement);
                myModal.show();
            });
        });
    </script>
</div>
