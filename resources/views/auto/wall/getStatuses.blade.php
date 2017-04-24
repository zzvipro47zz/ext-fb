@extends('auto.wall')
@section('wall')
	<div id="yourposts">
		<div class="panel panel-default">
			<div class="panel-heading">
				Lấy những bài đăng trên tường nhà bạn
			</div>
			<div class="panel-body">
				<form action="" class="form-group">
					<h4>You choose <span class="label label-success" id="friend_select">0</span> of <span class="label label-warning" id="all_post">0</span> post to delete</h4>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-post_wall">
						<thead>
							<tr>
								<th style="width:40px;"><input type="checkbox" id="check_all"></th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" name="post_wall[]" function="post_wall"></td>
								<td>BinPC</td>
								<td>
									<button class="form-control btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="post_wall[]" function="post_wall"></td>
								<td>nongnguyen</td>
								<td>
									<button class="form-control btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
								</td>
							</tr>
						</tbody>
					</table>
					<div class="pull-right">
						<button type="submit" class="btn btn-warning">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection