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
							<select name="users-poststt" id="users" class="form-control">
								@foreach($users as $u)
									<option value="{{ $u['provider_uid'] }}" selected="{{ old('users-poststt') }}">{{ $u['name'] }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Đăng lúc:</span>
							<input type="text" id="datetimepicker" class="form-control">
						</div>
					</div>
				</div>
			</div>

			@if(session('error'))
				<div class="alert alert-warning alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Warning!!!</strong> {{ session('error') }}
				</div>
			@elseif (session('success'))
				<div class="alert alert-warning alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Đăng bài viết thành công!!!</strong> {!! session('success') !!}
				</div>
			@endif
			<div class="box box-default">
				<div class="box-header">
					<h3 class="box-title">Auto Post Wall</h3>
				</div>
				<div class="box-body">
					<form action="" method="post" class="form-group" enctype="multipart/form-data" id="form_postwall">
						{{ csrf_field() }}
						<textarea class="form-control" name="behind" rows="7" placeholder="Nhập tin nhắn cần chèn vào phía sau..."></textarea>

						<br />

						<input type="file" id="fileUpload" class="filestyle" name="image[]" multiple>

						<br />
						
						{{-- this is use for jquery upload imgs when user pick an images --}}
						<div id="imgHolder"></div>

						<div class="pull-right">
							<button type="submit" class="btn btn-info">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
	<script>
		$('#datetimepicker').datetimepicker({
			format:'d.m.Y H:i',
			lang: 'vi'
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
								<img src="' + e.target.result + '" class="img-thumbnail img-responsive imgToUpload" width="50%" alt="picture" accept="' + accept + '" /></div>\
								</div><div class="box-footer">\
								<textarea name="message[]" class="form-control" rows="5" placeholder="Nhập tin cho bức ảnh này"></textarea>\
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
@push('libs-css')
	<link rel="stylesheet" href="{{ asset('libs/datetimepicker-master/jquery.datetimepicker.css') }}"/ >
@endpush
@push('libs-scripts')
	<script src="{{ asset('libs/datetimepicker-master/build/jquery.datetimepicker.full.min.js') }}"></script>
	<script src="{{ asset('libs/bootstrap-filestyle-1.2.1/bootstrap-filestyle.min.js') }}"></script>
@endpush