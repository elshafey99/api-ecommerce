<x-updatecomponent title="{{ __('dashboard.update-banner') }}" size="modal-xl">
    <div class="row">
        {{-- Image Upload --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.image') }}</label>
            @if ($old_image && !$image)
                <div class="mb-2">
                    <img src="{{ asset($old_image) }}" alt="Current" class="rounded"
                        style="width: 150px; height: 80px; object-fit: cover;">
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
                        style="width: 150px; height: 80px; object-fit: cover;">
                </div>
            @endif
        </div>

        {{-- Mobile Image Upload --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.mobile_image') }}</label>
            @if ($old_mobile_image && !$mobile_image)
                <div class="mb-2">
                    <img src="{{ asset($old_mobile_image) }}" alt="Current" class="rounded"
                        style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            @endif
            <input type="file" class="form-control @error('mobile_image') is-invalid @enderror"
                wire:model="mobile_image" accept="image/*">
            @error('mobile_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if ($mobile_image)
                <div class="mt-2">
                    <img src="{{ $mobile_image->temporaryUrl() }}" alt="Preview" class="rounded"
                        style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            @endif
        </div>

        {{-- Title AR --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.title-ar') }}</label>
            <input type="text" class="form-control @error('title_ar') is-invalid @enderror" wire:model="title_ar"
                placeholder="{{ __('dashboard.title-ar') }}" dir="rtl">
            @error('title_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Title EN --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.title-en') }}</label>
            <input type="text" class="form-control @error('title_en') is-invalid @enderror" wire:model="title_en"
                placeholder="{{ __('dashboard.title-en') }}" dir="ltr">
            @error('title_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Subtitle AR --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.subtitle-ar') }}</label>
            <input type="text" class="form-control @error('subtitle_ar') is-invalid @enderror"
                wire:model="subtitle_ar" placeholder="{{ __('dashboard.subtitle-ar') }}" dir="rtl">
            @error('subtitle_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Subtitle EN --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('dashboard.subtitle-en') }}</label>
            <input type="text" class="form-control @error('subtitle_en') is-invalid @enderror"
                wire:model="subtitle_en" placeholder="{{ __('dashboard.subtitle-en') }}" dir="ltr">
            @error('subtitle_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Position --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.position') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('position') is-invalid @enderror" wire:model="position">
                @foreach ($positions as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Link Type --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.link_type') }}</label>
            <select class="form-select @error('link_type') is-invalid @enderror" wire:model.live="link_type">
                @foreach ($linkTypes as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('link_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Link ID (conditional) --}}
        @if ($link_type === 'product')
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('dashboard.product') }} <span class="text-danger">*</span></label>
                <select class="form-select @error('link_id') is-invalid @enderror" wire:model="link_id">
                    <option value="">{{ __('dashboard.select-product') }}</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->getTranslation('name', app()->getLocale()) }}
                        </option>
                    @endforeach
                </select>
                @error('link_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @elseif ($link_type === 'category')
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('dashboard.category') }} <span class="text-danger">*</span></label>
                <select class="form-select @error('link_id') is-invalid @enderror" wire:model="link_id">
                    <option value="">{{ __('dashboard.select-category') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->getTranslation('name', app()->getLocale()) }}</option>
                    @endforeach
                </select>
                @error('link_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @elseif ($link_type === 'brand')
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('dashboard.brand') }} <span class="text-danger">*</span></label>
                <select class="form-select @error('link_id') is-invalid @enderror" wire:model="link_id">
                    <option value="">{{ __('dashboard.select-brand') }}</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->getTranslation('name', app()->getLocale()) }}
                        </option>
                    @endforeach
                </select>
                @error('link_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @elseif ($link_type === 'external')
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('dashboard.external_url') }} <span
                        class="text-danger">*</span></label>
                <input type="url" class="form-control @error('external_url') is-invalid @enderror"
                    wire:model="external_url" placeholder="https://..." dir="ltr">
                @error('external_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        @else
            <div class="col-md-4 mb-3"></div>
        @endif

        {{-- Start Date --}}
        <div class="col-md-3 mb-3">
            <label class="form-label">{{ __('dashboard.start-date') }}</label>
            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                wire:model="start_date">
            @error('start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- End Date --}}
        <div class="col-md-3 mb-3">
            <label class="form-label">{{ __('dashboard.end-date') }}</label>
            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                wire:model="end_date">
            @error('end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Sort Order --}}
        <div class="col-md-3 mb-3">
            <label class="form-label">{{ __('dashboard.sort_order') }}</label>
            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                wire:model="sort_order" placeholder="0" min="0">
            @error('sort_order')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status --}}
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
