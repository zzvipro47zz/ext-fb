@extends('master')
@section('page', 'Đăng status lên tường nhà')
@section('page-content')
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Đăng với tư cách:</span>
							<select name="users-poststt" id="users" class="form-control" size="5" multiple>
								@foreach($socials as $social)
									<option value="{{ $social['provider_uid'] }}" {{ old('users-poststt') ? 'selected' : null }}">{{ $social['name'] }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>

			@if(session('success') || session('error'))
				<div class="alert alert-{{ (session('success') ? 'success' : 'warning') }} alert-dismissable fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-{{ (session('success') ? 'check' : 'warning') }}"></i> Thông báo!</h4>
					{!! session('success') ? session('success') : session('error') !!}
				</div>
			@elseif(count($errors) > 0)
				<div class="alert alert-warning alert-dismissable fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-warning"></i> Thông báo!</h4>
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<div class="box box-default">
				<div class="box-header with-border">
					<h3 class="box-title">Auto Post Wall</h3>
				</div>
				<div class="box-body">
					<form action="" method="post" class="form-group" enctype="multipart/form-data" id="form_postwall">
						{{ csrf_field() }}

						<input type="hidden" name="uid" value="">
						<input type="hidden" name="post_at" value="">

						<textarea class="form-control" name="message" rows="7" placeholder="Nhập tin..."></textarea>

						<br />

						<input type="file" id="fileUpload" class="filestyle" name="images[]" multiple>

						<br />
						
						{{-- this is use for jquery upload imgs when user pick an images --}}
						<div id="imgHolder"></div>
					</form>
				</div>
				<div class="box-footer">
					<div class="pull-right">
						<button class="btn btn-info" id="post_stt">Đăng bài</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
	<script>
		$('#post_stt').click(function() {
			var uid = $('#users').val();
			var time = $('#datetimepicker').val();
			$('input[name=uid').attr('value', uid);
			$('input[name=post_at').attr('value', time);
			$('#form_postwall').submit();
		});

		$('.filestyle').filestyle({
			buttonName: 'btn-primary',
			placeholder: 'No file chosen',
			buttonBefore: true
		});

		// file upload
		$('#fileUpload').change(function() {
			var object = $(this)[0];
			var countFiles = object.files.length;
			var imgPath = object.value;
			var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
			var imgHolder = document.getElementById('imgHolder');
			$(imgHolder).empty();

			var accept = 'image/jpeg, image/png, image/jpg';
			var ext = ['jpeg', 'jpg', 'png'];
			if ($.inArray(extn, ext)) {
				if (typeof(FileReader) != undefined) {
					for (var i = 0; i < countFiles; i++) {
						var reader = new FileReader();
						reader.onload = function(e) {
							$('<div class="box box-default">\
								<div class="box-body">\
								<div class="text-center">\
								<img src="' + e.target.result + '" class="img-thumbnail img-responsive" width="50%" alt="picture" accept="' + accept + '" /></div>\
								</div><div class="box-footer">\
								<textarea name="caption[]" class="form-control" rows="5" placeholder="Nhập tin cho bức ảnh này..."></textarea>\
								</div></div>').appendTo(imgHolder);
						}
						$(imgHolder).show();
						reader.readAsDataURL(object.files[i]);
					}
				} else {
					alert('This browser doesn\'t support FileReader');
				}
			} else {
				alert('Please select only images !');
			}
		});
		// ./file upload
	</script>
@endpush
@push('lib-css')
	<link rel="stylesheet" href="{{ asset('libs/datetimepicker-master/jquery.datetimepicker.css') }}"/ >
@endpush
@push('lib-scripts')
	<script src="{{ asset('libs/datetimepicker-master/build/jquery.datetimepicker.full.min.js') }}"></script>
	<script src="{{ asset('libs/bootstrap-filestyle-1.2.1/bootstrap-filestyle.min.js') }}"></script>
@endpush