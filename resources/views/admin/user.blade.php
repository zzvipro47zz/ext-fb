@extends('admin.master')
@section('title', 'Thành viên')
@section('header-include')
	<!-- DataTables CSS -->
	<link href="libs/sb-admin2/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

	<!-- DataTables Responsive CSS -->
	<link href="libs/sb-admin2/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

	<!-- Social Buttons CSS -->
	<link href="libs/sb-admin2/vendor/bootstrap-social/bootstrap-social.css" rel="stylesheet">
@endsection

@section('footer-include')
	<!-- DataTables JavaScript -->
	<script src="libs/sb-admin2/vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="libs/sb-admin2/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
	<script src="libs/sb-admin2/vendor/datatables-responsive/dataTables.responsive.js"></script>

	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
	<script>
	$(document).ready(function() {
		$('#dataTables-example').DataTable({
			responsive: true
		});

		$('#addUser').click(function() {
			
		});
	});
	</script>
@endsection

@section('page-wrapper')
<div id="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">User</h1>
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-sm-12">
				<a href="#" id="addUser" class="btn btn-success pull-right">Thêm thành viên</a>
			</div>
			<div class="clearfix"></div>
			<div class="col-sm-12">
				<div class="col-sm-8">
					<form action="{{ route('admin.user.create') }}" method="POST" role="form" class="form-horizontal">
						{{ csrf_field() }}
						<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
							<label class="control-label col-sm-3">Name:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="txtName" value="{{ old('txtName') }}">

								@if ($errors->has('txtName'))
									<span class="help-block">
										<strong>{{ $errors->first('txtName') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3">Email:</label>
							<div class="col-sm-9">
								<input type="email" class="form-control" name="txtEmail" value="{{ old('txtEmail') }}">

								@if ($errors->has('name'))
									<span class="help-block">
										<strong>{{ $errors->first('txtEmail') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3">Password:</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" name="txtPassword">

								@if ($errors->has('name'))
									<span class="help-block">
										<strong>{{ $errors->first('txtPassword') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3">Confirm Password:</label>
							<div class="col-sm-9">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>
						<button type="submit" class="btn btn-info pull-right">Submit</button>
					</form>
				</div>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Bảng thống kê thành viên</div>
					<div class="panel-body">
						<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
								<tr>
									<th>STT</th>
									<th>Name</th>
									<th>Email</th>
									<th>Role</th>
									<th>User ID</th>
									<th>AccessToken</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php $stt=0; ?>
							@foreach($users as $user)
								<?php $stt += 1; ?>
								<tr>
									<td>{{ $stt }}</td>
									<td>{{ $user['name'] }}</td>
									<td>{{ $user['email'] }}</td>
									<td>{{ $user['role'] ? 'Admin' : 'Member' }}</td>
									<td>100011795260650</td>
									<td>AccessToken</td>
									<td>
										<a href="user/{{ $user['id'] }}/edit" class="btn btn-info btn-circle btn-lg" title="edit"><i class="fa fa-pencil"></i></a>
										<a href="#" class="btn btn-primary btn-circle btn-lg"><i class="fa fa-facebook"></i></a>
										<a href="user/{{ $user['id'] }}" onclick="confirm('Are you sure you want to delete this user?')" class="btn btn-warning btn-circle btn-lg" title="delete"><i class="fa fa-times"></i></a>
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
	<!-- /.container-fluid -->
</div>
@endsection