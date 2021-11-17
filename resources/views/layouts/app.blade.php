<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#ecf0f1" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" rel="stylesheet" />
</head>

<body>
    <div id="app">


        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", function() {
                navigator.serviceWorker
                    .register("/service-worker.js")
                    .then(function() {
                        console.log("Pendaftaran ServiceWorker berhasil");
                    })
                    .catch(function() {
                        console.log("Pendaftaran ServiceWorker gagal");
                    });
            });
        } else {
            console.log("ServiceWorker belum didukung browser ini.");
        }
        $('#table').DataTable({
            responsive: true
        });
        mapboxgl.accessToken =
            "pk.eyJ1IjoiYXNudXJyYW1kYW5pIiwiYSI6ImNrdjBxdHo3dTdvdm4ybm84N2l4ODFrb3oifQ.oO6Ae3b6VKomdwuBN0Jf0A";

        navigator.geolocation.getCurrentPosition(function(location) {
            var map = new mapboxgl.Map({
                container: "map",
                style: "mapbox://styles/mapbox/streets-v11",
                center: [location.coords.longitude, location.coords.latitude],
                zoom: 15,
            });
            map.addControl(new mapboxgl.NavigationControl());
            map.addControl(new mapboxgl.FullscreenControl());

            map.on('load', () => {
                map.addSource('places', {
                    'type': 'geojson',
                    'data': 'http://localhost:8000/get-data-location'
                });

                map.addLayer({
                    'id': 'places',
                    'type': 'circle',
                    'source': 'places',
                    'paint': {
                        'circle-color': '#4264fb',
                        'circle-radius': 6,
                        'circle-stroke-width': 2,
                        'circle-stroke-color': '#ffffff'
                    }
                });

                const popup = new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: false
                });

                map.on('mouseenter', 'places', (e) => {
                    map.getCanvas().style.cursor = 'pointer';

                    const coordinates = e.features[0].geometry.coordinates.slice();
                    const description = e.features[0].properties.description;


                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    popup.setLngLat(coordinates).setHTML(description).addTo(map);
                });

                map.on('mouseleave', 'places', () => {
                    map.getCanvas().style.cursor = '';
                    popup.remove();
                });
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#img-location')
                            .attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $('#camera').hide()
            $('#take-snapshot').hide()

            function openCamera() {
                $('#camera').show();
                $('#take-snapshot').show();
                $('#img-location').hide()
                Webcam.set('constraints', {
                    facingMode: "environment",
                    mandatory: {
                        maxWidth: _this.parameters.sourceWidth,
                        maxHeight: _this.parameters.sourceHeight
                    }
                });
                Webcam.attach('#camera');
            }

            function preview_image() {
                Webcam.snap(function(data_uri) {
                    $('#image_camera').val()
                    $('#image_camera').val(data_uri)
                })
                Webcam.freeze()
            }

            const coordinates = document.getElementById('coordinates');
            const marker = new mapboxgl.Marker({
                    draggable: true
                })
                .setLngLat([location.coords.longitude, location.coords.latitude]).addTo(map);

            function onDragEnd() {
                const lngLat = marker.getLngLat();
                coordinates.style.display = 'block';
                coordinates.innerHTML = `Longitude: ${lngLat.lng}<br />Latitude: ${lngLat.lat}`;
                $('#latitude').val('')
                $('#longitude').val('')
                $('#latitude').val(lngLat.lat)
                $('#longitude').val(lngLat.lng)
                $('.form-add-cordinate').modal('show')
            }
            marker.on('dragend', onDragEnd);

            $('#manual_input').change(function() {
                if ($(this).prop('checked') == true) {
                    $('#latitude').prop('readonly', true)
                    $('#longitude').prop('readonly', true)
                    $('#latitude').val(location.coords.latitude)
                    $('#longitude').val(location.coords.longitude)

                    marker.remove();
                    coordinates.style.display = 'none';
                } else if ($(this).prop('checked') == false) {
                    $('#latitude').prop('readonly', false)
                    $('#longitude').prop('readonly', false)
                    marker.addTo(map)
                }
            })
        });
    </script>
</body>

</html>
