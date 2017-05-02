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
				@if (Session::has('info_user_fb'))
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="" class="user-image" alt="User Image">
							<span class="hidden-xs">{{ Session::get('info_user_fb')->name }}</span>
						</a>
						<ul class="dropdown-menu">
							<!-- User image -->
							<li class="user-header">
								<img src="" class="img-circle" alt="User Image">
								<p>{{ Session::get('info_user_fb')->email }}</p>
								<small>{{ Session::get('info_user_fb')->id }}</small>
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
									<a href="{{ Session::get('info_user_fb')->link }}" target="_blank" class="btn btn-default btn-flat">Profile</a>
								</div>
								<div class="pull-right">
									<a href="/logout" class="btn btn-default btn-flat">Sign out</a>
								</div>
							</li>
						</ul>
					</li>
				@else
					<li><a href="./"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng nhập vào facebook</a></li>
				@endif
			</ul>
		</div>
	</nav>
</header>