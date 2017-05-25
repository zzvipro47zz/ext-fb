@extends('master')
@section('page', 'Friends')
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
						<a href="#" class="btn btn-info" id="get_friends">GET FRIEND</a>
					</div>
				</div>
			</div>
		</div>

		@if(isset($friends_data))
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<button class="btn btn-primary btn-block" id="unfriend_from_list">Unfriend theo danh sách</button>
						</div>
					</div>

					<div class="col-md-6 col-sm-12 col-xs-12">
						<div class="form-group">
							<button class="btn btn-warning btn-block">Unfriend ALL</button>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
	
	@if(session('error') || session('success'))
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				@if(session('error'))
					<div class="alert alert-warning del">
						<strong>Warning!!!</strong><label for="error" class="control-label"><i class="fa fa-exclamation-triangle"></i> {{ session('error') }}</label>
					</div>
				@elseif(session('success'))
					<div class="alert alert-success del">
						<strong>Success!!!</strong><label for="success" class="control-label"><i class="fa fa-check"></i> {{ session('success') }}</label>
					</div>
				@endif
			</div>
		</div>
	@endif

	<div class="margin"></div>

	@if(isset($friends_data))
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Bạn bè của <label class="control-label" for="social" id="social"></label></h3>
					</div>
					<div class="box-body">
						<form action="{{ route('fb.ufl', $user['provider_uid']) }}" method="post" id="friends">
							{{ csrf_field() }}
							@foreach($friends_data as $value)
							{{-- {{dd(route('fb.unfriend', $user['provider_uid'], $value['id']))}} --}}
								<div class="col-md-4 col-sm-12 col-xs-12">
									<div class="box box-widget widget-user">
										@if(isset($value['cover']))
											<div class="widget-user-header bg-black img" style="background: url('{{ $value['cover']['source'] }}') center;">
										@else
											<div class="widget-user-header bg-aqua-active">
										@endif
											<h3 class="widget-user-username">{{ $value['name'] }}</h3>
											<h5 class="widget-user-desc">{{ $value['id'] }}</h5>
										</div>
										<div class="widget-user-image">
											<img class="img-circle" src="{{ $value['picture'] }}" alt="User Avatar">
										</div>
										<div class="box-footer">
											<div class="row">
												<div class="col-sm-4 border-right">
													<div class="description-block">
														<h5 class="description-header"><a href="https://fb.com/{{ $value['id'] }}" class="btn btn-primary" target="_blank"><i class="fa fa-link"></i></a></h5>
														<span class="description-text">LINK</span>
													</div>
												</div>
												<div class="col-sm-4 border-right">
													<div class="description-block">
														<h5 class="description-header">13,000</h5>
														<span class="description-text">FOLLOWERS</span>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="description-block">
													<h5 class="description-header"><a href="/facebook/friends/{{ $user['provider_uid'].'/'.$value['id'] }}" class="btn btn-danger"><i class="fa fa-user-times"></i></a></h5>
													<span class="description-text">UNFRIEND</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</form>
					</div>
					<div class="box-footer">
						<button class="btn btn-primary btn-block" id="load_more_friends">Xem thêm</button>
					</div>
				</div>
			</div>
		</div>
	@endif
@endsection
@push('scripts')
	<script>
		$('#load_more_friends').click(function(e) {
			e.preventDefault();
			var url = '{{ isset($user['provider_uid']) ? route('fb.lmf', $user['provider_uid']) : null }}';
			$.post(url, function(data) {
				var html = '';
				$.each(data, function(key, value) {
					html += '<div class="col-md-4 col-sm-12 col-xs-12">\
								<div class="box box-widget widget-user">\
									<div class="widget-user-header ' + (value['cover'] != undefined ? 'bg-black' : 'bg-aqua-active') + '" style="background: url(' + (value['cover'] != undefined ? value['cover']['source'] : null) + ') center;">\
										<h3 class="widget-user-username">' + value['name'] + '</h3>\
										<h5 class="widget-user-desc">' + value['id'] + '</h5>\
									</div>\
									<div class="widget-user-image">\
										<img class="img-circle" src="' + value['picture'] + '" alt="User Avatar">\
									</div>\
									<div class="box-footer">\
										<div class="row">\
											<div class="col-sm-4 border-right">\
												<div class="description-block">\
													<h5 class="description-header"><a href="https://fb.com/' + value['id'] + '" class="btn btn-primary" target="_blank"><i class="fa fa-link"></i></a></h5>\
													<span class="description-text">LINK</span>\
												</div>\
											</div>\
											<div class="col-sm-4 border-right">\
												<div class="description-block">\
													<h5 class="description-header">13,000</h5>\
													<span class="description-text">FOLLOWERS</span>\
												</div>\
											</div>\
											<div class="col-sm-4">\
												<div class="description-block">\
												<h5 class="description-header"><a href="/facebook/friends/' + {{ $user['provider_uid'] or '' }} + '/' + value['id'] + '" class="btn btn-danger"><i class="fa fa-user-times"></i></a></h5>\
												<span class="description-text">UNFRIEND</span>\
												</div>\
											</div>\
										</div>\
									</div>\
								</div>\
							</div>';
				});
				$('#friends').append(html);
			});
		});

		$('#unfriend_from_list').click(function() {
			$('form').submit();
		});

		$('#get_friends').click(function() {
			var uid = $('#socials').val();
			$(this).attr('href', '/facebook/friends/'+uid);
			$(this).addClass('disabled');
		});

		// gán vô cho bạn bè của (socials)
		var socials = $('#socials option').html();
		$('#social').html(socials);
	</script>
@endpush