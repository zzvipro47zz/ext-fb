@extends('auto.wall')
@section('wall')
	<div id="postwall">
		@if(Session::has('Fail'))
			<div class="alert alert-warning alert-dismissable fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Warning!!!</strong> {{ Session::get('Fail') }}
			</div>
		@elseif (Session::has('Success'))
			<div class="alert alert-warning alert-dismissable fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Đăng bài viết thành công!!!</strong> {!! Session::get('Success') !!}
			</div>
		@endif
		<div class="panel panel-default">
			<div class="panel-heading">
				Auto Post Wall
			</div>
			<div class="panel-body">
				<form action="" method="post" class="form-group" enctype="multipart/form-data" id="form_postwall">
				{{ csrf_field() }}
					<textarea class="form-control" name="behind" rows="7" placeholder="Nhập tin nhắn cần chèn vào phía sau..."></textarea>

					<br />

					<input type="file" name="image[]" class="filestyle" data-buttonBefore="true"  data-placeholder="No file has chosen" data-buttonName="btn-primary" id="fileUpload" multiple>

					<br />
					
					{{-- this is use for jquery upload imgs when user pick an images --}}
					<div id="imgHolder"></div>

					<!-- <h4>You choose <span class="label label-success" id="friend_select">0</span> of <span class="label label-warning" id="all_friends">0</span> friends to send messages</h4>
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-post_wall">
						<thead>
							<tr>
								<th style="width:40px;"><input type="checkbox" id="check_all"></th>
								<th>Name</th>
								<th>User ID</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox" name="post_wall[]" function="post_wall"></td>
								<td>BinPC</td>
								<td>User ID</td>
							</tr>
							<tr>
								<td><input type="checkbox" name="post_wall[]" function="post_wall"></td>
								<td>nongnguyen</td>
								<td>User ID</td>
							</tr>
						</tbody>
					</table> -->
					<div class="pull-right">
						<button type="submit" class="btn btn-info">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection