@extends('dashboard.master', ['title' => __('dashboard.products')])
@section('products-active', 'active')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ __('dashboard.products') }}</h4>
                    <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i data-feather='plus-circle' class="me-50"></i>
                        {{ __('dashboard.create-product') }}
                    </button>
                </div>
                @livewire('dashboard.products.products')
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    @livewire('dashboard.products.add-product')

    {{-- Update Modal --}}
    @livewire('dashboard.products.update-product')

    {{-- View Modal --}}
    @livewire('dashboard.products.view-product')
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Livewire.on('createModalToggle', () => {
                var myModal = bootstrap.Modal.getInstance(document.getElementById('createModal'));
                if (myModal) myModal.hide();
            });
            Livewire.on('updateModalToggle', () => {
                var myModal = bootstrap.Modal.getInstance(document.getElementById('updateModal'));
                if (myModal) {
                    myModal.hide();
                } else {
                    myModal = new bootstrap.Modal(document.getElementById('updateModal'));
                    myModal.show();
                }
            });
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
            Livewire.on('confirmDelete', function(id) {
                Swal.fire({
                    title: '{{ __('dashboard.confirmation') }}',
                    text: '{{ __('dashboard.confirm_delete_message') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('dashboard.confirmButtonText') }}',
                    cancelButtonText: '{{ __('dashboard.cancelButtonText') }}',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary ms-1'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteItem', {
                            id: id
                        });
                    }
                });
            });
        });
    </script>
@endpush
