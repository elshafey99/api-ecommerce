<div>
    <div class="card-body pb-0">
        <div class="row">
            {{-- Search --}}
            <div class="col-md-4 col-12 mb-2">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i data-feather="search"></i></span>
                    <input wire:model.live="search" type="text" class="form-control"
                        placeholder="{{ __('dashboard.search') }}">
                </div>
            </div>

            {{-- Status Filter --}}
            <div class="col-md-3 col-12 mb-2">
                <select wire:model.live="statusFilter" class="form-select">
                    <option value="all">{{ __('dashboard.all_statuses') }}</option>
                    <option value="active">{{ __('dashboard.active') }}</option>
                    <option value="inactive">{{ __('dashboard.inactive') }}</option>
                </select>
            </div>

            {{-- Type Filter --}}
            <div class="col-md-3 col-12 mb-2">
                <select wire:model.live="typeFilter" class="form-select">
                    <option value="all">{{ __('dashboard.all_types') }}</option>
                    <option value="percentage">{{ __('dashboard.percentage') }}</option>
                    <option value="fixed">{{ __('dashboard.fixed') }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" style="width: 5%;">#</th>
                    <th class="align-middle" style="width: 15%;">{{ __('dashboard.coupon_code') }}</th>
                    <th class="align-middle" style="width: 20%;">{{ __('dashboard.name') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.discount_type') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.discount_value') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.usage') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.validity') }}</th>
                    <th class="text-center align-middle" style="width: 8%;">{{ __('dashboard.status') }}</th>
                    <th class="text-center align-middle" style="width: 12%;">{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="coupon-{{ $item->id }}" style="height: 80px;">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>
                            <td class="align-middle">
                                <span class="badge bg-dark fs-6">{{ $item->code }}</span>
                            </td>
                            <td class="align-middle">
                                <strong
                                    class="text-primary">{{ Str::limit($item->getTranslation('name', 'ar'), 30) }}</strong>
                                <br>
                                <small
                                    class="text-muted">{{ Str::limit($item->getTranslation('name', 'en'), 25) }}</small>
                            </td>
                            <td class="text-center align-middle">
                                @if ($item->discount_type === 'percentage')
                                    <span class="badge bg-light-info">
                                        <i class="fa-solid fa-percent me-1"></i>{{ __('dashboard.percentage') }}
                                    </span>
                                @else
                                    <span class="badge bg-light-success">
                                        <i class="fa-solid fa-dollar-sign me-1"></i>{{ __('dashboard.fixed') }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <strong class="text-success">
                                    {{ $item->discount_type === 'percentage' ? $item->discount_value . '%' : number_format($item->discount_value, 2) }}
                                </strong>
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex flex-column gap-1">
                                    <span class="badge bg-light-primary">
                                        {{ $item->used_count }} / {{ $item->usage_limit ?: '∞' }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                @if ($item->start_date || $item->end_date)
                                    <small>
                                        {{ $item->start_date?->format('Y-m-d') ?? '-' }}<br>
                                        {{ $item->end_date?->format('Y-m-d') ?? '-' }}
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
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
