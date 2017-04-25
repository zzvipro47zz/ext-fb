<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Facebook Tools</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/bootstrap/css/bootstrap.min.css') }}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/dist/css/AdminLTE.min.css') }}">
	<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/dist/css/skins/_all-skins.min.css') }}">

	{{-- my css --}}
	<link href="{{ asset('css/send_sms.css') }}" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini">
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





	<!-- jQuery 2.2.3 -->
	<script src="{{ asset('libs/adminlte-2.3.11/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="{{ asset('libs/adminlte-2.3.11/bootstrap/js/bootstrap.min.js') }}"></script>
	<!-- FastClick -->
	<script src="{{ asset('libs/adminlte-2.3.11/plugins/fastclick/fastclick.js') }}"></script>
	<!-- AdminLTE App -->
	<script src="{{ asset('libs/adminlte-2.3.11/dist/js/app.min.js') }}"></script>
	<!-- Sparkline -->
	<script src="{{ asset('libs/adminlte-2.3.11/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
	<!-- jvectormap -->
	<script src="{{ asset('libs/adminlte-2.3.11/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
	<script src="{{ asset('libs/adminlte-2.3.11/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<!-- SlimScroll 1.3.0 -->
	<script src="{{ asset('libs/adminlte-2.3.11/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
	<!-- ChartJS 1.0.1 -->
	<script src="{{ asset('libs/adminlte-2.3.11/plugins/chartjs/Chart.min.js') }}"></script>

	<!-- my js -->
	<script src="{{ asset('js/ready.js') }}"></script>
	{{-- <script src="{{ asset('js/myjs.js') }}"></script> --}}
</body>
</html>