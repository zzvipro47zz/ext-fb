@extends('master')
@section('page', 'Lọc Friend')
@section('page-content')
	<div class="row">
		<div class="col-md-5 col-sm-12 col-xs-12">
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">Select User:</span>
					<select id="socials" class="form-control" name="friends">
						@foreach($socials as $social)
							<option value="{{ $social['provider_uid'] }}">{{ $social['name'] }}</option>
						@endforeach
					</select>
					<div class="input-group-btn">
						<button class="btn btn-info" id="get_friends">GET</button>
					</div>
				</div>
			</div>
		</div>

		@if(isset($friends_data))
			<div class="col-md-7 col-sm-12 col-xs-12">
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="form-group">
							<button id="unfriend_from_list" class="btn btn-primary btn-block">Check to Unfriend</button>
						</div>
					</div>

					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="form-group">
							<button id="load_all_friend" class="btn btn-primary btn-block">Load ALL</button>
						</div>
					</div>

					<div class="clearfix visible-sm-block"></div>

					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="form-group">
							<button id="check_all" class="btn btn-warning btn-block">Check ALL</button>
						</div>
					</div>

					<div class="col-md-3 col-sm-6 col-xs-12">
						<div class="form-group">
							<button id="uncheck_all" class="btn btn-success btn-block">UnCheck ALL</button>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>
	
	@if(session('error') || session('success'))
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

	@if(isset($friends_data))
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Bạn bè của <label class="control-label" for="user">{{ $user['name'] }}</label></h3>
						<div class="pull-right box-tool">
							<span class="badge bg-orange">{{ $summary }}</span>
						</div>
					</div>
					<div class="box-body" id="friends">
						@foreach($friends_data as $value)
							<div class="col-md-4 col-sm-12 col-xs-12">
								<div class="box box-widget widget-user">
									@if(isset($value['cover']))
										<div class="widget-user-header bg-black img" style="background: url('{{ $value['cover']['source'] }}') center;">
									@else
										<div class="widget-user-header bg-aqua-active">
									@endif
										<h3 class="widget-user-username"><b>{{ $value['name'] }}</b></h3>
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
													<span class="description-text">LINK TO FACEBOOK</span>
												</div>
											</div>
											<div class="col-sm-4 border-right">
												<div class="description-block">
													<h5 class="description-header">
														<div class="form-group">
															<label>
																<input type="checkbox" class="minimal-red" name="list_friend[]" value="{{ $value['id'] }}">
															</label>
														</div>
													</h5>
													<span class="description-text">CHECK TO UNFRIEND</span>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="description-block">
												<h5 class="description-header">
													<a href="{{ "/facebook/friends/$user[provider_uid]/unf/$value[id]" }}" class="btn btn-danger"><i class="fa fa-user-times"></i></a>
												</h5>
												<span class="description-text">UNFRIEND</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach
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
		var user = '{{ $user['provider_uid'] or null }}';

		$('#load_more_friends').on('click', function() {
			let lmf = $(this);
			lmf.addClass('disabled');
			let url = '{{ route('fb.lmf', @$user['provider_uid']) }}';

			$.ajax({
				url: url,
				method: 'post',
				success: function(data) {
					if (data === 'okay') {
						$('#load_more_friends').remove();
					} else if (data === 'notokay') {
						alert('Sai yêu cầu');
						location.reload();
					} else {
						var html = '';
						data.map((value) => {
							var bg = '';
							if (value.cover != undefined) {
								bg = '<div class="widget-user-header bg-black" style="background: url(' + value.cover.source + ') center;">';
							} else {
								bg = '<div class="widget-user-header bg-aqua-active">';
							}
							html += '<div class="col-md-4 col-sm-12 col-xs-12">\
										<div class="box box-widget widget-user">' + bg + '\
												<h3 class="widget-user-username"><b>' + value.name + '</b></h3>\
												<h5 class="widget-user-desc">' + value.id + '</h5>\
											</div>\
											<div class="widget-user-image">\
												<img class="img-circle" src="' + value.picture + '" alt="' + value.name + ' Avatar">\
											</div>\
											<div class="box-footer">\
												<div class="row">\
													<div class="col-sm-4 border-right">\
														<div class="description-block">\
															<h5 class="description-header"><a href="https://fb.com/' + value.id + '" class="btn btn-primary" target="_blank"><i class="fa fa-link"></i></a></h5>\
															<span class="description-text">LINK TO FACEBOOK</span>\
														</div>\
													</div>\
													<div class="col-sm-4 border-right">\
														<div class="description-block">\
															<h5 class="description-header">\
																<div class="form-group">\
																	<label>\
																		<input type="checkbox" class="minimal-red" name="list_friend[]" value="' + value.id + '">\
																	</label>\
																</div>\
															</h5>\
															<span class="description-text">CHECK TO UNFRIEND</span>\
														</div>\
													</div>\
													<div class="col-sm-4">\
														<div class="description-block">\
														<h5 class="description-header"><a href="/facebook/' + user + '/unf/' + value.id + '" class="btn btn-danger"><i class="fa fa-user-times"></i></a></h5>\
														<span class="description-text">UNFRIEND</span>\
														</div>\
													</div>\
												</div>\
											</div>\
										</div>\
									</div>';
						});
						$('#friends').append(html);

						$('input[type="checkbox"].minimal-red').iCheck({
							checkboxClass: 'icheckbox_minimal-red icheckbox_square-red',
							increaseArea: '20%'
						});
					}
				}
			}).done(function() {
				lmf.removeClass('disabled');
			});
		});

		var ignoreScroll = false;
		$(window).scroll(function() {
			if (ignoreScroll) return;
			if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
				$('#load_more_friends').click();
				ignoreScroll = true;
				setTimeout(function() {
					ignoreScroll = false;
				}, 2500);
			}
		});

		$('#unfriend_from_list').click(function() {
			let friends_checked = $('input[name="list_friend[]"]:checked');
			if (friends_checked.length == 0) {
				alert('Bạn chưa chọn người nào để unfriend -_-');
				return false;
			}
			$('#friends').after('<div class="overlay"><i class="fa fa-spinner fa-pulse fa-fw"></i></div>');
			let url = '{{ isset($user['provider_uid']) ? route('fb.ufl', $user['provider_uid']) : null }}';
			let promise = new Promise((resolve, reject) => {
				friends_checked.map(function() {
					// get những người đã check và ajax để unfriend
					$.post(url, {id: this.value}, (data) => {
						if (data !== 'okay') {
							alert('Lỗi không xác định :( vui lòng liên hệ QTV để fix lỗi. Xin lỗi vì sự bất tiện này.');
							location.reload();
						} else if (data === 'okay') {
							resolve('Hủy kết bạn thành công !');
						}
					});
				});
			});
			promise.then(status => {
				alert(status);
				location.reload();
			});
		});

		document.getElementById('get_friends').onclick = function() {
			$(this).addClass('disabled');
			var uid = document.getElementById('socials').value;
			location.pathname = '/facebook/friends/' + uid;
		};

		document.getElementById('load_all_friend').onclick = function() {
			alert('Bình tĩnh và đợi vài giây(s) để hệ thống load hết bạn nhé :)), đối với những bạn có nhiều friend hơn thì đợi hơi lâu :v');
			let setint = setInterval(function() {
				let lmf = document.getElementById('load_more_friends');
				if (lmf) {
					lmf.click();
				} else {
					clearInterval(setint);
				}
			}, 1e3);
		};

		(function() {
			let checkboxes = document.getElementsByName('list_friend[]');
			let check_all = document.getElementById('check_all');
			let uncheck_all = document.getElementById('uncheck_all');

			check_all.onclick = function() {
				if (confirm('Hãy cẩn thận nhé :)') == false) {
					alert('Chắc là ấn nhầm thôi mà :)))');
					return false;
				}
				Object.keys(checkboxes).map((k) => {
					let v = checkboxes[k];
					let checked = $(v).parent().hasClass('checked');
					if (!checked) {
						$(v).iCheck('check');
					}
				});
			};

			uncheck_all.onclick = function() {
				Object.keys(checkboxes).map((k) => {
					let v = checkboxes[k];
					let checked = $(v).parent().hasClass('checked');
					if (checked) {
						$(v).iCheck('uncheck');
					}
				});
			};
		})();

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