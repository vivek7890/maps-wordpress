@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
          @if(isset($trips))
            @forEach($trips as $trip)
              <a href="/user/trip_map/get/details/{{$trip->id}}">{{$trip->trip_name}}</a><br /><br />
            @endForeach
          @endif
        </div>
        <div class="col-md-8">
            <div id="map" style="width: 100%; height: 400px; float: left;">{!!  Mapper::render() !!}</div>
        </div>
          
        <div id="map_data">

        </div>
    </div>
</div>
<script type="text/javascript">

            function addRoute(map) {
                var directionsService = new google.maps.DirectionsService();
                var directionsDisplay = new google.maps.DirectionsRenderer();
                directionsDisplay.setMap(map);
                //var waypts=document.getElementById('waypts').value;
                //directionsDisplay.setPanel(document.getElementById('panel'));

                var request = {
                    origin: '{{Session::get('source')}}',
                    destination: '{{Session::get('destination')}}',
                    waypoints: [
                      {
                        location:'{{Session::get('waypts')[0]}}',
                        stopover:true
                      }
                    ],
                    optimizeWaypoints: true,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                };

                {{--var route = {!! $route !!};--}}
                {{--route.request = request;--}}
                {{--directionsDisplay.setDirections(route);--}}

                directionsService.route(
                    request,
                    function(response, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(response);
                        }
                    }
                );
            }
        </script>
@endsection
