@extends('master')
@section('page', 'Dashboard')
@section('page-content')
	<!-- Info boxes -->
	<div class="row">
		<div class="col-md-3 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-aqua"><i class="ion-android-contacts"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Tổng Friend</span>
					<span class="info-box-number">9,999</span>
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
					<span class="info-box-number">41,410</span>
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
	
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="box box-success collapsed-box box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Các tài khoản facebook mà bạn đã đăng nhập vào hệ thống</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
					</div>
				</div>
				<div class="box-body">
					@if(session('success'))
						<div class="form-group has-success">
							<label for="success" class="control-label"><i class="fa fa-check"></i> {{ session('success') }}</label>
						</div>
					@endif
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<th>STT</th>
								<th>Name</th>
								<th>Email</th>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>Bin PC</td>
									<td>noname_pk69@yahoo.com</td>
								</tr>
								<tr>
									<td>1</td>
									<td>Bin PC</td>
									<td>noname_pk69@yahoo.com</td>
								</tr>
								<tr>
									<td>1</td>
									<td>Bin PC</td>
									<td>noname_pk69@yahoo.com</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<div class="clearfix visible-md-block"></div>

		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="box box-info collapsed-box box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Thông tin tài khoản facebook của bạn</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
					</div>
				</div>
				<div class="box-body">
					@if(Auth::user())
						<form action="{{ route('login') }}" class="form-horizontal" method="post">
						{{ csrf_field() }}
							@if(session('error'))
								<div class="form-group has-error">
									<label for="warning" class="control-label col-offset-2 col-sm-2"><i class="fa fa-times-circle-o"></i> {{ session('error') }}</label>
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
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
	<script>
		if ($('.has-success')) {
			setTimeout(function() {
				$('.has-success').fadeOut('slow', function() {
					$(this).remove();
				});
			}, 5000);
		}
	</script>
@endpush