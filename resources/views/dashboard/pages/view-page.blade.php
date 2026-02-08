<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">
                    <i class="fa-solid fa-eye me-2"></i>{{ __('dashboard.view') }} - {{ $title_ar }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- Page Info --}}
                    <div class="col-12 mb-4">
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <span class="badge bg-light-secondary text-dark fs-6">
                                <i class="fa-solid fa-link me-1"></i> {{ $slug }}
                            </span>
                            <span class="badge {{ $is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                            </span>
                            <span class="badge bg-light-primary">
                                <i class="fa-solid fa-sort me-1"></i> {{ __('dashboard.sort_order') }}:
                                {{ $sort_order }}
                            </span>
                        </div>
                    </div>

                    {{-- Title AR --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fa-solid fa-heading me-1"></i> {{ __('dashboard.title-ar') }}
                        </label>
                        <div class="p-3 bg-light rounded border" dir="rtl">
                            {{ $title_ar ?: '-' }}
                        </div>
                    </div>

                    {{-- Title EN --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fa-solid fa-heading me-1"></i> {{ __('dashboard.title-en') }}
                        </label>
                        <div class="p-3 bg-light rounded border" dir="ltr">
                            {{ $title_en ?: '-' }}
                        </div>
                    </div>

                    {{-- Content AR --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fa-solid fa-file-lines me-1"></i> {{ __('dashboard.content-ar') }}
                        </label>
                        <div class="p-3 bg-light rounded border content-preview" dir="rtl"
                            style="max-height: 300px; overflow-y: auto;">
                            {!! $content_ar ?: '-' !!}
                        </div>
                    </div>

                    {{-- Content EN --}}
                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fa-solid fa-file-lines me-1"></i> {{ __('dashboard.content-en') }}
                        </label>
                        <div class="p-3 bg-light rounded border content-preview" dir="ltr"
                            style="max-height: 300px; overflow-y: auto;">
                            {!! $content_en ?: '-' !!}
                        </div>
                    </div>

                    {{-- SEO Section --}}
                    @if ($meta_title_ar || $meta_title_en || $meta_description_ar || $meta_description_en)
                        <div class="col-12">
                            <hr>
                            <h6 class="text-secondary mb-3">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> SEO
                            </h6>
                        </div>

                        {{-- Meta Title AR --}}
                        <div class="col-md-6 mb-3">
                            <label
                                class="form-label fw-bold text-secondary">{{ __('dashboard.meta_title-ar') }}</label>
                            <div class="p-2 bg-light rounded border small" dir="rtl">
                                {{ $meta_title_ar ?: '-' }}
                            </div>
                        </div>

                        {{-- Meta Title EN --}}
                        <div class="col-md-6 mb-3">
                            <label
                                class="form-label fw-bold text-secondary">{{ __('dashboard.meta_title-en') }}</label>
                            <div class="p-2 bg-light rounded border small" dir="ltr">
                                {{ $meta_title_en ?: '-' }}
                            </div>
                        </div>

                        {{-- Meta Description AR --}}
                        <div class="col-md-6 mb-3">
                            <label
                                class="form-label fw-bold text-secondary">{{ __('dashboard.meta_description-ar') }}</label>
                            <div class="p-2 bg-light rounded border small" dir="rtl">
                                {{ $meta_description_ar ?: '-' }}
                            </div>
                        </div>

                        {{-- Meta Description EN --}}
                        <div class="col-md-6 mb-3">
                            <label
                                class="form-label fw-bold text-secondary">{{ __('dashboard.meta_description-en') }}</label>
                            <div class="p-2 bg-light rounded border small" dir="ltr">
                                {{ $meta_description_en ?: '-' }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ __('dashboard.close') }}
                </button>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('viewModalToggle', (event) => {
                var modalElement = document.getElementById('viewModal');
                if (!modalElement) return;

                // Move modal to body to avoid z-index/overflow issues
                if (modalElement.parentElement !== document.body) {
                    document.body.appendChild(modalElement);
                }

                var myModal = bootstrap.Modal.getOrCreateInstance(modalElement);
                myModal.show();
            });
        });
    </script>
</div>
