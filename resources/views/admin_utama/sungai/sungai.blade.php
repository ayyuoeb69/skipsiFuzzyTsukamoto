@extends('admin_utama.layout.layout')
@section('content')
<div class="container" style="padding-top:100px;padding-bottom: 100px">
	<h2 class="judul">Sungai dan Admin</h2>
	@if ($errors->any())
	<div class="col-sm-12" style="margin-bottom: 10px">
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">×</button>
			{{$errors->first()}}
		</div>
	</div>
	@endif
	@if ($message = Session::get('success'))
	<div class="col-sm-12" style="margin-bottom: 10px">
		<div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $message }}</strong>
		</div>
	</div>
	@endif
	<br>
	<br>
	<div class="row">
		<div class="col-sm-4">
			<h4><b>Tambah Sungai</b></h4>
			<hr>
			<form method="POST" action="{{ route('admin_utama_add_sungai') }}" >
				@csrf
				<div class="form-group">
					<label for="usr">Nama Sungai:</label>
					<input type="text" class="form-control" name="sungai">
				</div>
				<button class="btn btn-success">Tambah</button>
			</form>
		</div>
		<div class="col-sm-8">
			<h4><b>List Sungai</b></h4>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Sungai</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					@foreach($sungai as $item)
					<tr>
						<td>{{$i}}</td>
						<td>{{$item->sungai}}</td>
						<td>
							<a href="#" style="float: left;margin-right: 5px">
								<button class="btn btn-info">Edit</button>
							</a>
							<form action="{{route('admin_utama_delete_sungai', $item->id)}}" method="POST">
								<button class="btn btn-danger">Hapus</button>
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
	<br>
	<br>
	<hr>
	<br>
	<div class="row">
		<div class="col-sm-4">
			<h4><b>Tambah Admin Sungai</b></h4>
			<hr>
			<form method="POST" action="{{ route('admin_utama_add_admin_sungai') }}" >
				@csrf
				<div class="form-group">
					<label for="usr">Username Admin Sungai:</label>
					<input type="text" class="form-control" name="username">
				</div>
				<br>
				<div class="form-group">
					<label for="usr">Password Admin Sungai:</label>
					<input type="password" class="form-control" name="password">
				</div>
				<br>
				<div class="form-group">
					<label for="usr">Nomor HP Admin Sungai:</label>
					<input type="text" class="form-control" name="hp">
				</div>
				<br>
				<label for="sel1">Sungai:</label>
				
				  <select name="sungai" class="form-control" id="sel1">
				  	<option value="">-- Pilih Sungai --</option>
				  	@foreach($sungai as $item)
				    <option value="{{$item->id}}">{{$item->sungai}}</option>
				    @endforeach
				  </select>
				  <br>
				  <br>
				<button class="btn btn-success">Tambah</button>
			</form>
		</div>
		<div class="col-sm-8">
			<h4><b>List Admin Sungai</b></h4>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Username Admin Sungai</th>
						<th>HP</th>
						<th>Sungai</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					@foreach($user as $item)
					<tr>
						<td>{{$i}}</td>
						<td>{{$item->username}}</td>
						<td>{{$item->hp}}</td>
						<td>{{$item->sungai}}</td>
						<td>
							<a href="#" style="float: left;margin-right: 5px">
								<button class="btn btn-info">Edit</button>
							</a>
							<form action="{{route('admin_utama_delete_admin', $item->users_id)}}" method="POST">
								<button class="btn btn-danger">Hapus</button>
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
@endsection