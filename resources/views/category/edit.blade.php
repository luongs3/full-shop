@extends("layout.layout")
@section("content")
	<section id="edit_section">
		<div class="container">
			<div class="row">
				@include('layout.left-sidebar-admin')
				@include('layout.left-sidebar')
				<div class="shopper-informations col-sm-7">
						<div class="row">
							<h2 class="page-header">{{trans('label.edit_category')}}</h2>
							@include('layout.result')
							<form  class="form-horizontal" enctype="multipart/form-data" action="{{URL::route('categories.save',['id' => $category['id']])}}" method="POST" role="form" >
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="id" value="{{$category['id'] or ''}}">
								<div class="col-sm-8">
									<div class="form-group">
										<label class="control-label col-sm-2" for="name">{{trans('label.name')}}</label>
										<div class="col-sm-9">
											<input class="form-control" id="name" type="text" name="name" placeholder="Nike" value="{{$category['name']}}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="description">{{trans('label.description')}}</label>
										<div class="col-sm-9">
											<textarea class="form-control" id="description" rows="5" name="description" placeholder="Nhãn hiệu giầy thể thao nổi tiếng trên thế giới">{{$category['description'] or ''}}</textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="parent_id">{{trans('label.parent_category')}}</label>
										<div class="col-sm-9">
											<select class="form-control" id="parent_id" name="parent_id">
												<option value="">--- {{trans('label.choose_category')}} ---</option>
												@if(isset($categories))
													@foreach($categories as $val)
														<option value="{{$val['id']}}" @if($val['id']==$category['parent_id']) selected @endif>{{$val['name']}}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
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
@endsection
