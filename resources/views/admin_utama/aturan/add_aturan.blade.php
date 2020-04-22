@extends('admin_utama.layout.layout')
@section('content')
<div class="container" style="padding-top:100px">
	<h2 class="judul">Aturan / Rule Fuzzy</h2>
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
	<div class="row" style="margin-bottom: 40px">
		<div class="col-sm-12">
			<h4><b>Tambah Aturan</b></h4>
			<hr>
			<form method="POST" action="{{ route('admin_utama_add_aturan') }}" >
				@csrf
				<p><b>IF</b></p>
				<?php 
				$total = count($variable_input);
				$i = 1;
				?>
				@foreach($variable_input as $item)
				<div class="form-group">
					<input type="text" class="form-control" name="nama_variable" value="{{$item->nama_variable}}" readonly>
				</div>
				<div class="form-group">
					<select name="himpunan_input[]" class="form-control" id="sel1">
						<option value="">-- Pilih Himpunan --</option>
						@foreach($himpunan as $item2)
						@if($item->id == $item2->variable_id)
						<option value="{{$item2->id}}">{{$item2->nama_himpunan}}</option>
						@endif
						@endforeach
					</select>
				</div> 
				<br>
				@if($i!=$total)
				<select name="operator" class="form-control" style="width:200px">
					<option value="">-- Pilih Operator --</option>
					<option value="and">AND</option>
					<option value="or">OR</option>
				</select>
				<br>
				<br>
				@endif
				<?php $i++; ?>
				@endforeach
				<p><b>THEN</b></p>
				@foreach($variable_output as $item)
				<div class="form-group">
					<input type="text" class="form-control" name="nama_variable" value="{{$item->nama_variable}}" readonly>
				</div>
				<div class="form-group">
					<select name="himpunan_output" class="form-control" id="sel1">
						<option value="">-- Pilih Himpunan --</option>
						@foreach($himpunan as $item2)
						@if($item->id == $item2->variable_id)
						<option value="{{$item2->id}}">{{$item2->nama_himpunan}}</option>
						@endif
						@endforeach
					</select>
				</div> 
				<br>
				@endforeach
				<button class="btn btn-success">Tambah Aturan</button>
			</form>
		</div>
	</div>
</div>
@endsection