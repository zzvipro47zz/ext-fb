@extends('master')
@section('page', 'Friends')
@section('page-content')
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			@if(empty($users))
				<div class="form-group has-error">
					<label for="error" class="control-label"><i class="fa fa-exclamation-triangle"></i> Bạn chưa đăng nhập tài khoản facebook vào trong hệ thống !</label>
				</div>	
			@else
				<form action="{{ route('fb.getFriends') }}" method="post">
					{{ csrf_field() }}
					<div class="input-group">
						<span class="input-group-addon">Select User:</span>
						<select class="form-control" name="user" id="users">
							@foreach($users as $user)
								<option value="{{ $user['provider_uid'] }}">{{ $user['name'] }}</option>
							@endforeach
						</select>
						<div class="input-group-btn">
							<button type="submit" class="btn btn-info">GET FRIEND</button>
						</div>
					</div>
				</form>
			@endif
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			@if(isset($friends))
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Bạn bè của <label class="control-label" for="user" id="user"></label></h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table id="dataTables-friends" class="table table-bordered table-striped table-hover">
								<thead>
									<th>STT</th>
									<th>ID</th>
									<th>Name</th>
									<th>Action</th>
								</thead>
								<tbody>
									@foreach($friends as $key => $friend)
										<tr>
											<td>{{ $key+1 }}</td>
											<td>{{ $friend->id }}</td>
											<td>{{ $friend->name }}</td>
											<td>
												<div class="btn-group">
													<button type="button" href="{{ 'https://fb.com/'.$friend->id }}" target="_blank" class="btn btn-info" title="Link to profile"><i class="fa fa-link"></i></button>
													<button type="button" href="" class="btn btn-warning" title="Unfriend"><i class="fa fa-user-times"></i></button>
												</div>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
@endsection
@push('scripts')
	<script>
		var user = $('#users option').html();
		$('#user').html(user);
	</script>
@endpush