@extends('relawan.layout.layout')
@section('content')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).ready(function() {    
        var lat_input = document.getElementById("titik_lat");
        var lng_input = document.getElementById("titik_lng");
        var lat_value = document.getElementById("titik_lat_value");
        var lng_value = document.getElementById("titik_lng_value");

        if ("geolocation" in navigator){
            navigator.geolocation.getCurrentPosition(function(position){ 
                var currentLatitude = position.coords.latitude;
                var currentLongitude = position.coords.longitude;
                lat_input.value = currentLatitude;
                lng_input.value = currentLongitude;
                lat_value.value = currentLatitude;
                lng_value.value = currentLongitude;
                titik(lat_value.value,lng_value.value );
            });
        }
    });
    var marker;
    var mapOptions;
    var map
    function titik(lat_value,lng_value){

        if(lat_value==null && lng_value==null){
            var lat= -7.8279434;
            var lng= 110.3992647;
        }else{
            var lat = parseFloat(lat_value);
            var lng = parseFloat(lng_value);

        }
        map = new google.maps.Map(document.getElementById('map-canvas'), {
            zoom: 14,
            center: {lat: lat, lng: lng},
        });
        var titik_sekarang = {lat: lat, lng: lng};
        placeMarker(titik_sekarang);
        google.maps.event.addListener(map, 'click', function (e) {
         document.getElementById("titik_lat").value = e.latLng.lat();
         document.getElementById("titik_lng").value = e.latLng.lng();
         document.getElementById("titik_lat_value").value = e.latLng.lat();
         document.getElementById("titik_lng_value").value = e.latLng.lng();
         placeMarker(e.latLng);
     });
        sungai();
    }



    function placeMarker(location) {
        if(marker){
            marker.setPosition(location);
        }else {
            marker = new google.maps.Marker({
              position: location,
              map: map
          });
        }
    }
    function sungai(){

        var polyOptions = {
            strokeColor : 'rgba(30, 63, 207, 0.5)',
            strokeOpacity: 1.0,
            strokeWeight: 6,
            clickable : true,
            zIndex : 4,
            draggable: true,
        };
        var temp;

        var dasar2;
        var garis_dasar = [];
        <?php $i=0; foreach($dasar as $item){ ?>
            $.ajax({
                url : "{{ url('/titik/sungai/'.$item->id_kel_dasar_sub) }}",     
                dataType : 'json',
                data : {'_token': '{{csrf_token()}}'},
                type : 'POST',
                success : function(data){
                    console.log(data);
                    var dasar<?= $i ?>=[];
                    for (var i = 0; i < data.length; i++){
                        temp = {lat: parseFloat(data[i].lat_koor_dasar), lng: parseFloat(data[i].lng_koor_dasar)};
                        dasar<?= $i ?>.push(temp);
                    }
                    var poly2<?= $i ?> = new google.maps.Polyline({
                        path: dasar<?= $i ?>,
                        geodesic: true,
                        strokeOpacity: 1.0,
                        strokeColor : 'rgba(30, 63, 207, 0.5)',
                        clickable : true,
                        map:map,
                        strokeWeight: 6,
                        zIndex : 1,
                        clickable : false
                    });
                    poly2<?= $i ?>.setMap(map);
                },
                error : function(){
                    alert("errore");
                }
            });
            <?php $i++; } ?>
        }

    </script>
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Input Data Titik Sungai
                    </h2>

                </div>
                <div class="body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{$errors->first()}}
                    </div>
                    @endif
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('relawan_add_data') }}" >
                                @csrf
                                @foreach($variable as $item)
                                <h2 class="card-inside-title">{{$item->nama_variable}}</h2>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="nama_variable[]" placeholder="Masukkan {{$item->nama_variable}}" />
                                    </div>
                                </div>
                                @endforeach
                                <br>
                                <h2 class="card-inside-title">Pilih Titik Koordinat</h2>
                                <div id="address-map-container" style="width:100%;height:400px; ">
                                    <div style="width: 100%; height: 100%" id="map-canvas"></div>
                                </div>
                                <br>
                                <h2 class="card-inside-title">LOKASI KOORDINAT</h2>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="titik_lat" name="titik_lat" placeholder="Latitude" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="titik_lng" name="titik_lng" placeholder="Longitude" />
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="titik_lat_value" name="titik_lat_value" />
                                    <input type="hidden" id="titik_lng_value" name="titik_lng_value" />

                                </div>

                                <button class="btn btn-primary m-t-15 waves-effect">Submit</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection