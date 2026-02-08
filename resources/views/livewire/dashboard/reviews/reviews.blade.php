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
            <div class="col-md-8 col-12 mb-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'all' ? 'active' : '' }}" href="#"
                            wire:click.prevent="$set('filter', 'all')">
                            {{ __('dashboard.all') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'approved' ? 'active' : '' }}" href="#"
                            wire:click.prevent="$set('filter', 'approved')">
                            {{ __('dashboard.approved') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $filter === 'pending' ? 'active' : '' }}" href="#"
                            wire:click.prevent="$set('filter', 'pending')">
                            {{ __('dashboard.pending') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-light">
                <tr>
                    <th class="text-center align-middle" style="width: 5%;">#</th>
                    <th class="align-middle" style="width: 15%;">{{ __('dashboard.user') }}</th>
                    <th class="align-middle" style="width: 20%;">{{ __('dashboard.product') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.rating') }}</th>
                    <th class="align-middle" style="width: 30%;">{{ __('dashboard.comment') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.date') }}</th>
                    <th class="text-center align-middle" style="width: 10%;">{{ __('dashboard.status') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($data->count() > 0)
                    @foreach ($data as $item)
                        <tr wire:key="review-{{ $item->id }}">
                            <td class="text-center align-middle">
                                <span
                                    class="fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <strong
                                            class="text-primary">{{ $item->user->name ?? __('dashboard.no-user') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $item->user->email ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <strong>{{ $item->product->name ?? __('dashboard.no-product') }}</strong>
                            </td>
                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $item->rating)
                                            <i class="fa-solid fa-star text-warning"></i>
                                        @else
                                            <i class="fa-regular fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                </div>
                                <small class="text-muted">({{ $item->rating }}/5)</small>
                            </td>
                            <td class="align-middle">
                                <span class="text-muted">{{ Str::limit($item->comment ?? '-', 100) }}</span>
                            </td>
                            <td class="text-center align-middle">
                                <small class="text-muted">{{ $item->created_at->format('Y-m-d') }}</small>
                            </td>
                            <td class="text-center align-middle">
                                <div class="form-check form-switch d-flex justify-content-center">
                                    <input class="form-check-input" type="checkbox"
                                        wire:click="toggleApproval({{ $item->id }})"
                                        {{ $item->is_approved ? 'checked' : '' }}
                                        title="{{ $item->is_approved ? __('dashboard.approved') : __('dashboard.pending') }}">
                                </div>
                                <small class="text-muted">
                                    {{ $item->is_approved ? __('dashboard.approved') : __('dashboard.pending') }}
                                </small>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center align-middle" style="height: 80px;">
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
