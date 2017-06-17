@extends('master')
@section('page', 'Những người bạn đã và đang theo dõi')
@section('page-content')
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">Select User:</span>
					<select id="socials" class="form-control" name="friends">
						@foreach($socials as $social)
							<option value="{{ $social['provider_uid'] }}">{{ $social['name'] }}</option>
						@endforeach
					</select>
					<div class="input-group-btn">
						<a href="#" class="btn btn-info" id="get_subto">GET</a>
					</div>
				</div>
			</div>
		</div>

		@if(isset($subto))
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<button class="btn btn-primary btn-block" id="unfollow_from_list">Unfollow theo danh sách</button>
						</div>
					</div>

					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<button class="btn btn-warning btn-block" id="unfollow_all">Unfollow ALL</button>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-info box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Các trạng thái mà bạn cần lưu ý !</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="box-body">
					<ul>
						<li><span class="badge bg-orange">pending</span> đã gửi lời mời kết bạn nhưng họ chưa đồng ý. Những người này có thể bạn đang theo dõi họ</li>
						<li><span class="badge bg-blue">follow</span> bạn đang theo dõi họ</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
	<script>
		$('#subto').click(function() {
			var uid = $('#socials').val();
			var url = '/facebook/subto/' + uid;
			location.path = url;
		});
	</script>
@endpush