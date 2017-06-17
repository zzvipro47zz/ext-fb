@extends('master')
@section('page', 'Xếp hạng cuộc trò chuyện')
@section('page-content')
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">Select User:</span>
					<select id="users" class="form-control" name="friends">
						@foreach($socials as $social)
							<option value="{{ $social['provider_uid'] }}">{{ $social['name'] }}</option>
						@endforeach
					</select>
					<div class="input-group-btn">
						<a href="#" class="btn btn-info" id="get_messrank">Xếp hạng cuộc trò chuyện</a>
					</div>
				</div>
			</div>
		</div>

		@if (isset($messrank))
			<div class="col-md-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Top 15 người nói chuyện với bạn nhiều nhất</h3>
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped" id="dataTables-messrank">
								<thead>
									<tr>
										<th>Hạng</th>
										<th>Tên</th>
										<th>Số tin nhắn</th>
										<th>Trạng thái</th>
										<th>Trò chuyện</th>
									</tr>
								</thead>
								<tbody>
									@foreach($messrank as $key => $value)
										<tr>
											<td>{{ $key+1 }}</td>
											<td>{{ $value['participants']['data'][0]['name'] }}</td>
											<td>{{ $value['message_count'] }}</td>
											<td>{{ $value['can_reply'] === false ? 'Bạn không thể trả lời cuộc trò chuyện này' : ($value['unread_count'] > 0 ? 'Bạn có tin nhắn chưa đọc' : 'true') }}</td>
											<td><a href="https://fb.com/{{ $value['link'] }}" class="btn btn-warning" target="_blank">Trò chuyện</a></td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<div class="box-footer">
						<div class="pull-right">
							<button class="btn btn-warning" id="refresh_messarnk">Refresh</button>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
@endsection
@push('scripts')
	<script>
		$('#get_messrank').click(function() {
			var uid = $('#users').val();
			location.pathname = 'facebook/messenger/' + uid + '/rank';
		});

		$('#refresh_messarnk').click(function() {
			location.reload();
		});
	</script>
@endpush
@push('lib-css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/plugins/datatables/dataTables.bootstrap.css') }}">
@endpush
@push('lib-scripts')
	<script src="{{ asset('js/table.js') }}"></script>
	<!-- DataTables -->
	<script src="{{ asset('libs/adminlte-2.3.11/plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('libs/adminlte-2.3.11/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
@endpush