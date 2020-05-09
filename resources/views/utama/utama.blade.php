<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>PETA STATUS MUTU AIR</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
    <!-- Waves Effect Css -->
    <link href="{{ asset('assets/plugins/node-waves/waves.css')}}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('assets/plugins/animate-css/animate.css')}}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{ asset('assets/plugins/morrisjs/morris.css')}}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">

    <script src="{{ asset('assets/js/jque.js')}}"></script>
    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('assets/css/themes/all-themes.css')}}" rel="stylesheet" />
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPU0Y6pTubcYNjKyQMslqJJDtl8Ndbf6E&libraries=places&callback=initialize" async defer></script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2W1d-W8PCeKlDO35qHS3aF3CjmYH8_NE&sensor=false" async defer></script>
</head>

<body class="theme-red">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $( document ).ready(function() {    
            titik(-7.7980802,110.3789628);
             semua_titik();
            sungai();
        });
        var marker;
        var mapOptions;
        var map;
        function titik(lat_value,lng_value){
            map = new google.maps.Map(document.getElementById('map-canvas'), {
                zoom: 12,
                center: {lat: lat_value, lng: lng_value},
            });
        }
        function filter(){
            titik(-7.7980802,110.3789628);
            
            var tanggal = $("input[name=tanggal]").val();
            $.ajax({
                url : "{{ url('/titik/filter_kualitas_sungai/') }}",     
                dataType : 'json',
                data : {'_token': '{{csrf_token()}}', 'tanggal':tanggal},
                type : 'POST',
                success : function(data){
                    var biru = {
                        url: '<?= asset("img/blue.png") ?>',
                    };
                    var kuning = {
                        url: '<?= asset("img/yellow.png") ?>',
                    };
                    var orange = {
                        url: '<?= asset("img/orange.png") ?>',
                    };
                    var merah = {
                        url: '<?= asset("img/red.png") ?>',
                    };
                    var marker = [];
                    var toolTips;
                    var temp;
                    for (var i = 0; i < data.length; i++){
                        var titik = data[i];

                        var infowindow = new google.maps.InfoWindow({
                            map: map,
                        });
                        if(data[i].hasil >= 1 && data[i].hasil <= 1.7){
                            marker[i] = new google.maps.Marker({
                                position: {lat: parseFloat(data[i].latitude), lng: parseFloat(data[i].longitude)},
                                map: map,
                                icon: merah,
                                id : data[i].id,
                                status : "Tercemar Berat",
                                waktu_kirim : data[i].tanggal,
                                relawan : data[i].username,
                                zIndex : 2,
                            });
                        }else if(data[i].hasil > 1.7 && data[i].hasil <= 2.5){
                            marker[i] = new google.maps.Marker({
                                position: {lat: parseFloat(data[i].latitude), lng: parseFloat(data[i].longitude)},
                                map: map,
                                icon: orange,
                                id : data[i].id,
                                status : "Tercemar Sedang",
                                waktu_kirim : data[i].tanggal,
                                relawan : data[i].username,
                                zIndex : 2,
                            });
                        }else if(data[i].hasil > 2.5 && data[i].hasil <= 3.2){
                            marker[i] = new google.maps.Marker({
                                position: {lat: parseFloat(data[i].latitude), lng: parseFloat(data[i].longitude)},
                                map: map,
                                icon: kuning,
                                id : data[i].id,
                                status : "Tercemar Ringan",
                                waktu_kirim : data[i].tanggal,
                                relawan : data[i].username,
                                zIndex : 2,
                            });
                        }else if(data[i].hasil > 3.2 && data[i].hasil <= 4){
                            marker[i] = new google.maps.Marker({
                                position: {lat: parseFloat(data[i].latitude), lng: parseFloat(data[i].longitude)},
                                map: map,
                                icon: biru,
                                id : data[i].id,
                                status : "Tidak Tercemar",
                                waktu_kirim : data[i].tanggal,
                                relawan : data[i].username,
                                zIndex : 2,
                            });
                        }
                        google.maps.event.addListener(marker[i], 'click', function(event) {    
                    
                    toolTips='<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<div class="row">'+                            
                    '<div class="col-sm-5"><label><b>User Relawan: </b></label></div><div class="col-sm-7">'+this.relawan+'</div>'+
                    '</div>'+
                    '<br>'+
                    '<div class="row">'+
                    '<div class="col-sm-5"><label><b>Status Sungai : </b></label></div><div class="col-sm-7">'+this.status+'</div>'+
                    '</div>'+
                    '<br>'+
                    '<div class="row">'+                            
                    '<div class="col-sm-5"><label><b>Waktu Pengambilan: </b></label></div><div class="col-sm-7">'+this.waktu_kirim+' WIB</div>'+
                    '</div><br><br>'+
                    '<div class="row"><div class="col-sm-12">'+
                    '<button class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="modal_maps(\''+this.id+'\')">Detail Pengambilan</button>'
                    '</div></div>'+

                    '</div>';

                    infowindow.setPosition(event.latLng);
                    infowindow.setContent(toolTips);
                    infowindow.open( map);
                });
                    }

                },
                error : function(err){
                    alert(err);
                }
            });
        sungai();
        }
        function semua_titik(){
              $.ajax({
                url : "{{ url('/titik/kualitas_sungai/') }}",     
                dataType : 'json',
                data : {'_token': '{{csrf_token()}}'},
                type : 'POST',
                success : function(data){
                    console.log(data);
                    var biru = {
                        url: '<?= asset("img/blue.png") ?>',
                    };
                    var kuning = {
                        url: '<?= asset("img/yellow.png") ?>',
                    };
                    var orange = {
                        url: '<?= asset("img/orange.png") ?>',
                    };
                    var merah = {
                        url: '<?= asset("img/red.png") ?>',
                    };
                    var marker = [];
                    var toolTips;
                    var temp;
                    for (var i = 0; i < data.length; i++){
                        var titik = data[i];

                        var infowindow = new google.maps.InfoWindow({
                            map: map,
                        });
                        if(data[i].hasil >= 1 && data[i].hasil <= 1.7){
                            marker[i] = new google.maps.Marker({
                                position: {lat: parseFloat(data[i].latitude), lng: parseFloat(data[i].longitude)},
                                map: map,
                                icon: merah,
                                id : data[i].id,
                                status : "Tercemar Berat",
                                waktu_kirim : data[i].tanggal,
                                relawan : data[i].username,
                                zIndex : 2,
                            });
                        }else if(data[i].hasil > 1.7 && data[i].hasil <= 2.5){
                            marker[i] = new google.maps.Marker({
                                position: {lat: parseFloat(data[i].latitude), lng: parseFloat(data[i].longitude)},
                                map: map,
                                icon: orange,
                                id : data[i].id,
                                status : "Tercemar Sedang",
                                waktu_kirim : data[i].tanggal,
                                relawan : data[i].username,
                                zIndex : 2,
                            });
                        }else if(data[i].hasil > 2.5 && data[i].hasil <= 3.2){
                            marker[i] = new google.maps.Marker({
                                position: {lat: parseFloat(data[i].latitude), lng: parseFloat(data[i].longitude)},
                                map: map,
                                icon: kuning,
                                id : data[i].id,
                                status : "Tercemar Ringan",
                                waktu_kirim : data[i].tanggal,
                                relawan : data[i].username,
                                zIndex : 2,
                            });
                        }else if(data[i].hasil > 3.2 && data[i].hasil <= 4){
                            marker[i] = new google.maps.Marker({
                                position: {lat: parseFloat(data[i].latitude), lng: parseFloat(data[i].longitude)},
                                map: map,
                                icon: biru,
                                id : data[i].id,
                                status : "Tidak Tercemar",
                                waktu_kirim : data[i].tanggal,
                                relawan : data[i].username,
                                zIndex : 2,
                            });
                        }
                        google.maps.event.addListener(marker[i], 'click', function(event) {    
                    
                    toolTips='<div id="content">'+
                    '<div id="siteNotice">'+
                    '</div>'+
                    '<div class="row">'+                            
                    '<div class="col-sm-5"><label><b>User Relawan: </b></label></div><div class="col-sm-7">'+this.relawan+'</div>'+
                    '</div>'+
                    '<br>'+
                    '<div class="row">'+
                    '<div class="col-sm-5"><label><b>Status Sungai : </b></label></div><div class="col-sm-7">'+this.status+'</div>'+
                    '</div>'+
                    '<br>'+
                    '<div class="row">'+                            
                    '<div class="col-sm-5"><label><b>Waktu Pengambilan: </b></label></div><div class="col-sm-7">'+this.waktu_kirim+' WIB</div>'+
                    '</div><br><br>'+
                    '<div class="row"><div class="col-sm-12">'+
                    '<button class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="modal_maps(\''+this.id+'\')">Detail Pengambilan</button>'
                    '</div></div>'+

                    '</div>';

                    infowindow.setPosition(event.latLng);
                    infowindow.setContent(toolTips);
                    infowindow.open( map);
                });
                    }

                },
                error : function(){
                    alert("errore");
                }
            });
        }
        function modal_maps(id){
            $.ajax({
                url : "{{ url('/titik/detail_kualitas_sungai/') }}"+"/"+id,     
                dataType : 'json',
                data : {'_token': '{{csrf_token()}}'},
                type : 'POST',
                success : function(data){
                    var toolTips = '';
                    for(i=0;i<data.length;i++){
                     toolTips+='<h5>'+data[i].nama_variable+'</h5>'+
                    '<div class="form-group">'+
                        '<div class="form-line">'+
                            '<input type="text" class="form-control" value="'+data[i].inputan+'" readonly />'+
                        '</div>'+
                    '</div>'+
                    '<hr>';
                    }
                    $( ".modal-body" ).html(toolTips);

                },
                error : function(){
                    alert("errore");
                }
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
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="preloader">
                    <div class="spinner-layer pl-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
                <p>Please wait...</p>
            </div>
        </div>
        <!-- #END# Page Loader -->
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        <!-- #END# Overlay For Sidebars -->
        <!-- Top Bar -->
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="index.html">PETA STATUS MUTU AIR</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Call Search -->
                        <li>
                            <a href="{{route('login')}}">
                                <button class="btn btn-warning">LOGIN</button>
                            </a>
                        </li>
                        <!-- #END# Call Search -->
                        <!-- Notifications -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- #Top Bar -->

        <section>
            <!-- Left Sidebar -->
            <aside id="leftsidebar" class="sidebar">
                <!-- #User Info -->
                <!-- Menu -->

                <div class="menu">
                    <ul class="list" >
                        <li class="header">MENU</li>
                        <li style="padding-left: 5px;padding-right: 5px">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <h5>
                                        <b>Pilih Tanggal</b>
                                    </h5>
                                    <br>
                                    <input type="date" class="form-control" name="tanggal">
                                </div>
                            </div>
                        </li>
                        <br>
                        <li style="text-align: center;padding-left: 5px;padding-right: 5px">
                            <button class="btn btn-success" onclick="filter()" >Cari Titik</button>
                        </li>
                        <li style="padding-left: 5px;padding-right: 5px">
                            <hr>
                            <p><b>Keterangan : </b></p>
                        </li>
                        <li>
                            <p style="position: relative;top:8px"><img src="<?php echo asset('img/red.svg') ?>" style="width: 40px;">Status Titik Tercemar Berat</p>
                            <br>
                        </li>
                        <li>
                            <p style="position: relative;top:8px"><img src="<?php echo asset('img/orange.svg') ?>" style="width: 40px;">Status Titik Tercemar Sedang</p>
                            <br>
                        </li>
                        <li>
                            <p style="position: relative;top:8px"><img src="<?php echo asset('img/yellow.svg') ?>" style="width: 40px;">Status Titik Tercemar Ringan</p>
                            <br>
                        </li>
                        <li>
                            <p style="position: relative;top:8px"><img src="<?php echo asset('img/d.svg') ?>" style="width: 40px;">Status Titik Tidak Tercemar</p>
                        </li>
                    </ul>
                </div>
                <!-- #Menu -->
                <!-- Footer -->

                <!-- #Footer -->
            </aside>
            <!-- #END# Left Sidebar -->
        </section>

        <section class="content">
            <div class="container-fluid" style="height: 550px;">
                <div style="width: 100%; height: 100%" id="map-canvas"></div>

            </div>
        </section>
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Detail</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- Jquery Core Js -->
        <script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script>


        <!-- Bootstrap Core Js -->
        <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.js')}}"></script>

        <!-- Select Plugin Js -->

        <!-- Slimscroll Plugin Js -->
        <script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.js')}}"></script>

        <!-- Waves Effect Plugin Js -->
        <script src="{{ asset('assets/plugins/node-waves/waves.js')}}"></script>

        <!-- Jquery DataTable Plugin Js -->
        <script src="{{ asset('assets/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
        <script src="{{ asset('assets/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

        <!-- Custom Js -->
        <script src="{{ asset('assets/js/admin.js')}}"></script>

        <!-- Demo Js -->
        <script src="{{ asset('assets/js/demo.js')}}"></script>
    </body>

    </html>
