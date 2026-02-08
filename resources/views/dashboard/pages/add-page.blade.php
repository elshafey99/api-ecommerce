<x-createcomponent title="{{ __('dashboard.create-page') }}" class="btn-success" size="modal-xl">
    <div class="row">
        {{-- Title AR --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.title-ar') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('title_ar') is-invalid @enderror" wire:model="title_ar"
                placeholder="{{ __('dashboard.title-ar') }}" dir="rtl">
            @error('title_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Title EN --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.title-en') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('title_en') is-invalid @enderror"
                wire:model.live="title_en" placeholder="{{ __('dashboard.title-en') }}" dir="ltr">
            @error('title_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Slug --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.slug') }} <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" wire:model="slug"
                placeholder="about-us" dir="ltr">
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">{{ __('dashboard.slug_auto_generated') }}</small>
        </div>

        {{-- Sort Order --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.sort_order') }}</label>
            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" wire:model="sort_order"
                placeholder="0" min="0">
            @error('sort_order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.status') }}</label>
            <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" wire:model="is_active" id="createStatusSwitch">
                <label class="form-check-label" for="createStatusSwitch">
                    {{ $is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                </label>
            </div>
        </div>

        {{-- Content AR --}}
        <div class="col-md-12 mb-3" wire:ignore>
            <label class="form-label">{{ __('dashboard.content-ar') }} <span class="text-danger">*</span></label>
            <textarea id="create_content_ar" class="form-control @error('content_ar') is-invalid @enderror" dir="rtl"
                rows="6"></textarea>
            @error('content_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Content EN --}}
        <div class="col-md-12 mb-3" wire:ignore>
            <label class="form-label">{{ __('dashboard.content-en') }} <span class="text-danger">*</span></label>
            <textarea id="create_content_en" class="form-control @error('content_en') is-invalid @enderror" dir="ltr"
                rows="6"></textarea>
            @error('content_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <hr class="my-3">
        <h6 class="mb-3"><i class="fa-solid fa-magnifying-glass me-1"></i> SEO</h6>

        {{-- Meta Title AR --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.meta_title-ar') }}</label>
            <input type="text" class="form-control @error('meta_title_ar') is-invalid @enderror"
                wire:model="meta_title_ar" placeholder="{{ __('dashboard.meta_title-ar') }}" dir="rtl">
            @error('meta_title_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Meta Title EN --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.meta_title-en') }}</label>
            <input type="text" class="form-control @error('meta_title_en') is-invalid @enderror"
                wire:model="meta_title_en" placeholder="{{ __('dashboard.meta_title-en') }}" dir="ltr">
            @error('meta_title_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Meta Description AR --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.meta_description-ar') }}</label>
            <textarea class="form-control @error('meta_description_ar') is-invalid @enderror" wire:model="meta_description_ar"
                placeholder="{{ __('dashboard.meta_description-ar') }}" dir="rtl" rows="3"></textarea>
            @error('meta_description_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Meta Description EN --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.meta_description-en') }}</label>
            <textarea class="form-control @error('meta_description_en') is-invalid @enderror" wire:model="meta_description_en"
                placeholder="{{ __('dashboard.meta_description-en') }}" dir="ltr" rows="3"></textarea>
            @error('meta_description_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</x-createcomponent>
