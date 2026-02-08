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
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.icon') }}</th>
                    <th class="align-middle" style="width: 15%;">{{ __('dashboard.code') }}</th>
                    <th class="align-middle" style="width: 20%;">{{ __('dashboard.name_ar') }}</th>
                    <th class="align-middle" style="width: 20%;">{{ __('dashboard.name_en') }}</th>
                    <th class="text-center align-middle" style="width: 15%;">{{ __('dashboard.requires_proof') }}</th>
                    <th class="text-center align-middle" style="width: 15%;">{{ __('dashboard.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="pm-{{ $item->id }}" style="height: 70px;">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>
                            <td class="text-center align-middle">
                                @if ($item->icon)
                                    <img src="{{ asset('storage/' . $item->icon) }}" alt="{{ $item->code }}"
                                        class="rounded" style="width: 40px; height: 40px; object-fit: contain;">
                                @else
                                    <span class="badge bg-light-secondary">
                                        <i data-feather="credit-card"></i>
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <code class="text-primary">{{ $item->code }}</code>
                            </td>
                            <td class="align-middle">
                                <strong>{{ $item->getTranslation('name', 'ar') }}</strong>
                            </td>
                            <td class="align-middle">
                                <span>{{ $item->getTranslation('name', 'en') }}</span>
                            </td>
                            <td class="text-center align-middle">
                                @if ($item->requires_payment_proof)
                                    <span class="badge bg-warning">{{ __('dashboard.yes') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('dashboard.no') }}</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox"
                                        wire:click="toggleStatus({{ $item->id }})"
                                        {{ $item->is_active ? 'checked' : '' }}>
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
