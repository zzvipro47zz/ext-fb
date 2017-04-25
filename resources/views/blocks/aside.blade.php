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
				<ul class="treeview-menu">
					<li><a href="{{ url('facebook/unfriend') }}"><i class="fa fa-user-times"></i> UnFriend</a></li>
					<li><a href="{{ url('facebook/addfriend') }}"><i class="fa fa-user-plus"></i> Add Friend</a></li>
				</ul>
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
					<li><a href="{{ url('facebook/wall') }}"><i class="fa fa-circle-o"></i> Un Friend</a></li>
					<li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Add Friend</a></li>
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