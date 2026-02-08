<x-createcomponent title="{{ __('dashboard.create-faq') }}" class="btn-success" size="modal-lg">
    <div class="row">
        {{-- Question AR --}}
        <div class="col-md-12 mb-3">
            <label class="form-label">{{ __('dashboard.question-ar') }} <span class="text-danger">*</span></label>
            <textarea class="form-control @error('question_ar') is-invalid @enderror" wire:model="question_ar"
                placeholder="{{ __('dashboard.question-ar') }}" dir="rtl" rows="2"></textarea>
            @error('question_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Question EN --}}
        <div class="col-md-12 mb-3">
            <label class="form-label">{{ __('dashboard.question-en') }} <span class="text-danger">*</span></label>
            <textarea class="form-control @error('question_en') is-invalid @enderror" wire:model="question_en"
                placeholder="{{ __('dashboard.question-en') }}" dir="ltr" rows="2"></textarea>
            @error('question_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Answer AR --}}
        <div class="col-md-12 mb-3">
            <label class="form-label">{{ __('dashboard.answer-ar') }} <span class="text-danger">*</span></label>
            <textarea class="form-control @error('answer_ar') is-invalid @enderror" wire:model="answer_ar"
                placeholder="{{ __('dashboard.answer-ar') }}" dir="rtl" rows="4"></textarea>
            @error('answer_ar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Answer EN --}}
        <div class="col-md-12 mb-3">
            <label class="form-label">{{ __('dashboard.answer-en') }} <span class="text-danger">*</span></label>
            <textarea class="form-control @error('answer_en') is-invalid @enderror" wire:model="answer_en"
                placeholder="{{ __('dashboard.answer-en') }}" dir="ltr" rows="4"></textarea>
            @error('answer_en')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Category --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">{{ __('dashboard.category') }} <span class="text-danger">*</span></label>
            <select class="form-select @error('category') is-invalid @enderror" wire:model="category">
                @foreach ($categories as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            @error('category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
                <input class="form-check-input" type="checkbox" wire:model="is_active" id="statusSwitch">
                <label class="form-check-label" for="statusSwitch">
                    {{ $is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                </label>
            </div>
        </div>
    </div>
</x-createcomponent>
