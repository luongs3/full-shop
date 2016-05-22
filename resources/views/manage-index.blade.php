@extends("layout.layout")
@section("content")
	<section id="index_manage">
		<div class="container">
			<div class="row">
				@include("layout.left-sidebar-admin")
				<div class="col-sm-10">
					<div class="row">
						@include('layout.result')
						<form  class="form-horizontal" enctype="multipart/form-data" action="{{URL::route('manage.save')}}" method="POST" role="form" >
							<div class="page-header">
								<h2>{{trans('label.home_page')}}</h2>
								<button type="submit" class="btn btn-default btn-lg btn_header">{{trans('label.save')}}</button>
								<button type="button" class="btn btn-default btn-lg btn_header" id="btn_add">{{trans('label.add_new_banner')}}</button>
								<button type="button" class="btn btn-default btn-lg btn_header" id="btn-back">{{trans('label.back')}}</button>

							</div>

							<ul class="nav nav-tabs">
								<li class="active"><a data-toggle="tab" href="#banner">{{trans('label.banner')}}</a></li>
								<li><a data-toggle="tab" href="#advertisement">{{trans('label.advertisement')}}</a></li>
							</ul>

							<div class="tab-content">
								<div id="banner" class="tab-pane fade in active">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="row">
										@if(isset($images))
											@foreach($images as $key => $val)
												<div class="col-sm-8">
													<div class="form-group banner">
														<label class="control-label" for="{{'id_'.$val["id"]}}">{{$val["name"]}}</label>
														<input class="form-control" id="{{'hidden_' .$val["id"]}}" type="hidden" name='{{"hidden_" . $key}}' value="{{$val["id"]}}">
														<input class="form-control" id="{{'id_'.$val["id"]}}" type="file"  name="{{$key}}" >
														<img class="img img-responsive image_url" id='{{"url_".$val["id"]}}' src="{{url($val['url'])}}">
													</div>
												</div>
												<div class="col-sm-4">
													<button type="button" class="btn btn-default btn-delete" id="{{'delete_'.$val['id']}}" value="{{$val['id']}}">{{trans('label.delete')}}</button>
												</div>

											@endforeach

										@endif
									</div>
									<div class="col-sm-8">
										<div class="form-group">
											<div class="col-sm-9">
												<button type="submit" class="btn btn-default btn-lg">{{trans('label.save')}}</button>
											</div>
										</div>
									</div>
								</div>
								<div id="advertisement" class="tab-pane fade">
									<div class="row">
										<div class="col-sm-8">
											<div class="form-group">
												<label class="control-label" for="id_advert">{{$ad["name"] or trans('label.advertisement')}}</label>
												<input class="form-control" id="hidden_advert" type="hidden" name='hidden_advert' value="{{$ad["id"] or ''}}">
												<input class="form-control" id="id_advert" type="file"  name="advertisement" >
												<img class="img img-responsive image_url" id='url_advert' src="{{url($ad['url'])}}">
											</div>
										</div>
										@if(isset($ad))
											<div class="col-sm-4">
												<button type="button" class="btn btn-default btn-delete" id="{{'delete_advert'}}" value="{{$ad['id']}}">{{trans('label.delete')}}</button>
											</div>
										@endif
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
			var formGroup = '<div class="form-group banner">'+
					'<label class="control-label" for="">New Banner</label>'+
					'<input class="form-control" id="" type="hidden" name="" value="">'+
					'<input class="form-control" id="" type="file"  name="" >'+
					'<img class="img img-responsive image_url" id="" src="{{asset('/images/home/girl2.jpg')}}">'+
					'</div>';
			$('#btn_add').click(function(){
				$('div.col-sm-8').prepend(formGroup);
				var no = $('.banner').length;
				var last_fromGroup = $('.banner').first();
				last_fromGroup.find('input[type="hidden"]').attr('name','hidden_'+no);
				last_fromGroup.find('input[type="file"]').attr('name',+no).attr('id','id_'+no);
				return false;
			});
			$('.btn-delete').click(function(){
				$.ajax({
							type: 'post',
							url: "/manage/delete-banner",
							data: {id: $(this).attr('value'),
								_token: "{{ csrf_token() }}"},
							success: function(){
								location.reload(true)
							}
						}
				);
			})
		});
		function readURL(input) {
			if (input.files) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#'+input.id).next().attr('src', e.target.result);
				};
				reader.readAsDataURL(input.files[0]);
			}
		}
		$("div.tab-content").on('change',"input[type='file']",function(){
			readURL(this);
		});
		$("#btn-back").click(function(){
			window.history.back();
		})
	</script>
@endsection
