<div class="col-12">
	@if($errors->any())
		<ul class="alert alert-danger">
			@foreach($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
		</ul>
	@endif
	@if(Session::get('msg'))
		<p class="alert alert-success">{{Session::get('msg')}}</p>
	@endif
	@if(Session::get('error'))
		<p class="alert alert-danger">{{Session::get('error')}}</p>
	@endif
</div>