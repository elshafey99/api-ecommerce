@extends('dashboard.master', ['title' => __('dashboard.branches')])
@section('branches-active', 'active')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ __('dashboard.branches') }}</h4>
                    <button type="button" class="btn btn-primary waves-effect" data-bs-toggle="modal"
                        data-bs-target="#createModal">
                        <i data-feather='plus'></i> {{ __('dashboard.create-branch') }}
                    </button>
                </div>
                @livewire('dashboard.branches.branches')
            </div>
        </div>
    </div>

    @livewire('dashboard.branches.add-branch')
    @livewire('dashboard.branches.update-branch')
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

            // Cannot delete branch with orders
            Livewire.on('cannotDeleteBranch', function() {
                Swal.fire({
                    position: 'top-start',
                    icon: 'error',
                    title: '{{ __('dashboard.cannot_delete_branch') }}',
                    text: '{{ __('dashboard.branch_has_orders') }}',
                    showConfirmButton: true,
                    confirmButtonText: '{{ __('dashboard.ok') }}',
                    customClass: {
                        confirmButton: 'btn btn-danger'
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

    {{-- Leaflet Map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.js"></script>
    <script>
        let createMap, createMarker, updateMap, updateMarker;
        const defaultLat = 30.0444;
        const defaultLng = 31.2357;

        function setMarkerAndUpdate(map, markerRef, latlng, latInput, lngInput) {
            if (markerRef.marker) {
                markerRef.marker.setLatLng(latlng);
            } else {
                markerRef.marker = L.marker(latlng, {
                    draggable: true
                }).addTo(map);
                markerRef.marker.on('dragend', function(ev) {
                    const pos = ev.target.getLatLng();
                    document.getElementById(latInput).value = pos.lat.toFixed(8);
                    document.getElementById(lngInput).value = pos.lng.toFixed(8);
                    document.getElementById(latInput).dispatchEvent(new Event('input'));
                    document.getElementById(lngInput).dispatchEvent(new Event('input'));
                });
            }
            document.getElementById(latInput).value = latlng.lat.toFixed(8);
            document.getElementById(lngInput).value = latlng.lng.toFixed(8);
            document.getElementById(latInput).dispatchEvent(new Event('input'));
            document.getElementById(lngInput).dispatchEvent(new Event('input'));
        }

        // Initialize Create Map when modal opens
        let createMarkerRef = {
            marker: null
        };
        document.getElementById('createModal').addEventListener('shown.bs.modal', function() {
            if (!createMap) {
                createMap = L.map('createMap').setView([defaultLat, defaultLng], 6);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(createMap);

                // Add Search Control
                const geocoderCreate = L.Control.geocoder({
                    defaultMarkGeocode: false,
                    placeholder: '{{ __('dashboard.search_location') }}...',
                    errorMessage: '{{ __('dashboard.location_not_found') }}'
                }).on('markgeocode', function(e) {
                    const latlng = e.geocode.center;
                    setMarkerAndUpdate(createMap, createMarkerRef, latlng, 'createLatitude',
                        'createLongitude');
                    createMap.setView(latlng, 14);
                }).addTo(createMap);

                createMap.on('click', function(e) {
                    const lat = e.latlng.lat.toFixed(8);
                    const lng = e.latlng.lng.toFixed(8);

                    if (createMarker) {
                        createMarker.setLatLng(e.latlng);
                    } else {
                        createMarker = L.marker(e.latlng, {
                            draggable: true
                        }).addTo(createMap);

                        createMarker.on('dragend', function(ev) {
                            const pos = ev.target.getLatLng();
                            document.getElementById('createLatitude').value = pos.lat.toFixed(8);
                            document.getElementById('createLongitude').value = pos.lng.toFixed(8);
                            document.getElementById('createLatitude').dispatchEvent(new Event(
                                'input'));
                            document.getElementById('createLongitude').dispatchEvent(new Event(
                                'input'));
                        });
                    }

                    document.getElementById('createLatitude').value = lat;
                    document.getElementById('createLongitude').value = lng;
                    document.getElementById('createLatitude').dispatchEvent(new Event('input'));
                    document.getElementById('createLongitude').dispatchEvent(new Event('input'));
                });
            }
            setTimeout(() => createMap.invalidateSize(), 100);
        });

        // Initialize Update Map when modal opens
        let updateMarkerRef = {
            marker: null
        };
        document.getElementById('updateModal').addEventListener('shown.bs.modal', function() {
            setTimeout(() => {
                if (!updateMap) {
                    updateMap = L.map('updateMap').setView([defaultLat, defaultLng], 6);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap'
                    }).addTo(updateMap);

                    // Add Search Control
                    const geocoderUpdate = L.Control.geocoder({
                        defaultMarkGeocode: false,
                        placeholder: '{{ __('dashboard.search_location') }}...',
                        errorMessage: '{{ __('dashboard.location_not_found') }}'
                    }).on('markgeocode', function(e) {
                        const latlng = e.geocode.center;
                        setMarkerAndUpdate(updateMap, updateMarkerRef, latlng, 'updateLatitude',
                            'updateLongitude');
                        updateMap.setView(latlng, 14);
                    }).addTo(updateMap);

                    updateMap.on('click', function(e) {
                        const lat = e.latlng.lat.toFixed(8);
                        const lng = e.latlng.lng.toFixed(8);

                        if (updateMarker) {
                            updateMarker.setLatLng(e.latlng);
                        } else {
                            updateMarker = L.marker(e.latlng, {
                                draggable: true
                            }).addTo(updateMap);

                            updateMarker.on('dragend', function(ev) {
                                const pos = ev.target.getLatLng();
                                document.getElementById('updateLatitude').value = pos.lat
                                    .toFixed(8);
                                document.getElementById('updateLongitude').value = pos.lng
                                    .toFixed(8);
                                document.getElementById('updateLatitude').dispatchEvent(
                                    new Event('input'));
                                document.getElementById('updateLongitude').dispatchEvent(
                                    new Event('input'));
                            });
                        }

                        document.getElementById('updateLatitude').value = lat;
                        document.getElementById('updateLongitude').value = lng;
                        document.getElementById('updateLatitude').dispatchEvent(new Event('input'));
                        document.getElementById('updateLongitude').dispatchEvent(new Event(
                            'input'));
                    });
                }

                updateMap.invalidateSize();

                // Set marker if coordinates exist
                const lat = document.getElementById('updateLatitude').value;
                const lng = document.getElementById('updateLongitude').value;
                if (lat && lng && lat != '' && lng != '') {
                    const latlng = L.latLng(parseFloat(lat), parseFloat(lng));
                    if (updateMarker) {
                        updateMarker.setLatLng(latlng);
                    } else {
                        updateMarker = L.marker(latlng, {
                            draggable: true
                        }).addTo(updateMap);

                        updateMarker.on('dragend', function(ev) {
                            const pos = ev.target.getLatLng();
                            document.getElementById('updateLatitude').value = pos.lat.toFixed(8);
                            document.getElementById('updateLongitude').value = pos.lng.toFixed(8);
                            document.getElementById('updateLatitude').dispatchEvent(new Event(
                                'input'));
                            document.getElementById('updateLongitude').dispatchEvent(new Event(
                                'input'));
                        });
                    }
                    updateMap.setView(latlng, 12);
                }
            }, 200);
        });

        // Clear marker when create modal closes
        document.getElementById('createModal').addEventListener('hidden.bs.modal', function() {
            if (createMarker) {
                createMap.removeLayer(createMarker);
                createMarker = null;
            }
        });
    </script>
@endpush
