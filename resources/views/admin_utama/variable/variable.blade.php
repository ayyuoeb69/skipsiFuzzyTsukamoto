@extends('admin_utama.layout.layout')
@section('content')
<div class="container" style="padding-top:100px">
	<h2 class="judul">Variable Fuzzy</h2>
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
			<h4><b>Tambah Data</b></h4>
			<hr>
			<form method="POST" action="{{ route('admin_utama_add_variable') }}" >
				@csrf
				<div class="form-group">
					<label for="usr">Nama Variable:</label>
					<input type="text" class="form-control" name="nama_variable">
				</div>
				 <div class="form-group">
				  <label for="sel1">Jenis:</label>
				  <select name="status" class="form-control" id="sel1">
				  	<option value="">-- Pilih Variable --</option>
				    <option value="0">Variable Input</option>
				    <option value="1">Variable Output</option>
				  </select>
				</div> 
				<button class="btn btn-success">Tambah</button>
			</form>
		</div>
		<div class="col-sm-8">
			<h4><b>List Data</b></h4>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Variable</th>
						<th>Jenis</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					@foreach($variable as $item)
					<tr>
						<td>{{$i}}</td>
						<td>{{$item->nama_variable}}</td>
						<td>
							@if($item->status == 0)
							Variable Input
							@else
							Variable Output							
							@endif
						</td>
						<td>
							<a href="{{route('admin_utama_himpunan', $item->id)}}" style="float: left;margin-right: 5px">
								<button class="btn btn-info">Setting Himpunan Fuzzy</button>
							</a>
							<br>
							<br>
							<form action="{{route('admin_utama_delete_variable', $item->id)}}" method="POST">
								<button class="btn btn-danger">Hapus</button>
								{{csrf_field()}}
								<input type="hidden" name="_method" value="DELETE">
							</form>
						</td>
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