@extends('master')
@section('page', 'Status')
@section('page-content')
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			<div class="input-group">
				<span class="input-group-addon">Select User:</span>
				<select name="users-getstt" id="users" class="form-control">
					@foreach($socials as $social)
						<option value="{{ $social['provider_uid'] }}" {{ old('users-getstt') ? 'selected' : null }}">{{ $social['name'] }}</option>
					@endforeach
				</select>
				<div class="input-group-btn">
					<a href="" class="btn btn-info" id="get_status">GET STATUS</a>
				</div>
			</div>
		</div>

		@if(isset($stt_data))
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<button class="btn btn-warning btn-block">Delete</button>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<button class="btn btn-danger btn-block">Delete ALL</button>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>

	@if(session('success') || session('error'))
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-{{ (session('success') ? 'success' : 'warning') }} alert-dismissable fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-{{ (session('success') ? 'check' : 'warning') }}"></i> Thông báo!</h4>
					{!! session('success') ? session('success') : session('error') !!}
				</div>
			</div>
		</div>
	@endif

	@if(isset($stt_data))
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Bài viết của {{ @$user['name'] }}</h3>
					</div>
					<div class="box-body">
						<form action="" class="form-group">
							<div class="row" id="status">
								@foreach($stt_data as $value)
									<div class="col-md-12">
										<div class="box box-primary box-solid">
											<div class="box-header with-border">
												<h3 class="box-title">{{ $value['story'] or $user['name'] }}</h3>
												<span class="time pull-right"><i class="fa fa-clock-o"></i> {{ $value['created_time'] }}</span>
											</div>
											<div class="box-body">
												<h3>{!! $value['message'] or '' !!}</h3>
												@if($value['type'] == 'link')
													<div class="text-center">
														<img src="{{ $value['full_picture'] or '' }}">
													</div>
												@elseif($value['type'] == 'photo')
													<img src="{{ $value['full_picture'] }}" class="img-responsive img-thumbnail center-block">
												@elseif($value['type'] == 'video')
													<div class="text-center">
														<video src="{{ $value['source'] }}" preload="none" poster="{{ $value['full_picture'] }}" controls></video>
													</div>
												@endif
												<blockquote>
													{!! isset($value['description']) ? '<p>' . $value['description'] . '</p>' : null !!}
													<small>POSTED BY <cite>{{ $value['name'] or $user['name'] }}</cite></small>
												</blockquote>
											</div>
											<div class="box-footer">
												<a href="{{ $value['link'] or 'https://fb.com/'.$value['id'] }}" class="btn btn-primary" target="_blank">Read more</a>
												<a href="{{ route('fb.delstt', [$user['provider_uid'], $value['id']]) }}" class="btn btn-danger">Delete</a>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</form>
					</div>
					<div class="box-footer">
						<a href="#" class="btn btn-primary btn-block" id="load_more_stt">Xem Thêm</a>
					</div>
				</div>
			</div>
		</div>
	@endif
@endsection
@push('scripts')
	<script>
		$('#get_status').on('click', function() {
			var uid = $('#users').val();
			var url = '/facebook/status/' + uid;
			$(this).attr('href', url);
		});
		
		$('#load_more_stt').click(function() {
			var url = '{{ route('fb.stt.lmp', [$user['provider_uid']]) }}';
			$.post(url, function(data) {
				if (data == 'okay') {
					$('#load_more_post').remove();
				} else {
					var html = '';
					$.each(data, function(key, value) {
						var type = '';
						var full_picture = value['full_picture'] || false;
						var message = value['message'] || false;
						var description = value['description'] || false;
						var name = value['name'] || '{{ @$user['name'] }}';
						var link = value['link'] || 'https://fb.com/' + value['id'];

						if(value['type'] == 'link' || value['type'] == 'photo') {
							type = full_picture !== false ? '<img src="' + full_picture + '" class="img-responsive img-thumbnail center-block">' : '';
						} else if(value['type'] == 'video') {
							type = '<video src="' + value['source'] + '" preload="none" poster="' + full_picture + '" controls>browser không hỗ trợ video</video>';
						} else if(value['type'] == 'status') {
							type = message !== false ? '<h3>' + message + '</h3>' : '';
						}
						html += '<div class="col-md-12">\
									<div class="box box-primary box-solid">\
										<div class="box-header with-border">\
											<h3 class="box-title">' + (value['story'] || '{{ @$user['name'] }}') + '</h3>\
											<span class="time pull-right"><i class="fa fa-clock-o"></i> ' + value['created_time'] + '</span>\
										</div>\
										<div class="box-body">'
											+ (value['type'] !== 'status' ? (message !== false ? '<h3>' + value['message'] + '</h3>' : '') : '')
											+ '<div class="text-center">' + type + '</div>\
											<blockquote>'
												+ (description !== false ? '<p>' + description + '</p>' : '')
												+ '<small>POSTED BY <cite>' + name + '</cite></small>\
											</blockquote>\
										</div>\
										<div class="box-footer">\
											<a href="' + link + '" class="btn btn-primary" target="_blank">Read more</a>\
											<a href="{{ route('fb.delstt', [$user['provider_uid'], $value['id']]) }}" class="btn btn-danger">Delete</a>\
										</div>\
									</div>\
								</div>';
					});
					$('#status').append(html);
				}
			});
			return false;
		});

		// gán vô cho Status của (user)
		var user = $('#users option').html();
		$('#user').html(user);
	</script>
@endpush