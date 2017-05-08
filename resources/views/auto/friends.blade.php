@extends('master')
@section('page', 'Friends')
@section('page-content')
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			@if(!$users)
				<div class="form-group has-error">
					<label for="error" class="control-label"><i class="fa fa-exclamation-triangle"></i> Bạn chưa đăng nhập tài khoản facebook vào trong hệ thống !</label>
				</div>	
			@else
				<div class="input-group">
					<span class="input-group-addon">Select User</span>
					<select class="form-control" id="friends" name="user">
						@foreach($users as $user)
							<option value="{{ $user['provider_uid'] }}">{{ $user['name'] }}</option>
						@endforeach
					</select>
					<div class="input-group-btn">
						<button class="btn btn-info" id="get_friends">GET FRIEND</button>
					</div>
				</div>
			@endif
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			@if($users)
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<th>STT</th>
							<th>ID</th>
							<th>Tên</th>
							<th>Link</th>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>uid</td>
								<td>Bin PC</td>
								<td>
									<button class="btn btn-info">Link</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			@endif
		</div>
	</div>
@endsection
@push('scripts')
	<script type="text/javascript">
		$('#get_friends').click(function(event) {
			event.preventDefault();
			var uid = $('#friends option').val();
			// lấy danh sách bạn bè của user được chọn
			var url = 'http://localhost:8000/facebook/' + uid + '/friends';

			$.ajax({
				url: url,
				type: 'get',
				dataType: 'json',
				success: function(responseText) {
					if (responseText == 'okay') {
						console.log(responseText);
					}
				}
			});
		});
	</script>
@endpush