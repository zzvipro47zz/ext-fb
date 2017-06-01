@extends('master')
@section('page', 'Check Proxy')
@section('page-content')
	<div id="checkproxy" class="row">
		<div class="col-md-6">
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">Auto Check Proxy</h3>
				</div>
				<div class="box-body">
					<form action="#" method="post" class="form-horizontal">
					{{ csrf_field() }}
						<div class="form-group">
							<label for="soluong" class="col-sm-2 control-label">Số lượng</label>
							<div class="col-sm-10">
								<textarea type="text" id="sl" class="form-control" name="list_proxy" rows="7" placeholder="Lưu ý! mỗi proxy phải xuống dòng..."></textarea>
							</div>
						</div>
					</form>
				</div>
				<div class="box-footer">
					<div class="pull-right">
						<button id="start" class="btn btn-primary">Bắt đầu Check</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@push('scripts')
	<script>
		/*$(window).bind('beforeunload',function(){
			$(document).ajaxStop();
		});*/
		window.onbeforeunload = function() {
			$(document).ajaxStop();
		}
		$('#checkproxy #start').click(function(e) {
			e.preventDefault();
			var list_proxy = $('[name=list_proxy]').val();
			var url = '{{ route('fb.checkproxy') }}';
			var randomStr = random('number', 3) + '-' + random('string', 5) + '.txt';
			var url_file = '{{ addslashes(public_path('proxy')) . '/proxy-' }}' + randomStr; // public/proxy
			list_proxy = list_proxy.split("\n");

			$.each(list_proxy, function(key, proxy) {
				$.ajax({
					url: url,
					dataType: 'json',
					method: 'post',
					data: {
						proxy: proxy,
						url_file: url_file
					},
					cache: false,
					success:function(data) {
						console.log(data);
						console.log(key);
						console.log(list_proxy.length-1);
						if (key == list_proxy.length-1) {
							alert('Scan proxy success');
						}
					}
				});
			});
		});
	</script>
@endpush