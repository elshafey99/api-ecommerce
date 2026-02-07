<x-createcomponent title="{{ __('dashboard.create-branch') }}" class="btn-success">
    <div class="row">
        {{-- Name Fields --}}
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
                placeholder="{{ __('dashboard.name_en') }}" dir="ltr">
            @error('name_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Address Fields --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.address_ar') }}</label>
            <textarea class="form-control @error('address_ar') is-invalid @enderror" wire:model="address_ar"
                placeholder="{{ __('dashboard.address_ar') }}" rows="2" dir="rtl"></textarea>
            @error('address_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.address_en') }}</label>
            <textarea class="form-control @error('address_en') is-invalid @enderror" wire:model="address_en"
                placeholder="{{ __('dashboard.address_en') }}" rows="2" dir="ltr"></textarea>
            @error('address_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Contact Fields --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.phone') }}</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" wire:model="phone"
                placeholder="{{ __('dashboard.phone') }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.whatsapp') }}</label>
            <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" wire:model="whatsapp"
                placeholder="{{ __('dashboard.whatsapp') }}">
            @error('whatsapp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.email') }}</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email"
                placeholder="{{ __('dashboard.email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Location Map Picker --}}
        <div class="col-12 mb-3">
            <label class="form-label">{{ __('dashboard.select_location') }}</label>
            <div id="createMap" style="height: 300px; border-radius: 8px; border: 1px solid #ddd;"></div>
            <small class="text-muted">{{ __('dashboard.click_map_to_select') }}</small>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.latitude') }}</label>
            <input type="number" step="0.00000001" class="form-control @error('latitude') is-invalid @enderror"
                wire:model="latitude" id="createLatitude" placeholder="30.0444" readonly>
            @error('latitude')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.longitude') }}</label>
            <input type="number" step="0.00000001" class="form-control @error('longitude') is-invalid @enderror"
                wire:model="longitude" id="createLongitude" placeholder="31.2357" readonly>
            @error('longitude')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Delivery Fields --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.delivery_fee') }}</label>
            <div class="input-group">
                <input type="number" step="0.01" class="form-control @error('delivery_fee') is-invalid @enderror"
                    wire:model="delivery_fee" placeholder="0.00" min="0">
                <span class="input-group-text">{{ __('dashboard.currency') }}</span>
            </div>
            @error('delivery_fee')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.min_order_amount') }}</label>
            <div class="input-group">
                <input type="number" step="0.01"
                    class="form-control @error('min_order_amount') is-invalid @enderror" wire:model="min_order_amount"
                    placeholder="0.00" min="0">
                <span class="input-group-text">{{ __('dashboard.currency') }}</span>
            </div>
            @error('min_order_amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.free_delivery_threshold') }}</label>
            <div class="input-group">
                <input type="number" step="0.01"
                    class="form-control @error('free_delivery_threshold') is-invalid @enderror"
                    wire:model="free_delivery_threshold" placeholder="0.00" min="0">
                <span class="input-group-text">{{ __('dashboard.currency') }}</span>
            </div>
            @error('free_delivery_threshold')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Working Hours --}}
        <div class="col-12 mb-3">
            <label class="form-label fw-bold">{{ __('dashboard.working_hours') }}</label>
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 25%;">{{ __('dashboard.day') }}</th>
                            <th style="width: 15%;" class="text-center">{{ __('dashboard.closed') }}</th>
                            <th style="width: 30%;">{{ __('dashboard.open_time') }}</th>
                            <th style="width: 30%;">{{ __('dashboard.close_time') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                            <tr
                                class="{{ isset($working_hours[$day]['closed']) && $working_hours[$day]['closed'] ? 'table-secondary' : '' }}">
                                <td class="align-middle">{{ __('dashboard.' . $day) }}</td>
                                <td class="text-center align-middle">
                                    <div class="form-check d-flex justify-content-center">
                                        <input type="checkbox" class="form-check-input"
                                            wire:model.live="working_hours.{{ $day }}.closed">
                                    </div>
                                </td>
                                <td>
                                    <input type="time" class="form-control form-control-sm"
                                        wire:model="working_hours.{{ $day }}.open"
                                        {{ isset($working_hours[$day]['closed']) && $working_hours[$day]['closed'] ? 'disabled' : '' }}>
                                </td>
                                <td>
                                    <input type="time" class="form-control form-control-sm"
                                        wire:model="working_hours.{{ $day }}.close"
                                        {{ isset($working_hours[$day]['closed']) && $working_hours[$day]['closed'] ? 'disabled' : '' }}>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Settings --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.sort_order') }}</label>
            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                wire:model="sort_order" placeholder="0" min="0">
            @error('sort_order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.status') }}</label>
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" wire:model="is_active" id="statusSwitch">
                <label class="form-check-label" for="statusSwitch">
                    {{ $is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                </label>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.main_branch') }}</label>
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" wire:model="is_main" id="mainSwitch">
                <label class="form-check-label" for="mainSwitch">
                    {{ $is_main ? __('dashboard.yes') : __('dashboard.no') }}
                </label>
            </div>
        </div>
    </div>
</x-createcomponent>
