@extends('admin_sungai.layout.layout')
@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    User Relawan
                </h2>
                <br>
                <button type="button" data-toggle="modal" data-target="#defaultModal" class="btn btn-success waves-effect">
                    Tambah Data
                </button>
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
                                    <th>Username Relawan</th>
                                    <th>HP</th>
                                    <th>Sungai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody id="table-body">
                                <?php $i = 1; ?>
                                @foreach($user as $item)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$item->username}}</td>
                                    <td>{{$item->hp}}</td>
                                    <td>{{$item->sungai}}</td>
                                    <td>
                                     <button type="button" class="btn btn-primary waves-effect">
                                        <i class="material-icons">create</i>
                                    </button>
                                    <br>
                                    <br>
                                    <form action="{{route('delete_relawan',$item->users_id)}}" method="POST">
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
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="largeModalLabel">Tambah Relawan</h3>
            </div>
            <div class="modal-body">
                <div class="form-line">
                    <label for="usr">Username Relawan:</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <br>
                <div class="form-line">
                    <label for="usr">Password Relawan:</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <br>
                <div class="form-line">
                    <label for="usr">Nomor HP Relawan:</label>
                    <input type="text" class="form-control" name="hp">
                </div>
                <br>
                <button type="button" class="btn btn-success waves-effect">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
