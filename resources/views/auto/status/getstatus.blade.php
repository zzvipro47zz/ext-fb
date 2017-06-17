@extends('master')
@section('page', 'Status')
@section('page-content')
	<div class="row">
		<div class="col-md-5 col-sm-12 col-xs-12">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">Select User:</span>
					<select name="users-getstt" id="socials" class="form-control">
						@foreach($socials as $social)
							<option value="{{ $social['provider_uid'] }}">{{ $social['name'] }}</option>
						@endforeach
					</select>
					<div class="input-group-btn">
						<button id="get_status" class="btn btn-info">GET</button>
					</div>
				</div>
			</div>
		</div>

		@if(isset($stt_data))
			<div class="col-md-7 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="form-group">
							<button id="load_more_stt" class="btn btn-warning btn-block">Load more status</button>
						</div>
					</div>

					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="form-group">
							<button id="check_del_stt" class="btn btn-warning btn-block">Check to Delete</button>
						</div>
					</div>

					<div class="clearfix visible-sm-block"></div>

					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="form-group">
							<button id="check_all" class="btn btn-danger btn-block">Check ALL</button>
						</div>
					</div>

					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="form-group">
							<button id="uncheck_all" class="btn btn-danger btn-block">UnCheck ALL</button>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>

	@if(session('success') || session('error'))
		<div class="row {{ session('del') ? 'del' : null }}">
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
						<h3 class="box-title">Bài viết của <label class="control-label" for="user">{{ $user['name'] }}</label></h3>
					</div>
					<div class="box-body">
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
											@if ($value['type'] === 'video')
												<div class="embed-responsive embed-responsive-16by9">
													<video class="embed-responsive-item" src="{{ $value['source'] }}" preload="none" poster="{{ $value['full_picture'] }}" controls></video>
												</div>
											@elseif ($value['type'] == 'photo')
												<img src="{{ $value['full_picture'] }}" class="img-responsive img-thumbnail center-block">
											@elseif ($value['type'] == 'link')
												@if(isset($value['full_picture']))
													{{-- <div class="text-center"> --}}
													<img src="{{ $value['full_picture'] }}" class="img-responsive img-thumbnail center-block">
													{{-- </div> --}}
												@endif
											@endif
											<blockquote>
												{!! isset($value['description']) ? '<p>' . $value['description'] . '</p>' : null !!}
												<small>POSTED BY <cite>{{ $value['name'] or $user['name'] }}</cite></small>
											</blockquote>
										</div>
										<div class="box-footer">
											<div class="form-group">
												<input type="checkbox" class="minimal-red" name="list_stt[]" value="{{ $value['id'] }}">
												<a href="{{ $value['link'] or 'https://fb.com/'.$value['id'] }}" class="btn btn-primary" target="_blank">Read more</a>
												<a href="{{ route('fb.delstt', [$user['provider_uid'], $value['id']]) }}" class="btn btn-danger">Delete</a>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
					<div class="box-footer">
						<button id="load_more_stt" class="btn btn-primary btn-block">Xem Thêm</button>
					</div>
				</div>
			</div>
		</div>
	@endif
@endsection
@push('scripts')
	<script>
		document.getElementById('get_status').onclick = function() {
			let uid = document.getElementById('socials').value;
			let url = '/facebook/status/' + uid;
			location.pathname = url;
		};

		$(document).on('click', '#load_more_stt', function() {
			let lmstt = $(this);
			lmstt.addClass('disabled');
			let url = '{{ route('fb.stt.lmp', @$user['provider_uid']) }}';
			$.post(url, function(data) {
				if (data == 'okay') {
					lmstt.remove();
				} else if (typeof data === 'object') {
					var html = '';
					$.each(data, function(key, value) {
						let url_delstt = '/facebook/status/' + {{ @$user['provider_uid'] }} + '/' + value['id'];
						let type = value['type'];
						let full_picture = value['full_picture'] || false;
						let message = value['message'] || false;
						let description = value['description'] || false;
						let name = value['name'] || '{{ @$user['name'] }}';
						let link = value['link'] || 'https://fb.com/' + value['id'];
						let story = value['story'] || '{{ @$user['name'] }}';
						let tag = '';

						if(type == 'link' || type == 'photo') {
							tag = full_picture !== false ? '<img src="' + full_picture + '" class="img-responsive img-thumbnail center-block">' : '';
						} else if(type == 'video') {
							tag = '<div class="embed-responsive embed-responsive-16by9"><video class="embed-responsive-item" src="' + value['source'] + '" preload="none" poster="' + full_picture + '" controls>browser không hỗ trợ video</video></div';
						} else if(type == 'status') {
							tag = message !== false ? '<h3>' + message + '</h3>' : '';
						}
						// + (type !== 'status' ? (message !== false ? '<h3>' + message + '</h3>' : '') : '')
						html += '<div class="col-md-12">\
									<div class="box box-primary box-solid">\
										<div class="box-header with-border">\
											<h3 class="box-title">' + story + '</h3>\
											<span class="time pull-right"><i class="fa fa-clock-o"></i> ' + value['created_time'] + '</span>\
										</div>\
										<div class="box-body">' + tag + '\
											<blockquote>'
												+ (description !== false ? '<p>' + description + '</p>' : '')
												+ '<small>POSTED BY <cite>' + name + '</cite></small>\
											</blockquote>\
										</div>\
										<div class="box-footer">\
											<a href="' + link + '" class="btn btn-primary" target="_blank">Read more</a>\
											<a href="' + url_delstt + '" class="btn btn-danger">Delete</a>\
										</div>\
									</div>\
								</div>';
					});
					$('#status').append(html);
				}
			}).done(function() {
				lmstt.removeClass('disabled');
			});
		});

		$('#socials option[value="{{ @$user['provider_uid'] }}"]').prop('selected', true);

		$('input[type="checkbox"].minimal-red').iCheck({
			checkboxClass: 'icheckbox_minimal-red icheckbox_square-red',
			increaseArea: '20%'
		});
	</script>
@endpush
@push('lib-css')
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/plugins/iCheck/all.css') }}">
@endpush
@push('lib-scripts')
	<!-- iCheck 1.0.1 -->
	<script src="{{ asset('libs/adminlte-2.3.11/plugins/iCheck/icheck.min.js') }}"></script>
@endpush