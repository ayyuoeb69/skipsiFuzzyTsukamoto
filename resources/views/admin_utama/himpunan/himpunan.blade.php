@extends('admin_utama.layout.layout')
@section('content')
<script type="text/javascript">
	window.onload = function() {
		var chart = new CanvasJS.Chart("chartContainer", {
			title: {
				text: "Derajat Keanggotaan"
			},
			data: [
			<?php foreach ($himpunan as $item) { ?>
				{
					name: "{{$item->nama_himpunan}}",
					type: "line",
					showInLegend: true,
					dataPoints: [
					<?php foreach($titik as $item2){ 
						if($item->id == $item2->himpunan_id){
							?>
							{ x: {{$item2->titikx}}, y: {{$item2->titiky}} },
						<?php }
					}
					?>
					]
				},
			<?php } ?>
			]
		});
		chart.render();
	}
</script>
<div class="container" style="padding-top:100px">
	<h2 class="judul">Himpunan Fuzzy Variable {{$variable->nama_variable}}</h2>
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
	
	<div class="row">

		<div class="col-sm-12">
			<a href="{{route('admin_utama_himpunan_setting',$variable->id)}}">
				<button class="btn btn-success">Tambah Himpunan Fuzzy</button>
			</a>
			<br>
			<br>
			<h4><b>List Himpunan</b></h4>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Himpunan</th>
						<th>Fungsi</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					@foreach($himpunan as $item)
					<tr>
						<td>{{$i}}</td>
						<td style="text-transform:capitalize;">{{$item->nama_himpunan}}</td>
						<td style="text-transform:capitalize;">{{$item->fungsi}}</td>
						<td>
							<form action="{{route('admin_utama_delete_himpunan', $item->id)}}" method="POST">
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
	<div class="row">
		<div id="chartContainer" style="height: 270px; width: 100%;">
		</div>
	</div>
</div>
@endsection