{{--



// Leaflet
// A basic map is as easy as using the x blade component.

<x-maps-leaflet></x-maps-leaflet>

// Set the centerpoint of the map:
<x-maps-leaflet :centerPoint="['lat' =>15.35259733449114, 'long' => 44.1837635452817]"></x-maps-leaflet>

// Set a zoomlevel:
<x-maps-leaflet :zoomLevel="7"></x-maps-leaflet>

// Set markers on the map:
<x-maps-leaflet :markers="[['lat' => 15.35259733449114, 'long' => 44.1837635452817]]"></x-maps-leaflet>






// Google Maps

// Set the centerpoint of the map:

<x-maps-google :centerPoint="['lat' => 15.35259733449114, 'long' => 44.1837635452817]"></x-maps-google>

// Set a zoomlevel:
<x-maps-google :zoomLevel="10"></x-maps-google>

// Set type of the map (roadmap, satellite, hybrid, terrain):
<x-maps-google :mapType="'terrain'"></x-maps-google>

// Set markers on the map:
<x-maps-google :markers="[['lat' =>  15.35259733449114, 'long' => 44.1837635452817]]"></x-maps-google>

// You can customize the title for each markers:
<x-maps-google :markers="[['lat' => 15.35259733449114, 'long' => 44.1837635452817, 'title' => 'Your Title']]"></x-maps-google>

// Automatically adjust the map's view during initialization to encompass all markers:
<x-maps-google
    :markers="[
        ['lat' => 15.35259733449114, 'long' =>  44.1837635452817],
        ['lat' =>  15.35259733449112, 'long' =>  44.1837635452815]
    ]"
    :fitToBounds="true"
></x-maps-google> --}}

{{-- // Position the map's center at the geometric midpoint of all markers: --}}
{{-- <x-maps-google :centerPoint="['lat' => 15.35259733449114, 'long' => 44.1837635452817]"></x-maps-google> --}}
{{--
<script>
//   const app=  app.get("/",(req-res)=>res.send("Hello World"));
// const app=  require('express')();
// app.get("/",(req,res)=>res.send("Hello World"));
// app.listen(8000)
// console.log("Listening on port 8000");
//     var eventSource = new EventSource('http://localhost:8000/api/v1/deliveries/9c3b9108-f41e-46a6-a5da-0e07c674a082/live-updates');

//     eventSource.onmessage = function(event) {
//          console.log('Message received: ' + event.data);

//     };
//     setTimeout(function(){
//         eventSource.close();
//     }, 5000);
</script> --}}
{{-- <x-maps-google --}}

    {{-- :markers="[

        ['lat' =>  15.35259733449117, 'long' =>  44.1837635452814]
    ]"
     :centerPoint={{ dd($markers) }}
    :centerToBoundsCenter="true"
    :zoomLevel="10" --}}
    {{-- :mapType="'satellite'"  --}}
{{-- ></x-maps-google> --}}



@extends('layout')
@section('title', 'Maps')
@endsection
@section('head', 'active')

@endsection
{{-- @section('content')


@endsection --}}

@section('footer')

@endsection
