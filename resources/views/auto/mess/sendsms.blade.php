<div id="send_sms" class="tab-pane fade in active">
	<div class="panel panel-default">
		<div class="panel-heading">
			Auto send messages to everyone
		</div>
		<div class="panel-body">
			<form action="" class="form-group" enctype="multipart/form-data">
				<textarea class="form-control" name="messages" rows="7" placeholder="Nhập tin nhắn cần gửi..."></textarea>

				<br />

				<input type="file" name="files" class="filestyle" data-buttonBefore="true"  data-placeholder="No file has chosen" data-buttonName="btn-primary" multiple>

				<br />

				<h4>You choose <span class="label label-success" id="friend_select">0</span> of <span class="label label-warning" id="all_friends">0</span> friends to send messages</h4>
				<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-send_sms">
					<thead>
						<tr>
							<th style="width:40px;"><input type="checkbox" id="check_all"></th>
							<th>Name</th>
							<th>Image</th>
							<th>Link</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="checkbox" name="send_sms[]" function="send_sms"></td>
							<td>BinPC</td>
							<td><img src="{{ asset('images/a.jpg') }}" alt="Image" class="image"></td>
							<td><a href="#" class="btn btn-primary">Link to Facebook</a></td>
						</tr>
						<tr>
							<td><input type="checkbox" name="send_sms[]" function="send_sms"></td>
							<td>nongnguyen</td>
							<td><img src="{{ asset('images/a.jpg') }}" alt="Image" class="image"></td>
							<td><a href="#" class="btn btn-primary">Link to Facebook</a></td>
						</tr>
					</tbody>
				</table>
				<div class="pull-right">
					<button type="submit" class="btn btn-info btn-lg">Gửi</button>
				</div>
			</form>
		</div>
	</div>
</div>