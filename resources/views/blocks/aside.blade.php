<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
			<li class="header">MAIN TOOLS</li>
			<li class="active treeview">
				<a href="/">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<li class="treeview">
				<a href="{{ route('fb.getfriends') }}">
					<i class="fa fa-user-circle" aria-hidden="true"></i> <span>Friends</span>
				</a>
			</li>

			<li class="treeview">
				<a href="{{ route('fb.getfriends') }}">
					<i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Messenger</span>
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
					<li><a href="{{ route('fb.stt.getstt') }}"><i class="fa fa-circle-o"></i> Những bài viết bạn đã đăng</a></li>
					<li><a href="{{ route('fb.stt.poststt') }}"><i class="fa fa-circle-o"></i> Đăng bài lên tường nhà</a></li>
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
					<li><a href="{{ url('facebook/postgroup') }}"><i class="fa fa-file-text"></i> Đăng bài lên nhiều group</a></li>
					<li><a href="{{ url('facebook/groupjoin') }}"><i class="fa fa-circle-o"></i> Nhóm đã tham gia</a></li>
				</ul>
			</li>

			<li class="treeview">
				<a href="{{ route('fb.viewnuoiclone') }}">
					<i class="fa fa-plus"></i>
					<span>Nuôi Clone</span>
				</a>
			</li>

			<li class="treeview">
				<a href="{{ route('fb.viewhacklike') }}">
					<i class="fa fa-thumbs-up"></i>
					<span>Hack like</span>
				</a>
			</li>

			<li class="treeview">
				<a href="{{ route('fb.viewhacksub') }}">
					<i class="fa fa-plus"></i>
					<span>Hack sub</span>
				</a>
			</li>

			<li class="treeview">
				<a href="{{ route('fb.viewcheckproxy') }}">
					<i class="fa fa-plus"></i>
					<span>Check Proxy</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>