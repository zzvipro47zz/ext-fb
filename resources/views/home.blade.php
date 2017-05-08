@extends('master')
@section('page', 'Dashboard')
@section('page-content')
	@if(Auth::user())
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
						@if(!isset($socials))
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
										@foreach($socials as $social)
											<tr>
												<td>1</td>
												<td>{{ $social['name'] }}</td>
												<td>{{ $social['email'] }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
								<div class="form-group has-success">
									<label class="control-label"><i class="fa fa-check"></i> Password facebook của các bạn đã được mã hóa !</label>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
			
			<div class="clearfix visible-md-block"></div>

			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="box box-info box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">Thông tin tài khoản facebook của bạn</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<form action="{{ route('fb.login') }}" class="form-horizontal" method="post">
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
							<div class="box-footer">
								<button type="submit" class="btn btn-info pull-right">Đăng nhập</button>
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
		if ($('.del')) {
			setTimeout(function() {
				$('.del').fadeOut('slow', function() {
					$(this).remove();
				});
			}, 5000);
		}
	</script>
@endpush