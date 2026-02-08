@extends('dashboard.master', ['title' => __('dashboard.pages')])
@section('pages-active', 'active')

@push('css')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable {
            min-height: 250px;
        }

        .ck-editor__editable[dir="rtl"] {
            text-align: right;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ __('dashboard.pages') }}</h4>
                    <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i data-feather='plus'></i> {{ __('dashboard.create-page') }}
                    </button>
                </div>
                @livewire('dashboard.pages.pages')
            </div>
        </div>
    </div>

    @livewire('dashboard.pages.add-page')
    @livewire('dashboard.pages.update-page')
    @livewire('dashboard.pages.view-page')
@endsection

@push('js')
    <script>
        // Store CKEditor instances
        let createEditorAr = null;
        let createEditorEn = null;
        let updateEditorAr = null;
        let updateEditorEn = null;

        // Store pending content for update modal
        let pendingUpdateContent = null;

        // Initialize CKEditor for Create Modal
        function initCreateEditors() {
            const contentArElement = document.getElementById('create_content_ar');
            const contentEnElement = document.getElementById('create_content_en');

            if (contentArElement && !createEditorAr) {
                ClassicEditor
                    .create(contentArElement, {
                        language: 'ar',
                        toolbar: ['heading', '|', 'bold', 'italic', 'underline', '|', 'bulletedList', 'numberedList',
                            '|', 'link', 'blockQuote', '|', 'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        createEditorAr = editor;
                    })
                    .catch(error => console.error(error));
            }

            if (contentEnElement && !createEditorEn) {
                ClassicEditor
                    .create(contentEnElement, {
                        toolbar: ['heading', '|', 'bold', 'italic', 'underline', '|', 'bulletedList', 'numberedList',
                            '|', 'link', 'blockQuote', '|', 'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        createEditorEn = editor;
                    })
                    .catch(error => console.error(error));
            }
        }

        // Initialize CKEditor for Update Modal
        function initUpdateEditors() {
            const contentArElement = document.getElementById('update_content_ar');
            const contentEnElement = document.getElementById('update_content_en');

            const initPromises = [];

            if (contentArElement && !updateEditorAr) {
                const arPromise = ClassicEditor
                    .create(contentArElement, {
                        language: 'ar',
                        toolbar: ['heading', '|', 'bold', 'italic', 'underline', '|', 'bulletedList', 'numberedList',
                            '|', 'link', 'blockQuote', '|', 'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        updateEditorAr = editor;
                    })
                    .catch(error => console.error(error));
                initPromises.push(arPromise);
            }

            if (contentEnElement && !updateEditorEn) {
                const enPromise = ClassicEditor
                    .create(contentEnElement, {
                        toolbar: ['heading', '|', 'bold', 'italic', 'underline', '|', 'bulletedList', 'numberedList',
                            '|', 'link', 'blockQuote', '|', 'undo', 'redo'
                        ]
                    })
                    .then(editor => {
                        updateEditorEn = editor;
                    })
                    .catch(error => console.error(error));
                initPromises.push(enPromise);
            }

            // After all editors are initialized, set pending content if available
            Promise.all(initPromises).then(() => {
                if (pendingUpdateContent) {
                    if (updateEditorAr && pendingUpdateContent.content_ar) {
                        updateEditorAr.setData(pendingUpdateContent.content_ar);
                    }
                    if (updateEditorEn && pendingUpdateContent.content_en) {
                        updateEditorEn.setData(pendingUpdateContent.content_en);
                    }
                    pendingUpdateContent = null;
                }
            });
        }

        // Destroy editors when modal closes
        function destroyCreateEditors() {
            if (createEditorAr) {
                createEditorAr.destroy().catch(error => console.error(error));
                createEditorAr = null;
            }
            if (createEditorEn) {
                createEditorEn.destroy().catch(error => console.error(error));
                createEditorEn = null;
            }
        }

        function destroyUpdateEditors() {
            if (updateEditorAr) {
                updateEditorAr.destroy().catch(error => console.error(error));
                updateEditorAr = null;
            }
            if (updateEditorEn) {
                updateEditorEn.destroy().catch(error => console.error(error));
                updateEditorEn = null;
            }
        }

        // Sync CKEditor content to Livewire before submit
        function syncCreateEditors() {
            const addPageComponent = Livewire.getByName('dashboard.pages.add-page')[0];
            if (addPageComponent) {
                if (createEditorAr) {
                    addPageComponent.set('content_ar', createEditorAr.getData());
                }
                if (createEditorEn) {
                    addPageComponent.set('content_en', createEditorEn.getData());
                }
            }
        }

        function syncUpdateEditors() {
            const updatePageComponent = Livewire.getByName('dashboard.pages.update-page')[0];
            if (updatePageComponent) {
                if (updateEditorAr) {
                    updatePageComponent.set('content_ar', updateEditorAr.getData());
                }
                if (updateEditorEn) {
                    updatePageComponent.set('content_en', updateEditorEn.getData());
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize editors when modals are shown
            const createModal = document.getElementById('createModal');
            if (createModal) {
                createModal.addEventListener('shown.bs.modal', function() {
                    setTimeout(initCreateEditors, 100);
                });
                createModal.addEventListener('hidden.bs.modal', function() {
                    destroyCreateEditors();
                });
            }

            const updateModal = document.getElementById('updateModal');
            if (updateModal) {
                updateModal.addEventListener('shown.bs.modal', function() {
                    setTimeout(initUpdateEditors, 100);
                });
                updateModal.addEventListener('hidden.bs.modal', function() {
                    destroyUpdateEditors();
                });
            }

            // Intercept form submit to sync CKEditor content
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form.closest('#createModal')) {
                    syncCreateEditors();
                } else if (form.closest('#updateModal')) {
                    syncUpdateEditors();
                }
            }, true);

            // Set content for update editors - store it and apply when editors are ready
            Livewire.on('setEditorContent', function(data) {
                pendingUpdateContent = data[0];
                // If editors are already initialized, set content immediately
                if (updateEditorAr && pendingUpdateContent.content_ar) {
                    updateEditorAr.setData(pendingUpdateContent.content_ar);
                }
                if (updateEditorEn && pendingUpdateContent.content_en) {
                    updateEditorEn.setData(pendingUpdateContent.content_en);
                }
            });

            // Toggle view modal
            Livewire.on('viewModalToggle', function() {
                const modalElement = document.getElementById('viewModal');
                if (modalElement) {
                    const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(
                        modalElement);
                    modal.toggle();
                }
            });

            // Success message
            Livewire.on('success', function(message) {
                Swal.fire({
                    position: 'top-start',
                    icon: 'success',
                    title: message,
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            });

            // Something failed
            Livewire.on('somethingFailed', function() {
                Swal.fire({
                    position: 'top-start',
                    icon: 'error',
                    title: '{{ __('validation.something-valid') }}',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            });

            // Delete confirmation
            Livewire.on('deleteConfirm', function(data) {
                Swal.fire({
                    title: "{{ __('dashboard.are_you_sure') }}",
                    text: "{{ __('dashboard.confirm_delete_message') }}",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('dashboard.yes_delete') }}",
                    cancelButtonText: "{{ __('dashboard.cancel') }}",
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary ms-1'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('delete', {
                            id: data.id
                        });
                    }
                });
            });

            // Toggle create modal
            Livewire.on('createModalToggle', function() {
                const modalElement = document.getElementById('createModal');
                if (modalElement) {
                    const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(
                        modalElement);
                    modal.toggle();
                }
            });

            // Toggle update modal
            Livewire.on('updateModalToggle', function() {
                const modalElement = document.getElementById('updateModal');
                if (modalElement) {
                    const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(
                        modalElement);
                    modal.toggle();
                }
            });
        });
    </script>
@endpush
