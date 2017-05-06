@extends('master')
@section('page', 'Friends')
@section('page-content')
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label for="select_user">Select User:</label>
				<select class="form-control">
				@foreach($users as $user)
					<option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
				@endforeach
				</select>
			</div>
		</div>
	</div>
@endsection