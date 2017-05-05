<header class="main-header">
	<!-- Logo -->
	<a href="./" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>S</b>N</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>Social</b> Network</span>
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
				@if (Auth::user())
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class="hidden-xs">{{ Auth::user()->email }}</span>
						</a>
						<ul class="dropdown-menu">
							<!-- User image -->
							<li class="user-header">
								<p>{{ (Auth::user()->role == 1) ? 'Admin' : 'Member' }}</p>
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
									<a href="linktofb" target="_blank" class="btn btn-default btn-flat">Profile</a>
								</div>
								<div class="pull-right">
									<a href="/logout" class="btn btn-default btn-flat">Sign out</a>
								</div>
							</li>
						</ul>
					</li>
				@else
					<li><a href="/login"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng nhập vào hệ thống auto</a></li>
				@endif
			</ul>
		</div>
	</nav>
</header>