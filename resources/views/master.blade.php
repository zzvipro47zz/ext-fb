<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>fb</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/bootstrap/css/bootstrap.min.css') }}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/dist/css/AdminLTE.min.css') }}">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	   folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="{{ asset('libs/adminlte-2.3.11/dist/css/skins/_all-skins.min.css') }}">

	{{-- my css --}}
	<link href="{{ asset('css/send_sms.css') }}" rel="stylesheet">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<header class="main-header">
	<!-- Logo -->
	<a href="index2.html" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>A</b>LT</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>Admin</b>LTE</span>
	</a>

	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<!-- Navbar Right Menu -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
						<span class="hidden-xs">Alexander Pierce</span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
							<p>Alexander Pierce - Web Developer <small>Member since Nov. 2012</small></p>
						</li>
						<!-- Menu Body -->
						<li class="user-body">
							<div class="row">
								<div class="col-xs-4 text-center">
									<a href="#">Followers</a>
								</div>
								<div class="col-xs-4 text-center">
									<a href="#">Sales</a>
								</div>
								<div class="col-xs-4 text-center">
									<a href="#">Friends</a>
								</div>
							</div>
							<!-- /.row -->
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left">
								<a href="#" class="btn btn-default btn-flat">Profile</a>
							</div>
							<div class="pull-right">
								<a href="#" class="btn btn-default btn-flat">Sign out</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	</header>
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
					<li><a href="{{ url('facebook/wall') }}">Wall</a></li>
					<li><a href="{{ url('facebook/group') }}">Group</a></li>
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
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('libs/adminlte-2.3.11/dist/js/pages/dashboard2.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('libs/adminlte-2.3.11/dist/js/demo.js') }}"></script>

<!-- my js -->
<script src="{{ asset('js/ready.js') }}"></script>
{{-- <script src="{{ asset('js/myjs.js') }}"></script> --}}
</body>
</html>