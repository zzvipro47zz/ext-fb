@extends('master')
@section('page', 'Friends')
@section('page-content')
@if(isset($friends))
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="ion-android-contacts"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Tổng Friend</span>
					<span class="info-box-number">{{ count($friends) }}</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>

		<!-- /.col -->
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-red"><i class="ion-android-person-add"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Tổng lượt Follow</span>
					<span class="info-box-number">0</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->

		<!-- fix for small devices only -->
		<div class="clearfix visible-sm-block"></div>

		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="fa fa-thumbs-up"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Tổng Like</span>
					<span class="info-box-number">0</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>

		<!-- /.col -->
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-yellow"><i class="fa fa-file-text"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Tổng bài đăng</span>
					<span class="info-box-number">0</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->
	</div>
@endif
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			@if(!isset($socials))
				<div class="form-group has-error">
					<label for="error" class="control-label"><i class="fa fa-exclamation-triangle"></i> Bạn chưa đăng nhập tài khoản facebook vào trong hệ thống !</label>
				</div>	
			@else
				<div class="input-group">
					<span class="input-group-addon">Select User:</span>
					<select class="form-control" id="socials">
						@foreach($socials as $social)
							<option value="{{ $social['provider_uid'] }}">{{ $social['name'] }}</option>
						@endforeach
					</select>
					<div class="input-group-btn">
						<a href="#" class="btn btn-info" id="get_friends">GET FRIEND</a>
					</div>
				</div>
			@endif
		</div>

		@if(isset($friends))
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<button class="btn btn-primary btn-block" id="unfriend_from_list">Unfriend theo danh sách</button>
					</div>

					<div class="col-md-6 col-sm-12 col-xs-12">
						<button class="btn btn-warning btn-block">Unfriend ALL</button>
					</div>
				</div>
			</div>
		@endif
	</div>
	
	<div class="margin"></div>

	@if(isset($friends))
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Bạn bè của <label class="control-label" for="social" id="social"></label></h3>
				</div>
				<div class="box-body">
					@if(session('success'))
						<div class="form-group has-success del">
							<label for="unfriend" class="control-label"><i class="fa fa-check"></i> {{ session('success') }}</label>
						</div>
					@endif
					<form action="{{ route('fb.ufl', $user['provider_uid']) }}" method="post">
						{{ csrf_field() }}
						<div class="table-responsive">
							<table id="dataTables-friends" class="table table-bordered table-striped table-hover">
								<thead>
									<th>STT</th>
									<th>Profile Picture</th>
									<th>ID</th>
									<th>Name</th>
									<th>Action</th>
								</thead>
								<tbody>
									@foreach($friends as $key => $friend)
										<tr>
											<td>{{ $key+1 }}</td>
											<td>
												<img src="{{ stripslashes($friend->picture) }}" alt="Ảnh đại diện của {{ $friend->name }}">
											</td>
											<td>
												<label for="id_friend" id="id_friend">{{ $friend->id }}</label>
												<input type="checkbox" class="pull-right" name="list_friend[]" value="{{ $friend->id }}">
											</td>
											<td>{{ $friend->name }}</td>
											<td>
												<div class="btn-group">
													<a type="button" href="{{ 'https://fb.com/'.$friend->id }}" target="_blank" class="btn btn-info" title="Link to profile"><i class="fa fa-link"></i></a>
													<a type="button" href="#" id="unfriend" class="btn btn-warning" title="Unfriend"><i class="fa fa-user-times"></i></a>
												</div>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endif
@endsection
@push('scripts')
	<script>
		$('#unfriend_from_list').click(function() {
			$('form').submit();
		});

		$('#get_friends').click(function() {
			var uid = $('#socials').val();
			$(this).attr('href', '/facebook/friends/'+uid);
			$(this).addClass('disabled');
		});

		$('#unfriend').on('click', function() {
			var uid = (window.location.pathname).match(/(\d+)/g)[0];
			var id = $('#unfriend').val();
			$(this).attr('href', '/facebook/friends/' + uid + '/' + id);
		});

		// gán vô cho bạn bè của (socials)
		var socials = $('#socials option').html();
		$('#social').html(socials);
	</script>
@endpush