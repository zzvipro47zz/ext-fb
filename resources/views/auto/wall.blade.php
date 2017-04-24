@extends('master')
@section('page-wrapper')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-2">
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="{{ url('facebook/wall/status') }}">Your Posts</a></li>
				<li><a href="{{ url('facebook/wall/postwall') }}">Post Wall</a></li>
			</ul>
		</div>
		<div class="col-sm-8">
			@yield('wall')
		</div>
	</div>
</div>
@endsection