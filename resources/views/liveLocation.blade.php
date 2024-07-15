<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    {{-- 
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

      <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script> --}}

    {{-- <style>
#map { height: 350px; }
     </style> --}}
</head>

<body>
    <header>
        @yield('header')
    </header>

    <main>
        {{-- <div id="map"></div> --}}
         <div id="output"></div>
        @yield('content')
       
    </main>

    <footer>
        <script>

            if (!navigator.geolocation) {
                throw new Error("Error: Geolocation is not supported by your browser!");
            }

            function success(pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
console.log(lat,lng);
                const markup = `
                <a href="https://www.openstreetmap.org/#map=16/${lat}/${lng}">
                    your location position: latitude: ${lat}, longitude: ${lng}.
                </a>
                `;
                document.getElementById('output').innerHTML = markup;
                navigator.geolocation.clearWatch(id);

                
            }

            function error(err) {
                if(err.code==1){
alert("Error: Access is denied!");
                }else{
alert("Error: Position is unavailable!");
                }
            
            }

            const options = {
                enableHighAccuracy: true,
                timeout: 5000,
            };
         const id = navigator.geolocation.watchPosition(success, error, options)

        </script>
        @yield('footer')
    </footer>
</body>

</html>
