@extends('master')
@section('page', 'Unfriend')
@section('page-content')
	<div class="row">
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
	
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Auto Unfriend</h3>
				</div>
				<div class="box-body">
					<form action="unfriend" class="form-group" method="post">
						<h4>You choose <span class="label label-success" id="count-checkbox-unfriend">0</span> of <span id="all" class="label label-warning">{{ $total_count }}</span> friends to Unfriend</h4><br />
						<table class="table table-striped table-bordered table-hover" id="dataTables-unfriend">
							<thead>
								<tr>
									<th style="width:30px;"><input type="checkbox" id="check_all"></th>
									<th>Name</th>
									{{-- <th>Image</th> --}}
									<th>Link</th>
								</tr>
							</thead>
							<tbody>
								@foreach($friends as $friend)
									<tr>
										<td><input type="checkbox" name="unfriend[]"></td>
										<td>{{ $friend->name }}</td>
										{{-- <td><img src="{{ asset('images/a.jpg') }}" alt="Image" class="image"></td> tạm thời chưa có hình--}}
										<td><a href="https://fb.com/{{ $friend->id }}" target="_blank" class="btn btn-primary">Link to Facebook</a></td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<div class="pull-right">
							<button type="submit" class="btn btn-info btn-lg">Gửi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		checkbox('unfriend');
	</script>
@endpush