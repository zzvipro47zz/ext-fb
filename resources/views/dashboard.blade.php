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
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Nhập password facebook của bạn</h3>
				</div>
				<div class="box-body">
					@if(isset($error))
						<div class="form-group has-error">
							<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> Wrong password</label><br />
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-key"></i></span>
								<input type="password" class="form-control" id="inputError" placeholder="nhập password facebook của bạn vào đây ...">
								<span class="input-group-btn">
									<button class="btn btn-info btn-flat" id="confirm">Xác nhận</button>
								</span>
							</div>
							<span class="help-block">Bạn đã nhập sai pass cho tài khoản này, xin vui lòng nhập lại !</span>
						</div>
					@else
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-key"></i></span>
							<input type="password" class="form-control" placeholder="nhập password facebook của bạn vào đây ...">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-info btn-flat" id="confirm">Xác nhận</button>
							</span>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
	<script src="{{ asset('js/confirm_password_fb.js') }}"></script>
@endpush