<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">
                    <i class="fa-solid fa-ticket me-2"></i>{{ __('dashboard.view') }} - {{ $code }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- Coupon Info Badges --}}
                    <div class="col-12 mb-4">
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <span class="badge bg-dark fs-6">
                                <i class="fa-solid fa-code me-1"></i> {{ $code }}
                            </span>
                            <span class="badge {{ $is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $is_active ? __('dashboard.active') : __('dashboard.inactive') }}
                            </span>
                            @if ($discount_type === 'percentage')
                                <span class="badge bg-light-info fs-6">
                                    <i class="fa-solid fa-percent me-1"></i> {{ $discount_value }}%
                                </span>
                            @else
                                <span class="badge bg-light-success fs-6">
                                    <i class="fa-solid fa-dollar-sign me-1"></i> {{ number_format($discount_value, 2) }}
                                    EGP
                                </span>
                            @endif
                            <span class="badge bg-light-primary fs-6">
                                <i class="fa-solid fa-chart-line me-1"></i> {{ $used_count }} /
                                {{ $usage_limit ?: '∞' }}
                            </span>
                        </div>
                    </div>

                    {{-- Name AR --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fa-solid fa-heading me-1"></i> {{ __('dashboard.name-ar') }}
                        </label>
                        <div class="p-3 bg-light rounded border" dir="rtl">
                            {{ $name_ar ?: '-' }}
                        </div>
                    </div>

                    {{-- Name EN --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-primary">
                            <i class="fa-solid fa-heading me-1"></i> {{ __('dashboard.name-en') }}
                        </label>
                        <div class="p-3 bg-light rounded border" dir="ltr">
                            {{ $name_en ?: '-' }}
                        </div>
                    </div>

                    {{-- Description AR --}}
                    @if ($description_ar)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-primary">
                                <i class="fa-solid fa-file-lines me-1"></i> {{ __('dashboard.description-ar') }}
                            </label>
                            <div class="p-3 bg-light rounded border" dir="rtl">
                                {{ $description_ar }}
                            </div>
                        </div>
                    @endif

                    {{-- Description EN --}}
                    @if ($description_en)
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-primary">
                                <i class="fa-solid fa-file-lines me-1"></i> {{ __('dashboard.description-en') }}
                            </label>
                            <div class="p-3 bg-light rounded border" dir="ltr">
                                {{ $description_en }}
                            </div>
                        </div>
                    @endif

                    {{-- Limits & Conditions --}}
                    <div class="col-12">
                        <hr>
                        <h6 class="text-secondary mb-3">
                            <i class="fa-solid fa-sliders me-1"></i> {{ __('dashboard.limits_and_conditions') }}
                        </h6>
                    </div>

                    {{-- Min Order Amount --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold text-secondary">{{ __('dashboard.min_order_amount') }}</label>
                        <div class="p-2 bg-light rounded border small">
                            {{ $min_order_amount ? number_format($min_order_amount, 2) . ' EGP' : '-' }}
                        </div>
                    </div>

                    {{-- Max Discount Amount --}}
                    <div class="col-md-3 mb-3">
                        <label
                            class="form-label fw-bold text-secondary">{{ __('dashboard.max_discount_amount') }}</label>
                        <div class="p-2 bg-light rounded border small">
                            {{ $max_discount_amount ? number_format($max_discount_amount, 2) . ' EGP' : '-' }}
                        </div>
                    </div>

                    {{-- Usage Limit Per User --}}
                    <div class="col-md-3 mb-3">
                        <label
                            class="form-label fw-bold text-secondary">{{ __('dashboard.usage_limit_per_user') }}</label>
                        <div class="p-2 bg-light rounded border small">
                            {{ $usage_limit_per_user }}
                        </div>
                    </div>

                    {{-- Usage Stats --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold text-secondary">{{ __('dashboard.total_usage') }}</label>
                        <div class="p-2 bg-light rounded border small">
                            {{ $used_count }} / {{ $usage_limit ?: '∞' }}
                        </div>
                    </div>

                    {{-- Validity Dates --}}
                    @if ($start_date || $end_date)
                        <div class="col-12">
                            <hr>
                            <h6 class="text-secondary mb-3">
                                <i class="fa-solid fa-calendar me-1"></i> {{ __('dashboard.validity') }}
                            </h6>
                        </div>

                        {{-- Start Date --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">{{ __('dashboard.start_date') }}</label>
                            <div class="p-2 bg-light rounded border small">
                                {{ $start_date ? $start_date->format('Y-m-d') : '-' }}
                            </div>
                        </div>

                        {{-- End Date --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-secondary">{{ __('dashboard.end_date') }}</label>
                            <div class="p-2 bg-light rounded border small">
                                {{ $end_date ? $end_date->format('Y-m-d') : '-' }}
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
