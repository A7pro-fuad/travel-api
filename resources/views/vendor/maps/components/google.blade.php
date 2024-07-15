    <style>
        #{{ $mapId }} {
            height: 100%;
        }
    </style>
    <style>
        #{{ $mapId }} {
            @if (!isset($attributes['style']))
                height: 100vh;
            @else
                {{ $attributes['style'] }}
            @endif
        }
    </style>

    <div id="{{ $mapId }}" @if (isset($attributes['class'])) class='{{ $attributes['class'] }}' @endif></div>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6QTw5OAuW4VpOs-4r-o8xl2t6iLvHx2c&callback=initMap{{ $mapId }}&libraries=&v=3"
        async></script>

    <script>
        let map{{ $mapId }} = "";

        function initMap{{ $mapId }}() {
            map{{ $mapId }} = new google.maps.Map(document.getElementById("{{ $mapId }}"), {
                center: {
                    lat: {{ $centerPoint['lat'] ?? $centerPoint[0] }},
                    lng: {{ $centerPoint['long'] ?? $centerPoint[1] }}
                },
                zoom: {{ $zoomLevel }},
                mapTypeId: '{{ $mapType }}'
            });

            function addInfoWindow(marker, message) {

                var infoWindow = new google.maps.InfoWindow({
                    content: message
                });

                google.maps.event.addListener(marker, 'click', function() {
                    infoWindow.open(map{{ $mapId }}, marker);
                });
            }

            @if ($fitToBounds || $centerToBoundsCenter)
                let bounds = new google.maps.LatLngBounds();
            @endif
            var myIcon = new google.maps.MarkerImage(
                '{{ asset('icons/dd.svg') }}',
                null,
                null,
                null,
                new google.maps.Size(28, 85),
                new google.maps.Point(22, 94),
                new google.maps.Point(-3, -76)
            );
            @foreach ($markers as $marker)
                var marker{{ $loop->iteration }} = new google.maps.Marker({
                        position: {
                            lat: 15.35259733449114,
                            lng: 44.1837635452817

                        },
                        map: map{{ $mapId }},
                        @if (isset($marker['title']))
                            title: "{{ $marker['title'] }}",
                        @endif
                        /* icon: @if (isset($marker['icon']))
                addInfoWindow(marker{{ $loop->iteration }}, @json($marker['info']));
            @endif

            @if ($fitToBounds || $centerToBoundsCenter)
                bounds.extend({
                    lat: {{ $marker['lat'] ?? $marker[0] }},
                    lng: {{ $marker['long'] ?? $marker[1] }}
                });
            @endif

            @if ($fitToBounds)
                map{{ $mapId }}.fitBounds(bounds);
            @endif
        @endforeach

        @if ($centerToBoundsCenter)
            map{{ $mapId }}.setCenter(bounds.getCenter());
        @endif
        }
    </script>
