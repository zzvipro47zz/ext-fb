@extends('master')
@section('page', 'Dashboard')
@section('page-content')
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="box box-success box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Các tài khoản facebook mà bạn đã đăng nhập vào hệ thống</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					@if(session('success'))
						<div class="form-group has-success del">
							<label for="success" class="control-label"><i class="fa fa-check"></i> {{ session('success') }}</label>
						</div>
					@endif
					@if(empty($socials))
						<div class="form-group has-error">
							<label for="error" class="control-label"><i class="fa fa-exclamation-triangle"></i> Hiện tại bạn chưa có tài khoản facebook nào ở trong hệ thống của chúng tôi ! Vui lòng đăng nhập để sử dụng dịch vụ của chúng tôi !</label>
						</div>
					@else
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<th>STT</th>
									<th>Name</th>
									<th>Email</th>
								</thead>
								<tbody>
									@foreach($socials as $key => $social)
										<tr>
											<td>{{ $key+1 }}</td>
											<td>{{ $social['name'] }}</td>
											<td>{{ $social['email'] }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
			</div>
		</div>

		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Thông tin tài khoản facebook của bạn</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<form action="{{ route('fb.login') }}" class="form-horizontal" method="post" id="form_login">
						{{ csrf_field() }}
						@if(session('error'))
							<div class="form-group has-error">
								<label for="warning" class="control-label col-md-offset-2"><i class="fa fa-times-circle-o"></i> {{ session('error') }}</label>
							</div>
						@endif
						<div class="form-group{{ Session::has('error') ? ' has-error' : null }}">
							<label for="username" class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="username" placeholder="nhập email hoặc số điện thoại vào đây ...">
							</div>
						</div>

						<div class="form-group{{ Session::has('error') ? ' has-error' : null }}">
							<label for="password" class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input type="password" name="password" class="form-control" placeholder="nhập password vào đây ...">
							</div>
						</div>
					</form>
				</div>
				<div class="box-footer">
					<button class="btn btn-info pull-right" id="login">Đăng nhập</button>
				</div>
			</div>
		</div>
	</div>

	@if(!empty($posts))
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Your Posts</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-hover table-striped table-bordered">
								<thead>
									<tr>
										<td>#</td>
										<td>Name</td>
										<td>ID user</td>
										<td>Message</td>
										<td>Caption</td>
										<td>Image</td>
										<td>Time</td>
									</tr>
								</thead>
								<tbody>
									@foreach($posts as $key => $value)
										<tr>
											<td>{{ $key+1 }}</td>
											<td>{{ $value['name'] }}</td>
											<td>{{ $value['provider_uid'] }}</td>
											<td>{{ $value['message'] }}</td>
											<td>{{ $value['caption'] }}</td>
											<td>{{ $value['image'] }}</td>
											<td>{{ date('d.m.Y \v\à\o\ \l\ú\c H:i', $value['post_at']) }}</td>
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
		$('#login').click(function(e) {
			e.preventDefault();
			$('#form_login').submit();
		});
	</script>
@endpush