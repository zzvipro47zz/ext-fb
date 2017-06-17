<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Social Tools</title>
	
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/bootstrap/css/bootstrap.min.css') }}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('libs/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/dist/css/AdminLTE.min.css') }}">
	<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/dist/css/skins/_all-skins.min.css') }}">
	
	@stack('lib-css')

	{{-- my css --}}
	<link rel="stylesheet" href="{{ asset('css/scrolltop.css') }}">
	<link rel="stylesheet" href="{{ asset('css/send_sms.css') }}">
	
	<!-- Scripts -->
	<script>
		window.Laravel = {!! json_encode([
			'csrfToken' => csrf_token(),
		]) !!};
	</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		@include('blocks.header')

		@include('blocks.aside')

		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>@yield('page')</h1>
			</section>

			<!-- Main content -->
			<section class="content">
				@yield('page-content')
			</section>
			<!-- /.content -->
		</div>

		<a href="#" id="scroll_to_top" class="btn btn-default btn-circle"></a>

		@include('blocks.footer')
	</div>


	<!-- jQuery 2.2.3 -->
	<script src="{{ asset('libs/adminlte-2.3.11/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="{{ asset('libs/adminlte-2.3.11/bootstrap/js/bootstrap.min.js') }}"></script>
	{{-- libs --}}
	@stack('lib-scripts')
	<!-- AdminLTE App -->
	<script src="{{ asset('libs/adminlte-2.3.11/dist/js/app.min.js') }}"></script>

	<!-- my js -->
	<script src="{{ asset('js/functions.js') }}"></script>
	<script src="{{ asset('js/checkbox.js') }}"></script>
	<script src="{{ asset('js/ready.js') }}"></script>

	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			}
		});
	</script>

	@stack('scripts')
</body>
</html>