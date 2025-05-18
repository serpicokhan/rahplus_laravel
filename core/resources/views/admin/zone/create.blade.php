@extends('admin.layouts.app')
@section('panel')
    <div class="row justify-content-center">
        <div class="col-12">
            <x-admin.ui.card>
                <x-admin.ui.card.body>
                    <form action="{{ route('admin.zone.save', @$zone->id ?? 0) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input class="form-control" name="name" type="text" value="{{ old('name', @$zone->name) }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Country')</label>
                            <select name="country" class="form-control select2" required @readonly(@$zone)>
                                @foreach (gs('operating_country') ?? [] as $k => $country)
                                    <option value="{{ $k }}" @selected($k == @$zone->country)>
                                        {{ __($country->country) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Select Area')</label>
                            <input class="controls" id="searchBox" type="text" placeholder="@lang('Search Here')">
                            <textarea class="d-none" id="coordinates" name="coordinates"></textarea>
                            <div class="google-map" id="map"></div>
                        </div>
                        <x-admin.ui.btn.submit />
                    </form>
                </x-admin.ui.card.body>
            </x-admin.ui.card>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back_btn route="{{ route('admin.zone.index') }}" />
@endpush


@push('script-lib')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ gs('google_maps_api') }}&libraries=drawing,places&v=3.45.8">
    </script>
@endpush


@push('script')
    <script>
        "use strict";

        var polygons = [];
        var lastPolygon = null;


        function resetMap(controlDiv) {
            const removePolygonDiv = document.createElement("div");
            removePolygonDiv.style.backgroundColor = "#fff";
            removePolygonDiv.style.border = "2px solid #fff";
            removePolygonDiv.style.borderRadius = "3px";
            removePolygonDiv.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
            removePolygonDiv.style.cursor = "pointer";
            removePolygonDiv.style.marginTop = "6px";
            removePolygonDiv.style.marginBottom = "22px";
            removePolygonDiv.style.marginRight = "8px";
            removePolygonDiv.style.textAlign = "center";
            removePolygonDiv.title = "Reset map";
            controlDiv.appendChild(removePolygonDiv);

            const controlText = document.createElement("div");
            controlText.style.color = "red";
            controlText.style.fontFamily = "Roboto,Arial,sans-serif";
            controlText.style.paddingRight = "5px";
            controlText.style.paddingLeft = "5px";
            controlText.style.fontSize = "16px";
            controlText.innerHTML = "X";
            removePolygonDiv.appendChild(controlText);

            removePolygonDiv.addEventListener("click", () => {
                lastPolygon.setMap(null);
                $('#coordinates').val('');
            });
        }

        function initMap() {

            let options = {
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }

            const map = new google.maps.Map(document.getElementById("map"), options);

            const drawingManager = new google.maps.drawing.DrawingManager({
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                },
                polygonOptions: {
                    editable: true
                }
            });

            const appliedCoordinates = [
                @foreach ($coordinates as $coords)
                    {
                        lat: {{ $coords['lat'] }},
                        lng: {{ $coords['lang'] }}
                    },
                @endforeach
            ];

            const area = new google.maps.Polygon({
                paths: appliedCoordinates,
                strokeColor: "#000000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillOpacity: 0.12,
            });

            area.setMap(map);
            drawingManager.setMap(map);

            // Calculate the bounds of the polygon
            const bounds = new google.maps.LatLngBounds();
            appliedCoordinates.forEach((coord) => {
                bounds.extend(new google.maps.LatLng(coord.lat, coord.lng));
            });


            // Get the center of the bounds
            const center = bounds.getCenter();

            // Set the center of the map to the center of the bounds
            map.setCenter(center);

            // Automatically adjust the zoom level to fit the polygon bounds
            map.fitBounds(bounds);


            google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {
                if (lastPolygon) {
                    lastPolygon.setMap(null);
                }

                $('#coordinates').val(event.overlay.getPath().getArray());
                lastPolygon = event.overlay;
            });

            const resetDiv = document.createElement("div");
            resetMap(resetDiv);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(resetDiv);

            const input = document.getElementById("searchBox");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

            input.addEventListener('keypress', function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    return true;
                }
            });

            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            let markers = [];
            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                markers.forEach((marker) => {
                    marker.setMap(null);
                });

                markers = [];

                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("No Geometry");
                        return;
                    }

                    const icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25),
                    };

                    markers.push(
                        new google.maps.Marker({
                            map,
                            icon,
                            title: place.name,
                            position: place.geometry.location,
                        })
                    );

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        }
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
@endpush


@push('style')
    <style>
        .google-map {
            width: 100%;
            height: 400px;
        }

        #searchBox {
            position: absolute;
            top: 0px;
            left: 334px;
            background: #fff;
            border: none;
            margin-top: 6px;
            height: 25px;
        }

        .pac-container {
            width: 320px !important;
        }
    </style>
@endpush
