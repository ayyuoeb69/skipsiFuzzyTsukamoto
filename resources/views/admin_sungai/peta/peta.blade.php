@extends('admin_sungai.layout.layout')
@section('content')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $( document ).ready(function() {    
        titik(-7.7980802,110.3789628);
        sungai();
    });
    var marker;
    var mapOptions;
    var map;
    function verif(id){
        var infowindow = new google.maps.InfoWindow({
            map: map
        });  
        $.ajax({
            url : "{{ url('/titik/verif/') }}"+"/"+id,
            dataType : 'json',
            data : {'_token': '{{csrf_token()}}'},
            type : 'POST',
            success : function(data){

               console.log(data);
               map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 14,
                center: {lat: parseFloat(data.latitude), lng: parseFloat(data.longitude)},
            });
               var titik_sekarang = {lat: parseFloat(data.latitude), lng: parseFloat(data.longitude)};
               placeMarker(titik_sekarang);
               sungai();
           },
           error : function(){
            alert("error");
        }
    });
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
    function titik(lat_value,lng_value){


        map = new google.maps.Map(document.getElementById('map-canvas'), {
            zoom: 12,
            center: {lat: lat_value, lng: lng_value},
        });
        
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
                        Peta Titik Sungai
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
                           <div id="address-map-container" style="width:100%;height:400px; ">
                            <div style="width: 100%; height: 100%" id="map-canvas"></div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Username</th>
                                    <th>Hasil</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody id="table-body">
                                <?php $i = 1; ?>
                                @foreach($data_input as $item)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td><?= substr($item->tanggal,8,2) ?> 
                                    <?php 
                                    $bln = substr($item->tanggal,5,2);
                                    if($bln == "01"){
                                        echo "Januari";
                                    }elseif($bln == "02"){
                                        echo "Februari";
                                    }elseif($bln == "03"){
                                        echo "Maret";
                                    }elseif($bln == "04"){
                                        echo "April";
                                    }elseif($bln == "05"){
                                        echo "Mei";
                                    }elseif($bln == "06"){
                                        echo "Juni";
                                    }elseif($bln == "07"){
                                        echo "Juli";
                                    }elseif($bln == "08"){
                                        echo "Agustus";
                                    }elseif($bln == "09"){
                                        echo "September";
                                    }elseif($bln == "10"){
                                        echo "Oktober";
                                    }elseif($bln == "11"){
                                        echo "November";
                                    }elseif($bln == "12"){
                                        echo "Desember";
                                    }
                                    ?> <?= substr($item->tanggal,0,4) ?></td>
                                    <td>{{$item->username}}</td>
                                    <td>
                                        @if($item->hasil >= 0 && $item->hasil <= 1.7)
                                        <span class="label label-danger">Tercemar Berat</span>
                                        @elseif($item->hasil > 1.7 && $item->hasil <= 2.5)
                                        <span class="label label-warning">Tercemar Sedang</span>
                                        @elseif($item->hasil > 2.5 && $item->hasil <= 3.2)
                                        <span class="label label-info" style="background-color: yellow;color:black">Tercemar Ringan</span>
                                        @elseif($item->hasil > 3.2 && $item->hasil <= 4)
                                        <span class="label label-primary">Tidak Tercemar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->status == 0)
                                        Konfirmasi Admin
                                        @elseif($item->status == 1)
                                        Diterima
                                        @elseif($item->status == 2)
                                        Ditolak
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-default waves-effect" data-toggle="modal" data-target="#defaultModal<?= $i ?>">
                                            <i class="material-icons">visibility</i>
                                        </button>
                                        <br>
                                        <br>
                                        <button type="button" class="btn btn-info waves-effect" onclick="verif('{{$item->id}}')">
                                            <i class="material-icons">place</i>
                                        </button>
                                        @if($item->status != 1)
                                        <br>
                                        <br>
                                         <form action="{{route('admin_sungai_setuju',$item->id)}}" method="POST">
                                        <button class="btn btn-success waves-effect">
                                            <i class="material-icons">check_box</i>
                                        </button>
                                        {{csrf_field()}}
                                            <input type="hidden" name="_method" value="PUT">
                                        </form>
                                        @endif
                                        @if($item->status != 2)
                                        <br>
                                        <br>
                                        <form action="{{route('admin_sungai_tolak',$item->id)}}" method="POST">
                                            <button class="btn btn-danger waves-effect">
                                                <i class="material-icons">remove_circle</i>

                                            </button>
                                            {{csrf_field()}}
                                            <input type="hidden" name="_method" value="PUT">
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $i = 1; ?>
@foreach($data_input as $item)
<div class="modal fade" id="defaultModal<?= $i ?>" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="largeModalLabel">Detail Data Input</h3>
            </div>
            <div class="modal-body">
                <h5>TANGGAL</h5>
                <p class="m-t-15 m-b-30">
                    <?= substr($item->tanggal,8,2) ?> 
                    <?php 
                    $bln = substr($item->tanggal,5,2);
                    if($bln == "01"){
                        echo "Januari";
                    }elseif($bln == "02"){
                        echo "Februari";
                    }elseif($bln == "03"){
                        echo "Maret";
                    }elseif($bln == "04"){
                        echo "April";
                    }elseif($bln == "05"){
                        echo "Mei";
                    }elseif($bln == "06"){
                        echo "Juni";
                    }elseif($bln == "07"){
                        echo "Juli";
                    }elseif($bln == "08"){
                        echo "Agustus";
                    }elseif($bln == "09"){
                        echo "September";
                    }elseif($bln == "10"){
                        echo "Oktober";
                    }elseif($bln == "11"){
                        echo "November";
                    }elseif($bln == "12"){
                        echo "Desember";
                    }
                    ?> <?= substr($item->tanggal,0,4) ?>
                </p>
                <hr>
                <h5>SUNGAI</h5>
                <p class="m-t-15 m-b-30">
                    Sungai Gajah Wong
                </p>
                <hr>
                <h5>LATITUDE</h5>
                <p class="m-t-15 m-b-30">
                    {{$item->latitude}}
                </p>
                <hr>
                <h5>LONGITUDE</h5>
                <p class="m-t-15 m-b-30">
                    {{$item->longitude}}
                </p>
                <hr>
                <h5>HASIL DEFUZZY</h5>
                <p class="m-t-15 m-b-30">
                    {{$item->hasil}}
                </p>
                <hr>
                <h5>HASIL</h5>
                <p class="m-t-15 m-b-30">
                    @if($item->hasil >= 1 && $item->hasil <= 1.7)
                    <span class="label label-danger">Tercemar Berat</span>
                    @elseif($item->hasil > 1.7 && $item->hasil <= 2.5)
                    <span class="label label-warning">Tercemar Sedang</span>
                    @elseif($item->hasil > 2.5 && $item->hasil <= 3.2)
                    <span class="label label-info" style="background-color: yellow;color:black">Tercemar Ringan</span>
                    @elseif($item->hasil > 3.2 && $item->hasil <= 4)
                    <span class="label label-primary">Tidak Tercemar</span>
                    @endif
                </p>
                <hr>
                <h5>STATUS</h5>
                <p class="m-t-15 m-b-30">
                    @if($item->status == 0)
                    Konfirmasi Admin
                    @elseif($item->status == 1)
                    Diterima
                    @elseif($item->status == 2)
                    Ditolak
                    @endif
                </p>
                <hr>
                <h5><b>DETAIL INPUT</b></h5>
                <hr>
                @foreach($detail as $item2)
                @if($item->id == $item2->data_input_id)
                <h5>{{$item2->nama_variable}}</h5>
                <div class="form-group">
                    <div class="form-line">
                        <input type="text" class="form-control" value="{{$item2->inputan}}" readonly />
                    </div>
                </div>
                <hr>
                @endif
                @endforeach
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
<?php $i++ ?>
@endforeach
@endsection