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
	<header class="main-header">
		<!-- Logo -->
		<a href="./" class="logo">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<span class="logo-mini"><b>A</b>FB</span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><b>Auto</b>FB</span>
		</a>

		<!-- Header Navbar: style can be found in header.less -->
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<!-- Navbar Right Menu -->
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<!-- User Account: style can be found in dropdown.less -->
					@if (Session::has('fb-sdk'))
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
								<span class="hidden-xs">{{ Session::get('fb-sdk')->user['name'] }}</span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
									<p>{{ Session::get('fb-sdk')->user['name'] }}</p>
								</li>
								<!-- Menu Body -->
								<li class="user-body">
									<div class="row">
										<div class="col-xs-4 text-center">
											<a href="#">Followers</a>
										</div>
										<div class="col-xs-4 text-center">
											<a href="#">Followers</a>
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
										<a href="{!! htmlspecialchars(Session::get('fb-sdk')->user['link']) !!}" class="btn btn-default btn-flat">Profile</a>
									</div>
									<div class="pull-right">
										<a href="/logout" class="btn btn-default btn-flat">Sign out</a>
									</div>
								</li>
							</ul>
						</li>
					@else
						<li><a href="{{ url('facebook/redirect') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng nhập vào facebook</a></li>
					@endif
				</ul>
			</div>
		</nav>
	</header>

	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- sidebar menu: : style can be found in sidebar.less -->
			<ul class="sidebar-menu">
				<li class="header">MAIN TOOLS</li>
				<li class="active treeview">
					<a href="{{ url('dashboard') }}">
						<i class="fa fa-dashboard"></i> <span>Dashboard</span>
					</a>
				</li>
				<li class="treeview">
					<a href="{{ url('facebook/friend') }}">
						<i class="fa fa-user-circle" aria-hidden="true"></i> <span>Friend</span>
					</a>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-files-o"></i>
						<span>Wall</span>
						<span class="pull-right-container">
						<span class="label label-primary pull-right">4</span>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="{{ url('facebook/wall') }}"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
						<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
						<li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
						<li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-users"></i>
						<span>Group</span>
						<span class="pull-right-container">
						<span class="label label-primary pull-right">4</span>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="{{ url('facebook/group') }}"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
						<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
						<li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
						<li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
					</ul>
				</li>
			</ul>
		</section>
		<!-- /.sidebar -->
	</aside>

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

	<!-- my js -->
	<script src="{{ asset('js/ready.js') }}"></script>
	{{-- <script src="{{ asset('js/myjs.js') }}"></script> --}}
</body>
</html>