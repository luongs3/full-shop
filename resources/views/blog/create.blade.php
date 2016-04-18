@extends("layout.layout")
@section("content")
	<section id="edit_section">
		<div class="container">
			<div class="row">
				@include('layout.left-sidebar-admin')
				<div class="col-sm-10">
					<div class="row">
						@include('layout.result')
						<form  class="form-horizontal" enctype="multipart/form-data" action="{{URL::route('blog.save')}}" method="POST" role="form" >
							<h3 class="page-header">{{trans('label.add_new_post')}}</h3>
							<button type="submit" class="btn btn-default btn-lg btn_header">{{trans('label.save')}}</button>
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="col-sm-10">
								<div class="form-group">
									<label class="control-label col-sm-2" for="name">{{trans('label.name')}}<span class="required"> *</span></label>
									<div class="col-sm-9">
										<input class="form-control" id="title" type="text" name="title" required placeholder="{{trans('general.forget_steve_jobs')}}" value="{{old('title')}}">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="active">{{trans('label.active')}}</label>
									<div class="col-sm-9">
										@if(old('active')===0)
											<input class="form-control" type="checkbox" id="active" name="active">
										@else
											<input class="form-control" type="checkbox" id="active" name="active" checked>
										@endif
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="subcontent">{{trans('label.subcontent')}}<span class="required"> *</span></label>
									<div class="col-sm-9">
										<textarea class="form-control summernote" id="subcontent" rows="5" required  name="subcontent" placeholder="Type the sub-content of post in here">{{old('subcontent')}}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-2" for="content">{{trans('label.content')}}<span class="required"> *</span></label>
									<div class="col-sm-9">
										<textarea class="form-control summernote" id="content" rows="5" name="content" required placeholder="Type the content of post in here">{{old('content')}}</textarea>
									</div>
								</div>
								<div class="form-group" id="image-preview">
									<label class="control-label col-sm-2" id="image-label" for="image">{{trans('label.image')}}<span class="required"> *</span></label>
									<div class="col-sm-9">
										<input class="hidden" id="image_hidden" name="image_hidden" value="">
										<input class="form-control" id="image-upload" type="file"  name="image" value="{{old('image_id')}}">
										<img class="img img-responsive" id="image_url" src="{{old('image_url')}}">
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-9">
										<button type="submit" class="btn btn-default btn-lg btn-save">{{trans('label.save')}}</button>
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
			$('.summernote').summernote({
				height: 200                 // set editor height
			});
			function readURL(input) {

				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#image_url').attr('src', e.target.result);
					};

					reader.readAsDataURL(input.files[0]);
				}
			}

			$("#image-upload").change(function(){
				readURL(this);
			});
		});
	</script>
@endsection
