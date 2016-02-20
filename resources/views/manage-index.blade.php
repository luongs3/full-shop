@extends("layout.layout")
@section("content")
	<section id="index_manage">
		<div class="container">
			<div class="row">
				@include("layout.left-sidebar-admin")
				<div class="col-sm-10">
					<div class="row">
						@include('layout.result')
						<form  class="form-horizontal" enctype="multipart/form-data" action="{{URL::route('index.save')}}" method="POST" role="form" >
							<h3 class="page-header">{{trans('label.add_new_banner')}}</h3>
							<button type="submit" class="btn btn-default btn-lg btn_header">{{trans('label.save')}}</button>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="col-sm-8">
								@foreach($images as $key => $val)
									<div class="form-group">
										<label class="control-label" for="{{$key or ""}}">{{$val["name"] or ""}}</label>
										<input class="form-control" id="{{$val["id"] or ""}}" type="hidden" name='{{"hidden_" . $key}}' value="{{$val["id"] or ""}}">
										<input class="form-control" id="{{$key or ""}}" type="file"  name="{{$key}}" >
										<img class="img img-responsive image_url" id='{{"url_".$val["id"]}}' src="{{$val["url"] or ""}}">
									</div>
								@endforeach
									<div class="form-group">
										<div class="col-sm-9">
											<button type="submit" class="btn btn-default btn-lg">{{trans('label.save')}}</button>
										</div>
									</div>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</section>
	<script type="text/javascript">
		$(document).ready(function() {
			if($('.form-group').length<4){
				var formGroup = '<div class="form-group">'+
						'<label class="control-label" for="2">Image_3</label>'+
						'<input class="form-control" id="" type="hidden" name="hidden_2" value="">'+
						'<input class="form-control" id="2" type="file"  name="2" >'+
						'<img class="img img-responsive image_url" id="url_2" src="">'+
						'</div>';
				$('div.col-sm-8').append(formGroup);
			}
			function readURL(input) {
				if (input.files) {
					var reader = new FileReader();
					reader.onload = function (e) {
						$('#url_'+input.id).attr('src', e.target.result);
					};
					reader.readAsDataURL(input.files[0]);

				}
			}
			$("input[type='file']").change(function(){
				readURL(this);
			});
		});
	</script>
@endsection
