@extends('relawan.layout.layout')
@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Riwayat Data Titik Sungai
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
                       <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Sungai</th>
                                    <th>Titik Latitude</th>
                                    <th>Titik Longitude</th>
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
                                    <td><?= substr($item->created_at,8,2) ?> 
                                    <?php 
                                    $bln = substr($item->created_at,5,2);
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
                                    ?> <?= substr($item->created_at,0,4) ?></td>
                                    <td>Sungai Gajah Wong</td>
                                    <td>{{$item->latitude}}</td>
                                    <td>{{$item->longitude}}</td>
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
                                    <form action="{{route('delete_relawan_riwayat',$item->id)}}" method="POST">
                                        <button class="btn btn-default waves-effect">
                                            <i class="material-icons">delete</i>

                                        </button>
                                        {{csrf_field()}}
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
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
                    <?= substr($item->created_at,8,2) ?> 
                    <?php 
                    $bln = substr($item->created_at,5,2);
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
                    ?> <?= substr($item->created_at,0,4) ?>
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
                    @if($item->hasil >= 0 && $item->hasil <= 1.7)
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