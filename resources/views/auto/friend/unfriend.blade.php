@extends('master')
@section('page', 'Unfriend')
@section('page-content')
	<div class="row">
		<!-- Info boxes -->
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Auto Unfriend</h3>
				</div>
				<div class="box-body">
					<form action="unfriend" class="form-group" method="post">
						<h4>You choose <span class="label label-success" id="count-checkbox-unfriend">0</span> of <span id="all" class="label label-warning">{{ $total_count }}</span> friends to Unfriend</h4><br />
						<table class="table table-striped table-bordered table-hover" id="dataTables-unfriend">
							<thead>
								<tr>
									<th style="width:30px;"><input type="checkbox" id="check_all"></th>
									<th>Name</th>
									{{-- <th>Image</th> --}}
									<th>Link</th>
								</tr>
							</thead>
							<tbody>
								@foreach($friends as $friend)
									<tr>
										<td><input type="checkbox" name="unfriend[]"></td>
										<td>{{ $friend->name }}</td>
										{{-- <td><img src="{{ asset('images/a.jpg') }}" alt="Image" class="image"></td> tạm thời chưa có hình--}}
										<td><a href="https://fb.com/{{ $friend->id }}" target="_blank" class="btn btn-primary">Link to Facebook</a></td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<div class="pull-right">
							<button type="submit" class="btn btn-info btn-lg">Gửi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		checkbox('unfriend');
	</script>
@endpush