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
					<span class="info-box-number">760</span>
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
					<span class="info-box-number">235</span>
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
		@if(empty($users))
			<div class="form-group has-error">
				<label for="error" class="control-label"><i class="fa fa-exclamation-triangle"></i> Bạn chưa đăng nhập tài khoản facebook vào trong hệ thống !</label>
			</div>	
		@else
		<div class="input-group">
			<span class="input-group-addon">Select User:</span>
			<select class="form-control" name="user" id="users">
				@foreach($users as $user)
					<option value="{{ $user['provider_uid'] }}">{{ $user['name'] }}</option>
				@endforeach
			</select>
			<div class="input-group-btn">
				<a href="#" class="btn btn-info" id="get_friends">GET FRIEND</a>
			</div>
		</div>
		@endif
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-md-6">
					<button class="btn btn-primary">Unfriend theo danh sách</button>
				</div>
				<div class="col-md-6">
					<button class="btn btn-warning">Unfriend ALL</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="margin"></div>

	@if(isset($friends))
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Bạn bè của <label class="control-label" for="user" id="user"></label></h3>
				</div>
				<div class="box-body">
					@if(session('success'))
						<div class="form-group has-success del">
							<label for="unfriend" class="control-label"><i class="fa fa-check"></i> {{ session('success') }}</label>
						</div>
					@endif
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
												<a type="button" href="{{ 'https://fb.com/'.$friend->id }}" target="_blank" class="btn btn-info" title="Link to profile"><i class="fa fa-link"></i></a>
												<a type="button" href="#" id_friend="{{ $friend->id }}" class="btn btn-warning unfriend" title="Unfriend"><i class="fa fa-user-times"></i></a>
											</div>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
@endsection
@push('scripts')
	<script>
		$('.unfriend').on('click', function() {
			var uid = (window.location.pathname).match(/(\d+)/g)[0];
			var id = $(this).attr('id_friend');
			$(this).attr('href', '/facebook/' + uid + '/' + id + '/unfriend');
		});

		// mới đầu vô gán uid đang chọn cho #get_friends
		var user = $('#users').val();
		$('#get_friends').attr('href', '/facebook/'+user+'/friends');
		// sau đó mỗi lần thay đổi user thì cập nhật uid vô #get_friends
		$('#users').on('change', function() {
			var user = $(this).val();
			$('#get_friends').attr('href', '/facebook/'+user+'/friends');
		});
		// gán vô cho bạn bè của (user)
		var user = $('#users option').html();
		$('#user').html(user);
	</script>
@endpush