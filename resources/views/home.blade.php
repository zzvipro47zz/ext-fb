@extends('master')
@section('page', 'Dashboard')
@section('page-content')
	<div class="row">
		<div class="col-md-offset-3 col-md-6 col-sm-12 col-xs-12">
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
								<input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="nhập email hoặc số điện thoại vào đây ...">
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

		<div class="col-md-12 col-sm-12 col-xs-12">
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
									<th>Friends</th>
									<th>Subscribers</th>
									<th>Active</th>
									<th>Status</th>
								</thead>
								<tbody>
									@foreach($socials as $key => $social)
										<tr>
											<td>{{ $key+1 }}</td>
											<td>{{ $social['name'] }}</td>
											<td>{{ $social['email'] }}</td>
											<td>{{ $social['friends'] }}</td>
											<td>{{ $social['subs'] }}</td>
											<td>{{ ($social['active'] === 1 ? 'true' : 'false') }}</td>
											<td>{{ $social['status'] === null ? 'Hoạt động' : $social['status'] }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
				<div class="box-footer">
					<div class="pull-right">
						<a href="/updatefbaccount" class="btn btn-info">Cập nhật tài khoản facebook</a>
					</div>
				</div>
			</div>
		</div>

	</div>
@endsection
@push('scripts')
	<script>
		document.getElementById('login').onclick = function() {
			$('#form_login').submit();
		};
	</script>
@endpush