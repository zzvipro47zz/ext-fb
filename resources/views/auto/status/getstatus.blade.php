@extends('master')
@section('page', 'Status')
@section('page-content')
	<div class="row">
		<div class="col-md-6 col-sm-12 col-xs-12">
			@if(session('error'))
				<div class="form-group has-error">
					<label for="error" class="control-label"><i class="fa fa-exclamation-triangle"></i> {{ session('error') }}</label>
				</div>
			@endif

			<div class="input-group">
				<span class="input-group-addon">Select User:</span>
				<select name="users-getstt" id="users" class="form-control">
					@foreach($users as $u)
						<option value="{{ $u['provider_uid'] }}" selected="{{ old('users-getstt') }}">{{ $u['name'] }}</option>
					@endforeach
				</select>
				<div class="input-group-btn">
					<a href="#" class="btn btn-info" id="get_status">GET STATUS</a>
				</div>
			</div>
		</div>

		@if(isset($data))
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-6">
						<button class="btn btn-warning btn-block">Delete</button>
					</div>

					<div class="col-md-6">
						<button class="btn btn-danger btn-block">Delete ALL</button>
					</div>
				</div>
			</div>
		@endif
	</div>

	<div class="margin"></div>

	@if(isset($data))
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Bài viết của {{ $user['name'] }}</h3>
					</div>
					<div class="box-body">
						<form action="" class="form-group" id="status">
							<h4>You choose <span class="label label-success" id="count-checkbox-status">0</span> post to delete</h4>
							@foreach($data as $news)
								<div class="box box-info box-solid" id_post="{{ $news->id }}">
									<div class="box-header with-border">
										<h3 class="box-title">
											<a href="{{ $news->attachments->url or 'https://fb.com/'.$user['provider_uid'] }}" target="_blank">{{ $news->story or $user['name']}}</a>
										</h3>
									</div>
									<div class="box-body">
										{!! isset($news->message) ? '<h3>'.$news->message.'</h3>' : null !!}
										@if(!empty($news->attachments))
											@if(isset($news->attachments->media->image->src))
												<a href="{{ $news->attachments->url }}" target="_blank"><img src="{{ $news->attachments->media->image->src }}" class="img-thumbnail img-responsive"></a>
											@elseif(preg_match('/video.*/i', $news->attachments->type))
												<video src="{{ $news->attachments->url }}" poster="{{ $news->attachments->media->image->src }}" preload="auto" controls></video>
											@else
												{{-- life_event --}}
												<a href="{{ $news->attachments->url }}"><h2>{{ $news->attachments->title }}</h2></a>
											@endif
											{!! isset($news->attachments->title) ? '<h4>'.$news->attachments->title.'</h4>' : null !!}
											{!! isset($news->attachments->description) ? '<blockquote>'.$news->attachments->description.'</blockquote>' : null !!}
										@endif
									</div>
								</div>
							@endforeach
						</form>
					</div>
				</div>
				<button class="btn btn-info btn-block" id="load_more_post">Xem thêm</button>
			</div>
		</div>
	@endif
@endsection
@push('scripts')
	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		// lấy id fb user cần get stt
		var uid = '';

		$('#get_status').on('click', function() {
			uid = $('#users').val();
			$(this).attr('href', '/facebook/wall/status/'+uid);
		});

		$('#load_more_post').click(function() {
			uid = $('#users').val();
			$.post('/facebook/wall/status/'+uid+'/lmp', function(data) {
				if (data == 'okay') {
					$('#load_more_post').remove();
				} else {
					var html = '';
					$.each(data, function(key, value) {
						html += '<div class="box box-info box-solid" id_post="' + value.id + '">\
									<div class="box-header with-border">\
										<h3 class="box-title">\
											<a href="' + (value.attachments !== undefined ? value.attachments.url : '{{ isset($user) ? 'https://fb.com/'.$user['provider_uid'] : null }}') + '" target="_blank">' + (value.story ? value.story : '{{ isset($user) ? $user['name'] : null }}') + '</a>\
										</h3>\
									</div>\
									<div class="box-body">'
										+ (value.message != undefined ? '<h3>' + value.message + '</h3>' : '')
										+ (value.attachments !== undefined ?
											(value.attachments.media !== undefined ?
												'<a href="' + value.attachments.url + '" target="_blank"><img src="' + value.attachments.media.image.src + '" class="img-thumbnail img-responsive"></a>' :
												(/video/.test(value.attachments.type) ?
													'<video src="' + value.attachments.url + '" poster="' + value.attachments.media.image.src + '" preload="auto" controls></video>' :
													/* life_event */ '<a href="' + value.attachments.url + '"><h2>' + value.attachments.title + '</h2></a>'
												)
											) : ''
										)
										+ (value.attachments !== undefined ? '<h4>' + value.attachments.title + '</h4>' : '')
										+ (value.attachments !== undefined ? (value.attachments.description !== undefined ? '<blockquote>' + value.attachments.description + '</blockquote>' : '') : '')
									+'</div>\
								</div>';
					});
					$('#status').append(html);
				}
			});
		});

		// gán vô cho Status của (user)
		var user = $('#users option').html();
		$('#user').html(user);
	</script>
@endpush