<div>
    <div class="card-body pb-0">
        <div class="row">
            <div class="col-md-3 col-12 mb-2">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i data-feather="search"></i></span>
                    <input wire:model.live="search" type="text" class="form-control"
                        placeholder="{{ __('dashboard.search') }}">
                </div>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <select wire:model.live="categoryFilter" class="form-select">
                    <option value="">{{ __('dashboard.all_categories') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <select wire:model.live="brandFilter" class="form-select">
                    <option value="">{{ __('dashboard.all_brands') }}</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 col-6 mb-2">
                <select wire:model.live="statusFilter" class="form-select">
                    <option value="">{{ __('dashboard.all_statuses') }}</option>
                    <option value="1">{{ __('dashboard.active') }}</option>
                    <option value="0">{{ __('dashboard.inactive') }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" style="width: 5%;">#</th>
                    <th class="text-center align-middle" style="width: 8%;">{{ __('dashboard.image') }}</th>
                    <th class="align-middle" style="width: 18%;">{{ __('dashboard.name_ar') }}</th>
                    <th class="align-middle" style="width: 12%;">{{ __('dashboard.category') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.price') }}</th>
                    <th class="text-center align-middle" style="width: 8%;">{{ __('dashboard.stock') }}</th>
                    <th class="text-center align-middle" style="width: 8%;">{{ __('dashboard.featured') }}</th>
                    <th class="text-center align-middle" style="width: 8%;">{{ __('dashboard.status') }}</th>
                    <th class="text-center align-middle" style="width: 15%;">{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="product-{{ $item->id }}" style="height: 80px;">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>
                            <td class="text-center align-middle">
                                @if ($item->primaryImage)
                                    <img src="{{ asset('storage/' . $item->primaryImage->image) }}"
                                        alt="{{ $item->name }}" class="rounded"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="avatar bg-light-primary rounded" style="width: 50px; height: 50px;">
                                        <div class="avatar-content">
                                            <i data-feather="image" class="font-medium-3"></i>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="align-middle">
                                <strong class="text-primary">{{ $item->getTranslation('name', 'ar') }}</strong>
                                @if ($item->sku)
                                    <br><small class="text-muted">SKU: {{ $item->sku }}</small>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if ($item->category)
                                    <span class="badge bg-light-success">{{ $item->category->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                                @if ($item->brand)
                                    <br><small class="text-muted">{{ $item->brand->name }}</small>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                @if ($item->sale_price)
                                    <span
                                        class="text-decoration-line-through text-muted">{{ number_format($item->price, 2) }}</span>
                                    <br><span
                                        class="text-danger fw-bold">{{ number_format($item->sale_price, 2) }}</span>
                                @else
                                    <span class="fw-bold">{{ number_format($item->price, 2) }}</span>
                                @endif
                                <small>{{ __('dashboard.currency') }}</small>
                            </td>
                            <td class="text-center align-middle">
                                @if ($item->track_stock)
                                    <span
                                        class="badge rounded-pill {{ $item->stock_quantity > 10 ? 'bg-success' : ($item->stock_quantity > 0 ? 'bg-warning' : 'bg-danger') }}">
                                        {{ $item->stock_quantity }}
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-secondary">∞</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox"
                                        wire:click="toggleFeatured({{ $item->id }})"
                                        {{ $item->is_featured ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox"
                                        wire:click="toggleStatus({{ $item->id }})"
                                        {{ $item->is_active ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <button type="button"
                                        onclick="Livewire.dispatch('viewItem', { id: {{ $item->id }} })"
                                        title="{{ __('dashboard.view') }}"
                                        class="btn btn-icon rounded-circle btn-sm btn-info action-btn">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button type="button"
                                        onclick="Livewire.dispatch('editItem', { id: {{ $item->id }} })"
                                        title="{{ __('dashboard.update') }}"
                                        class="btn btn-icon rounded-circle btn-sm btn-warning action-btn">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button type="button"
                                        onclick="Livewire.dispatch('deleteConfirm', { id: {{ $item->id }} })"
                                        title="{{ __('dashboard.delete') }}"
                                        class="btn btn-icon rounded-circle btn-sm btn-danger action-btn">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr style="height: 80px;">
                        <td colspan="9" class="text-center align-middle">
                            <div class="text-muted">
                                <i data-feather="inbox" class="mb-1"></i>
                                <p class="mb-0">{{ __('dashboard.no-data') }}</p>
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="mt-3">
            {{ $data->links() }}
        </div>
    </div>
</div>
