@extends('relawan.layout.layout')
@section('content')
<div class="col-xs-12 col-sm-12">
	<div class="card">
		<div class="header">
			<h2>
				Beranda
			</h2>

		</div>
		<div class="body">
			<div>
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
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane fade in active" id="profile_settings">
						<div class="panel panel-default panel-post">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
