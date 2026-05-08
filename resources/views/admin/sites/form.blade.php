@extends('admin.layouts.app')

@push('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin="" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
            border: 2px solid #e3e6f0;
            z-index: 1;
        }
        .map-section {
            position: relative;
        }
        .map-section .map-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #5a5c69;
            margin-bottom: 6px;
        }
        .map-section .map-label i {
            color: #6c63ff;
            margin-right: 6px;
        }
        .map-hint {
            font-size: 0.82rem;
            color: #6c63ff;
            margin-top: 8px;
        }
        .map-hint i {
            margin-right: 4px;
        }

        /* Address autocomplete dropdown */
        .address-autocomplete-wrapper {
            position: relative;
        }
        .address-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #d1d3e2;
            border-top: none;
            border-radius: 0 0 6px 6px;
            max-height: 220px;
            overflow-y: auto;
            z-index: 1050;
            box-shadow: 0 4px 16px rgba(0,0,0,0.10);
            display: none;
        }
        .address-suggestions .suggestion-item {
            padding: 10px 14px;
            cursor: pointer;
            font-size: 0.88rem;
            color: #3a3b45;
            border-bottom: 1px solid #f1f1f4;
            transition: background 0.15s;
        }
        .address-suggestions .suggestion-item:last-child {
            border-bottom: none;
        }
        .address-suggestions .suggestion-item:hover,
        .address-suggestions .suggestion-item.active {
            background: #eef0ff;
            color: #6c63ff;
        }
        .address-suggestions .suggestion-item i {
            color: #b0b3c5;
            margin-right: 8px;
            font-size: 0.82rem;
        }
        .address-suggestions .suggestion-loading {
            padding: 12px 14px;
            text-align: center;
            color: #b0b3c5;
            font-size: 0.85rem;
        }
    </style>
@endpush

@section('content')

@php
    $isEdit = isset($site);
    $defaultLat = old('latitude', $site->latitude ?? '20.5937');
    $defaultLng = old('longitude', $site->longitude ?? '78.9629');
@endphp

