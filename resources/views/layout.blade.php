<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @yield('title')
        Orders
    </title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #map {
            height: 300px;
        }
    </style>
</head>
<body>
    <header>
        @yield('header')
    </header>
    <main>
        <a href="/">{{ $order->latitude }}</a>
        <section class="section">
            <div class="container">
                <div id="map"></div>
            </div>
            <div class="container">
<x-maps-google :centerPoint="['lat' => 15.35259733449114, 'long' => 44.1837635452817]"></x-maps-google>
            </div>
        </section>
        @yield('content')
    </main>
    <footer>
        <script>
            // Enable pusher logging - don't include this in production
            // Pusher.logToConsole = true;
            // var pusher = new Pusher('b8c184b5a3f2348e41af', {
            //     cluster: 'mt1'
            // });
            // var channel = pusher.subscribe('deliveries');
            // channel.bind('updated-location', function(data) {
            //      var map = L.map('map');
            // map.setView([ data.lat, data.lng ], 15);
            // L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //     maxZoom: 19,
            //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            // }).addTo(map);
            // if (!navigator.geolocation) {
            //     alert("Error: Geolocation is not supported by your browser!");
            // }
            // navigator.geolocation.watchPosition(success, error);
            // let marker, circle, zoomed;
            // function success(pos) {
            //     const lat = pos.coords.latitude =data.lat;
            //     const lng = pos.coords.longitude = data.lng;
            //     const accuracy = pos.coords.accuracy;
            //     map.panTo([lat, lng]);
            //     if (marker) {
            //         map.removeLayer(marker);
            //         map.removeLayer(circle);
            //     }
            //     var myIcon = L.icon({
            //         iconUrl: '{{ asset('icons/dd.svg') }}',
            //         iconSize: [28, 85],
            //         iconAnchor: [22, 94],
            //         popupAnchor: [-3, -76],
            //         shadowSize: [68, 95],
            //         shadowAnchor: [22, 94]
            //     });
            //     marker = L.marker([lat, lng], {
            //         icon: myIcon
            //     }).addTo(map);
            //     circle = L.circle([lat, lng], {
            //         radius: accuracy
            //     }).addTo(map);
            //     marker.bindPopup("<b>delivery-man name:</b><br>{{ $order->name }}.").openPopup();
            //     circle.bindPopup("<b>Ahmed!</b><br>DeliveryMan.");
            //     if (!zoomed) {
            //         zoomed = map.fitBounds(circle.getBounds());
            //     }
            //     map.setView([lat, lng], 15);
            // }
            // function error(err) {
            //     if (err.code === 1) {
            //         alert("Error: Access is denied!");
            //     } else {
            //         alert("Error: Position is unavailable!");
            //     }
            // }
            // });
        </script>
        <script>
            var map = L.map('map');
            map.setView([15.35259833444114, 44.1837637472817], 14);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            if (!navigator.geolocation) {
                alert("Error: Geolocation is not supported by your browser!");
            }
            Pusher.logToConsole = true;
            var pusher = new Pusher('b8c184b5a3f2348e41af', {
                cluster: 'mt1'
            });
            var channel = pusher.subscribe('deliveries');
            channel.bind('updated-location', function(data) {
                navigator.geolocation.watchPosition(success, error);
                let marker, circle, zoomed;
                function success(pos) {
                    const lat = pos.coords.latitude = data.lat;
                    const lng = pos.coords.longitude = data.lng;
                    const accuracy = pos.coords.accuracy;
                    map.panTo([lat, lng]);
                    // if (marker) {
                    //     map.removeLayer(marker);
                    //     map.removeLayer(circle);
                    // }
                    var myIcon = L.icon({
                        iconUrl: '{{ asset('icons/dd.svg') }}',
                        iconSize: [28, 85],
                        iconAnchor: [22, 94],
                        popupAnchor: [-3, -76],
                        shadowSize: [68, 95],
                        shadowAnchor: [22, 94]
                    });
                    marker = L.marker([lat, lng], {
                        icon: myIcon
                    }).addTo(map);
                    // circle = L.circle([lat, lng], {
                    //     radius: accuracy
                    // }).addTo(map);
                    $name = data.name;
                    marker.bindPopup($name).openPopup();
                    // circle.bindPopup("<b>Ahmed!</b><br>DeliveryMan.");
                    // if (!zoomed) {
                    //     zoomed = map.fitBounds(circle.getBounds());
                    // }
                    map.setView([lat, lng], 14);
                }

                function error(err) {
                    if (err.code === 1) {
                        alert("Error: Access is denied!");
                    } else {
                        alert("Error: Position is unavailable!");
                    }
                }
            });
            // navigator.geolocation.watchPosition(success, error);
            // let marker, circle, zoomed;

            // function success(pos) {
            //     const lat = pos.coords.latitude = {{ $order->latitude }};
            //     const lng = pos.coords.longitude = {{ $order->longitude }};
            //     const accuracy = pos.coords.accuracy;
            //     map.panTo([lat, lng]);
            //     if (marker) {
            //         map.removeLayer(marker);
            //         map.removeLayer(circle);
            //     }

            //     var myIcon = L.icon({
            //         iconUrl: '{{ asset('icons/dd.svg') }}',
            //         iconSize: [28, 85],
            //         iconAnchor: [22, 94],
            //         popupAnchor: [-3, -76],
            //         shadowSize: [68, 95],
            //         shadowAnchor: [22, 94]
            //     });
            //     marker = L.marker([lat, lng], {
            //         icon: myIcon
            //     }).addTo(map);

            //     circle = L.circle([lat, lng], {
            //         radius: accuracy
            //     }).addTo(map);
            //     marker.bindPopup("<b>delivery-man name:</b><br>{{ $order->name }}.").openPopup();
            //     circle.bindPopup("<b>Ahmed!</b><br>DeliveryMan.");
            //     if (!zoomed) {
            //         zoomed = map.fitBounds(circle.getBounds());
            //     }
            //     map.setView([lat, lng], 15);
            // }

            // function error(err) {
            //     if (err.code === 1) {
            //         alert("Error: Access is denied!");
            //     } else {
            //         alert("Error: Position is unavailable!");
            //     }
            // }
        </script>
        @yield('footer')
    </footer>
</body>
</html>
