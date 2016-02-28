@extends("layout.layout")
@section("content")
	<section id="edit_section">
		<div class="container">
			<div class="row">
				@include('layout.left-sidebar-admin')
					<div class="shopper-informations col-sm-10">
						<div class="row">
							<h2 class="page-header">{{trans('label.edit_product')}}</h2>
							@include('layout.result')
							<form  class="form-horizontal" enctype="multipart/form-data" action="{{URL::route('products.save') . '/'.$product['id']}}" method="POST" role="form" >
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="id" value="{{$product['id'] or ''}}">
								<div class="col-sm-8">
									<div class="form-group">
										<label class="control-label col-sm-2" for="name">{{trans('label.name')}}</label>
										<div class="col-sm-9">
											<input class="form-control" id="name" type="text" name="name" placeholder="Áo dài" value="{{$product['name'] or ''}}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="sku">{{trans('label.sku')}}</label>
										<div class="col-sm-9">
											<input class="form-control" id="sku" type="text" name="sku" placeholder="ao-dai-nhap-khau" value="{{$product['sku'] or ''}}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="price">{{trans('label.price')}}</label>
										<div class="col-sm-9">
											<input class="form-control" id="price" type="number" name="price" placeholder="100000"  value="{{$product['price'] or ''}}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="status">{{trans('label.status')}}</label>
										<div class="col-sm-9">
											@if($product['status']==1)
												<input class="form-control" type="checkbox" id="status" name="status" checked>
											@else
												<input class="form-control" type="checkbox" id="status" name="status">
											@endif
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="description">{{trans('label.description')}}</label>
										<div class="col-sm-9">
													<textarea class="form-control summernote" id="description" rows="5" name="description" placeholder="Lọai áo cổ truyền của phụ nữ Việt Nam">{{$product['description'] or ''}}</textarea>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="category">{{trans('label.category')}}</label>
										<div class="col-sm-9">
											<select class="form-control" id="category" name="category_id">
												<option value="">{{trans('label.category')}}</option>
												@if(!empty($categories))
													@foreach($categories as $key => $val)
														<option value="{{$val['id']}}" @if($val['id']==array_get($product,'category_id')) selected @endif>{{$val['name']}}</option>
													@endforeach
												@endif
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="sale_price">{{trans('label.sale_off')}}</label>
										<div class="col-sm-9">
											<input class="form-control" type="number" name="sale_price" placeholder="Giá sale off" value="{{$product['sale_price'] or ''}}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="ratio">{{trans('label.ratio_sale_off')}}</label>
										<div class="col-sm-9">
											<input class="form-control" id="ratio" type="number" name="ratio" min="0" max="100" placeholder="40" value="{{$product['ratio']}}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="quantity">{{trans('label.quantity')}}</label>
										<div class="col-sm-9">
											<input class="form-control" type="number" name="quantity" placeholder="Số lượng" value="{{$product['quantity'] or ''}}">
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group" id="image-preview">
										<label class="control-label" id="image-label" for="image">{{trans('label.image')}}</label>
										<input class="hidden" id="image_hidden" name="image_hidden" value="{{$product['image_id'] or ''}}">
										<input class="form-control" id="image-upload" type="file"  name="image">
										<img class="img img-responsive" id="image_url" src="{{$product['image_url'] or ''}}">
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
				$('#image_hidden').val('');
				readURL(this);
			});
		});
	</script>
@endsection
