@extends('auto.wall')
@section('wall')
	<div id="yourposts" class="row">
		<div class="box">
			<div class="box-header">
				Lấy những bài đăng trên tường nhà bạn
			</div>
			<div class="box-body">
				<form action="" class="form-group">
					<h4>You choose <span class="label label-success" id="count-checkbox-status">0</span> of <span class="label label-warning" id="all_post">0</span> post to delete</h4>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-get_status">
						<thead>
							<tr>
								<th style="width:40px;"><input type="checkbox" id="check_all"></th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" name="get_status[]" function="get_status"></td>
								<td>BinPC</td>
								<td>
									<button class="form-control btn btn-danger btn-circle"><i class="fa fa-times"></i></button>
								</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="get_status[]" function="get_status"></td>
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