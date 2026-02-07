<x-updatecomponent title="{{ __('dashboard.update-brand') }}">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label">{{ __('dashboard.image') }}</label>

            @if ($old_image && !$image)
                <div class="mb-2">
                    <img src="{{ asset($old_image) }}" alt="Current" class="rounded"
                        style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            @endif

            <input type="file" class="form-control @error('image') is-invalid @enderror" wire:model="image"
                accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($image)
                <div class="mt-2">
                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="rounded"
                        style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            @endif
        </div>

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
            <input type="text" class="form-control @error('name_en') is-invalid @enderror" wire:model.live="name_en"
                placeholder="{{ __('dashboard.name_en') }}" dir="ltr">
            @error('name_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.slug') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" wire:model="slug"
                placeholder="{{ __('dashboard.slug') }}" dir="ltr">
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">{{ __('dashboard.slug_auto_generated') }}</small>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">{{ __('dashboard.sort_order') }}</label>
            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" wire:model="sort_order"
                placeholder="0" min="0">
            @error('sort_order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">{{ __('dashboard.status') }}</label>
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" wire:model="is_active" id="statusSwitchUpdate">
                <label class="form-check-label" for="statusSwitchUpdate">
                    {{ $is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                </label>
            </div>
        </div>
    </div>
</x-updatecomponent>
