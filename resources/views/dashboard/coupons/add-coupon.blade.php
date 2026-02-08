<x-createcomponent title="{{ __('dashboard.create-coupon') }}" class="btn-success" size="modal-xl">
    <div class="row">
        {{-- Coupon Code --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.coupon_code') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('code') is-invalid @enderror" wire:model="code"
                placeholder="SUMMER2024" style="text-transform: uppercase;">
            @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Discount Type --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.discount_type') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('discount_type') is-invalid @enderror" wire:model.live="discount_type">
                <option value="percentage">{{ __('dashboard.percentage') }}</option>
                <option value="fixed">{{ __('dashboard.fixed') }}</option>
            </select>
            @error('discount_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Discount Value --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.discount_value') }} <span class="text-danger">*</span></label>
            <div class="input-group">
                <input type="number" step="0.01" min="0"
                    class="form-control @error('discount_value') is-invalid @enderror" wire:model="discount_value"
                    placeholder="10">
                <span class="input-group-text">{{ $discount_type === 'percentage' ? '%' : 'EGP' }}</span>
            </div>
            @error('discount_value')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Name AR --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.name-ar') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name_ar') is-invalid @enderror" wire:model="name_ar"
                placeholder="{{ __('dashboard.name-ar') }}" dir="rtl">
            @error('name_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Name EN --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.name-en') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('name_en') is-invalid @enderror" wire:model="name_en"
                placeholder="{{ __('dashboard.name-en') }}" dir="ltr">
            @error('name_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description AR --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.description-ar') }}</label>
            <textarea class="form-control @error('description_ar') is-invalid @enderror" wire:model="description_ar"
                placeholder="{{ __('dashboard.description-ar') }}" dir="rtl" rows="3"></textarea>
            @error('description_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Description EN --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.description-en') }}</label>
            <textarea class="form-control @error('description_en') is-invalid @enderror" wire:model="description_en"
                placeholder="{{ __('dashboard.description-en') }}" dir="ltr" rows="3"></textarea>
            @error('description_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <hr class="my-3">
        <h6 class="mb-3"><i class="fa-solid fa-sliders me-1"></i> {{ __('dashboard.limits_and_conditions') }}</h6>

        {{-- Min Order Amount --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.min_order_amount') }}</label>
            <input type="number" step="0.01" min="0"
                class="form-control @error('min_order_amount') is-invalid @enderror" wire:model="min_order_amount"
                placeholder="0.00">
            @error('min_order_amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Max Discount Amount --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.max_discount_amount') }}</label>
            <input type="number" step="0.01" min="0"
                class="form-control @error('max_discount_amount') is-invalid @enderror" wire:model="max_discount_amount"
                placeholder="0.00">
            @error('max_discount_amount')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Usage Limit --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.usage_limit') }}</label>
            <input type="number" min="1" class="form-control @error('usage_limit') is-invalid @enderror"
                wire:model="usage_limit" placeholder="∞">
            @error('usage_limit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">{{ __('dashboard.leave_empty_unlimited') }}</small>
        </div>

        {{-- Usage Limit Per User --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.usage_limit_per_user') }} <span
                    class="text-danger">*</span></label>
            <input type="number" min="1"
                class="form-control @error('usage_limit_per_user') is-invalid @enderror"
                wire:model="usage_limit_per_user" placeholder="1">
            @error('usage_limit_per_user')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Start Date --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.start_date') }}</label>
            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                wire:model="start_date">
            @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- End Date --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.end_date') }}</label>
            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                wire:model="end_date">
            @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status --}}
        <div class="col-md-12 mb-3">
            <label class="form-label">{{ __('dashboard.status') }}</label>
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" wire:model="is_active" id="createStatusSwitch">
                <label class="form-check-label" for="createStatusSwitch">
                    {{ $is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                </label>
            </div>
        </div>
    </div>
</x-createcomponent>
