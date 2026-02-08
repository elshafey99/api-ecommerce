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
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" style="width: 5%;">#</th>
                    <th class="align-middle" style="width: 30%;">{{ __('dashboard.title') }}</th>
                    <th class="align-middle" style="width: 20%;">{{ __('dashboard.slug') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.sort_order') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.status') }}</th>
                    <th class="text-center align-middle" style="width: 15%;">{{ __('dashboard.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="page-{{ $item->id }}" style="height: 80px;">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>
                            <td class="align-middle">
                                <strong
                                    class="text-primary">{{ Str::limit($item->getTranslation('title', 'ar'), 50) }}</strong>
                                <br>
                                <small
                                    class="text-muted">{{ Str::limit($item->getTranslation('title', 'en'), 40) }}</small>
                            </td>
                            <td class="align-middle">
                                <span class="badge bg-light-secondary text-dark">{{ $item->slug }}</span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge bg-light-secondary">{{ $item->sort_order }}</span>
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
                        <td colspan="6" class="text-center align-middle">
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
