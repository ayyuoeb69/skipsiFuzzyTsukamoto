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
	<a href="{{route('admin_utama_add_aturan')}}">
		<button class="btn btn-success">Tambah Aturan</button>
	</a>
	<br>
	<br>
	<div class="row">
		<div class="col-sm-12">
			<h4><b>List Aturan</b></h4>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Aturan</th>
						<th>Detail</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					@foreach($aturan as $item)
					<tr>
						<td>{{$i}}</td>
						<td>{{$item->nama_aturan}}</td>
						<td>
							<?php $j = 0; ?>
							@foreach($detail as $item2)
								@if($item2->aturan_id == $item->id && $item2->status == 0)
									@if($j == 0)
										<b>IF</b>
									@endif
									<p>{{$item2->nama_variable}} 
									{{$item2->nama_himpunan}}</p>
									<b>AND</b>
									<?php $j++; ?>
								@elseif($item2->aturan_id == $item->id && $item2->status == 1)
									<b>THEN</b>
									<p>{{$item2->nama_variable}} 
									{{$item2->nama_himpunan}}</p>
								@endif
							@endforeach
						</td>
						<td>
							<form action="{{route('admin_utama_delete_aturan', $item->id)}}" method="POST">
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