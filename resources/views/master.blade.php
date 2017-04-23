<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title>fb</title>

	<!-- Bootstrap Core CSS -->
	<link href="{{ asset('libs/sb-admin2/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

	<!-- MetisMenu CSS -->
	<link href="{{ asset('libs/sb-admin2/vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

	<!-- DataTables CSS -->
	<link href="{{ asset('libs/sb-admin2/vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">

	<!-- DataTables Responsive CSS -->
	<link href="{{ asset('libs/sb-admin2/vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="{{ asset('libs/sb-admin2/dist/css/sb-admin-2.css') }}" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="{{ asset('libs/sb-admin2/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

	{{-- my css --}}
	<link href="{{ asset('css/send_sms.css') }}" rel="stylesheet">
</head>
<body>
<header>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="./">#Auto</a>
			</div>
	
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('facebook/friend') }}">Friends</a></li>
					<li><a href="{{ url('facebook/postwall') }}">Post Wall</a></li>
					<li><a href="{{ url('facebook/postgroup') }}">Post Group</a></li>
					<li><a href="https://fb.com/100011795260650" target="_blank">Contact</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if (Session::has('fb-sdk'))
						<li><a href="{!! htmlspecialchars(Session::get('fb-sdk')->user['link']) !!}">Xin chào: <b>{{ Session::get('fb-sdk')->user['name'] }}</b></a></li>
						<li><a href="/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a></li>
					@else
						<li><a href="{{ url('facebook/redirect') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng nhập vào facebook</a></li>
					@endif
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</div>
	</nav>
	<div class="container-fluid" style="margin-top: 70px">
		<div class="jumbotron">
			<h1>Extension for facebook</h1>
			<p>auto send sms, ...</p>
		</div>
	</div>
</header>


@yield('page-wrapper')


<!-- jQuery -->
<script src="{{ asset('libs/sb-admin2/vendor/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('libs/sb-admin2/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ asset('libs/sb-admin2/vendor/metisMenu/metisMenu.min.js') }}"></script>

<!-- DataTables JavaScript -->
<script src="{{ asset('libs/sb-admin2/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/sb-admin2/vendor/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('libs/sb-admin2/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ asset('libs/sb-admin2/dist/js/sb-admin-2.js') }}"></script>

<script src="{{ asset('libs/sb-admin2/vendor/bootstrap-filestyle-1.2.1/bootstrap-filestyle.min.js') }}"></script>

<!-- my js -->
<script src="{{ asset('js/ready.js') }}"></script>
{{-- <script src="{{ asset('js/myjs.js') }}"></script> --}}
</body>
</html>