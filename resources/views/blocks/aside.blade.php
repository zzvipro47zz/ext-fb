<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="header">MAIN TOOLS</li>
			<li class="active treeview">
				<a href="./">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<li class="treeview">
				<a href="{{ route('fb.friends') }}">
					<i class="fa fa-user-circle" aria-hidden="true"></i> <span>Friends</span>
				</a>
			</li>

			<li class="treeview">
				<a href="#">
					<i class="fa fa-files-o"></i>
					<span>Wall</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ url('facebook/wall') }}"><i class="fa fa-circle-o"></i> Đăng stt</a></li>
				</ul>
			</li>

			<li class="treeview">
				<a href="#">
					<i class="fa fa-users"></i>
					<span>Group</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ url('facebook/postgroup') }}"><i class="fa fa-file-text"></i> Đăng bài lên group</a></li>
					<li><a href="{{ url('facebook/groupjoin') }}"><i class="fa fa-circle-o"></i> Nhóm đã tham gia</a></li>
				</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>