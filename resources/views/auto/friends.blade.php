@extends('master')
@section('page', 'Friends')
@section('page-content')
	<div class="row">
		<div class="col-md-6">
			<div class="input-group">
				<span class="input-group-addon">Select User</span>
				<select class="form-control">
					@foreach($users as $user)
						<option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
					@endforeach
				</select>
				<div class="input-group-btn">
					<button class="btn btn-info" id="get_friends">GET FRIEND</button>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix visible-md-block"></div>

	<div class="row">
		<div class="col-md-12">
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
		</div>
	</div>
@endsection
@push('scripts')
	<script type="text/javascript">
		$('#get_friends').click(function() {
			$.ajax({
				url: '{{ fb('graph', $users->id . '/friends') }}', // đg bị lỗi ở đây
				type: 'post',
				data: [
					'access_token' => $users->access_token
				],
				success: function(responseText) {
					console.log(responseText);
				}
			});
		});
	</script>
@endpush