<div class="card shadow mb-4">

    <!-- Card Header -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">
            <strong>{{ $isEdit ? 'Edit Site' : 'Add Site' }}</strong>
        </h6>

        <a href="{{ route('admin.sites.index') }}" class="btn btn-outline-secondary px-4">
            Back
        </a>
    </div>

    <!-- Card Body -->
    <div class="card-body">

        <form action="{{ $isEdit ? route('admin.sites.update', $site->id) : route('admin.sites.store') }}"
              method="POST">

            @csrf

            @if($isEdit)
                @method('PUT')
            @endif

            <div class="row">

                <!-- Site Name -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Site Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Enter site name"
                           value="{{ old('name', $site->site_name ?? '') }}"
                           required>
                </div>

                <!-- Address -->
                <div class="col-md-8 mb-3">
                    <label class="form-label">Address</label>
                    <div class="address-autocomplete-wrapper">
                        <input type="text"
                               name="address"
                               id="address-input"
                               class="form-control"
                               placeholder="Enter address or pick from map"
                               value="{{ old('address', $site->address ?? '') }}"
                               autocomplete="off">
                        <div id="address-suggestions" class="address-suggestions"></div>
                    </div>
                </div>

                <!-- Latitude -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Latitude</label>
                    <input type="text"
                           name="latitude"
                           id="latitude-input"
                           class="form-control"
                           placeholder="Enter latitude"
                           value="{{ old('latitude', $site->latitude ?? '') }}"
                           readonly>
                </div>

                <!-- Longitude -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Longitude</label>
                    <input type="text"
                           name="longitude"
                           id="longitude-input"
                           class="form-control"
                           placeholder="Enter longitude"
                           value="{{ old('longitude', $site->longitude ?? '') }}"
                           readonly>
                </div>

                <!-- Status -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ (old('status', $site->status ?? '') == 1) ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="0" {{ (old('status', $site->status ?? '') == 0) ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

            </div>

            <!-- Map Section -->
            <div class="map-section mt-2 mb-3">
                <div class="map-label">
                    <i class="fas fa-map-marked-alt"></i> Pick Location on Map
                    <span style="font-weight: 400; color: #858796; font-size: 0.85rem; margin-left: 6px;">
                        (Click or drag the marker to auto-fill address &amp; coordinates)
                    </span>
                </div>
                <div id="map"></div>
                <div class="map-hint">
                    <i class="fas fa-mouse-pointer"></i> Click anywhere on the map to set the site location.
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i>
                    {{ $isEdit ? 'Update' : 'Save' }}
                </button>
            </div>

        </form>

    </div>
</div>

@endsection

@push('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

    <script>
    (function () {
        'use strict';

        // --- DOM Elements ---
        var latInput   = document.getElementById('latitude-input');
        var lngInput   = document.getElementById('longitude-input');
        var addrInput  = document.getElementById('address-input');
        var suggestBox = document.getElementById('address-suggestions');

        // --- Default coordinates (India center, or existing site coords) ---
        var defaultLat = parseFloat('{{ $defaultLat }}') || 20.5937;
        var defaultLng = parseFloat('{{ $defaultLng }}') || 78.9629;
        var hasExisting = !!(latInput.value && lngInput.value);
        var startZoom   = hasExisting ? 15 : 5;

        // --- Initialize Map ---
        var map = L.map('map').setView([defaultLat, defaultLng], startZoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(map);

        // --- Custom marker icon (purple to match reference) ---
        var markerIcon = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // --- Marker ---
        var marker = null;

        if (hasExisting) {
            marker = L.marker([defaultLat, defaultLng], {
                draggable: true,
                icon: markerIcon
            }).addTo(map);
            bindMarkerDrag(marker);
        }

        // --- Map Click → Place/Move marker ---
        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            setMarker(lat, lng);
            updateCoordinates(lat, lng);
            reverseGeocode(lat, lng);
        });

        function setMarker(lat, lng) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng], {
                    draggable: true,
                    icon: markerIcon
                }).addTo(map);
                bindMarkerDrag(marker);
            }
        }

        function bindMarkerDrag(mkr) {
            mkr.on('dragend', function (e) {
                var pos = mkr.getLatLng();
                updateCoordinates(pos.lat, pos.lng);
                reverseGeocode(pos.lat, pos.lng);
            });
        }

        function updateCoordinates(lat, lng) {
            latInput.value = parseFloat(lat).toFixed(6);
            lngInput.value = parseFloat(lng).toFixed(6);
        }

        // --- Reverse Geocode (Nominatim) ---
        function reverseGeocode(lat, lng) {
            var url = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=' + lat + '&lon=' + lng + '&zoom=18&addressdetails=1';

            fetch(url, {
                headers: { 'Accept-Language': 'en' }
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data && data.display_name) {
                    addrInput.value = data.display_name;
                }
            })
            .catch(function () {
                // Silently fail
            });
        }

        // --- Address Autocomplete (Nominatim) ---
        var debounceTimer = null;
        var activeIndex   = -1;

        addrInput.addEventListener('input', function () {
            var query = addrInput.value.trim();
            clearTimeout(debounceTimer);

            if (query.length < 3) {
                hideSuggestions();
                return;
            }

            debounceTimer = setTimeout(function () {
                searchAddress(query);
            }, 400);
        });

        addrInput.addEventListener('keydown', function (e) {
            var items = suggestBox.querySelectorAll('.suggestion-item');
            if (!items.length) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                activeIndex = Math.min(activeIndex + 1, items.length - 1);
                highlightSuggestion(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                activeIndex = Math.max(activeIndex - 1, 0);
                highlightSuggestion(items);
            } else if (e.key === 'Enter' && activeIndex >= 0) {
                e.preventDefault();
                items[activeIndex].click();
            } else if (e.key === 'Escape') {
                hideSuggestions();
            }
        });

        function highlightSuggestion(items) {
            items.forEach(function (el, i) {
                el.classList.toggle('active', i === activeIndex);
            });
        }

        function searchAddress(query) {
            suggestBox.innerHTML = '<div class="suggestion-loading"><i class="fas fa-spinner fa-spin"></i> Searching...</div>';
            suggestBox.style.display = 'block';

            var url = 'https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&limit=6&addressdetails=1';

            fetch(url, {
                headers: { 'Accept-Language': 'en' }
            })
            .then(function (res) { return res.json(); })
            .then(function (results) {
                suggestBox.innerHTML = '';
                activeIndex = -1;

                if (!results || results.length === 0) {
                    suggestBox.innerHTML = '<div class="suggestion-loading">No results found</div>';
                    return;
                }

                results.forEach(function (place) {
                    var div = document.createElement('div');
                    div.className = 'suggestion-item';
                    div.innerHTML = '<i class="fas fa-map-marker-alt"></i>' + escapeHtml(place.display_name);

                    div.addEventListener('click', function () {
                        var lat = parseFloat(place.lat);
                        var lng = parseFloat(place.lon);

                        addrInput.value = place.display_name;
                        updateCoordinates(lat, lng);
                        setMarker(lat, lng);
                        map.setView([lat, lng], 16);
                        hideSuggestions();
                    });

                    suggestBox.appendChild(div);
                });
            })
            .catch(function () {
                suggestBox.innerHTML = '<div class="suggestion-loading">Error fetching results</div>';
            });
        }

        function hideSuggestions() {
            suggestBox.style.display = 'none';
            suggestBox.innerHTML = '';
            activeIndex = -1;
        }

        // Close suggestions when clicking outside
        document.addEventListener('click', function (e) {
            if (!addrInput.contains(e.target) && !suggestBox.contains(e.target)) {
                hideSuggestions();
            }
        });

        function escapeHtml(str) {
            var div = document.createElement('div');
            div.appendChild(document.createTextNode(str));
            return div.innerHTML;
        }

    })();
    </script>
@endpush