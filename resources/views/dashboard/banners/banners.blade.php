<div>
    <div class="card-body pb-0">
        <div class="row">
            <div class="col-md-4 col-12 mb-2">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i data-feather="search"></i></span>
                    <input wire:model.live="search" type="text" class="form-control"
                        placeholder="{{ __('dashboard.search') }}">
                </div>
            </div>
            <div class="col-md-3 col-12 mb-2">
                <select wire:model.live="position" class="form-select">
                    <option value="">{{ __('dashboard.all_positions') }}</option>
                    @foreach ($positions as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" style="width: 5%;">#</th>
                    <th class="align-middle" style="width: 10%;">{{ __('dashboard.image') }}</th>
                    <th class="align-middle" style="width: 20%;">{{ __('dashboard.title') }}</th>
                    <th class="align-middle" style="width: 15%;">{{ __('dashboard.position') }}</th>
                    <th class="align-middle" style="width: 20%;">{{ __('dashboard.dates') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.status') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="banner-{{ $item->id }}" style="height: 80px;">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>
                            <td class="align-middle">
                                @if ($item->image)
                                    <img src="{{ asset($item->image) }}" alt="Banner" class="rounded"
                                        style="width: 60px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="avatar bg-light-primary rounded" style="width: 60px; height: 40px;">
                                        <div class="avatar-content">
                                            <i data-feather="image" class="font-medium-3"></i>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="align-middle">
                                <strong
                                    class="text-primary d-block">{{ $item->getTranslation('title', 'ar') ?: '-' }}</strong>
                                <small class="text-muted">{{ $item->getTranslation('title', 'en') ?: '-' }}</small>
                            </td>
                            <td class="align-middle">
                                @switch($item->position)
                                    @case('home_slider')
                                        <span class="badge bg-info">{{ $positions[$item->position] ?? $item->position }}</span>
                                    @break

                                    @case('home_banner')
                                        <span
                                            class="badge bg-primary">{{ $positions[$item->position] ?? $item->position }}</span>
                                    @break

                                    @case('category_banner')
                                        <span
                                            class="badge bg-success">{{ $positions[$item->position] ?? $item->position }}</span>
                                    @break

                                    @default
                                        <span class="badge bg-info">{{ $positions[$item->position] ?? $item->position }}</span>
                                @endswitch
                            </td>
                            <td class="align-middle">
                                <small>
                                    @if ($item->start_date)
                                        <span class="text-success">{{ __('dashboard.start-date') }}:
                                            {{ $item->start_date->format('Y-m-d') }}</span><br>
                                    @endif
                                    @if ($item->end_date)
                                        <span class="text-danger">{{ __('dashboard.end-date') }}:
                                            {{ $item->end_date->format('Y-m-d') }}</span>
                                    @endif
                                    @if (!$item->start_date && !$item->end_date)
                                        <span class="text-muted">{{ __('dashboard.unlimited') }}</span>
                                    @endif
                                </small>
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
                        <td colspan="7" class="text-center align-middle">
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
