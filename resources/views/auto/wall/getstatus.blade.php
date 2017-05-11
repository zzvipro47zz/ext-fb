@extends('master')
@section('page', 'Status')
@section('page-content')
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
						<a href="#" class="btn btn-info" id="get_friends">GET STATUSES</a>
					</div>
				</div>
			@endif
		</div>
		<div class="col-md-6 col-sm-12 col-xs-12">
			
		</div>
	</div>

	<div class="row">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title">Lấy những bài viết bạn đã đăng lên tường nhà</h3>
			</div>
			<div class="box-body">
				<form action="" class="form-group">
					<h4>You choose <span class="label label-success" id="count-checkbox-status">0</span> of <span class="label label-warning" id="all_post">0</span> post to delete</h4>
					
					<div class="pull-right">
						<button type="submit" class="btn btn-warning">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
	<script>
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