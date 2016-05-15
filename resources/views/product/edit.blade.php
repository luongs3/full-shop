@extends("layout.layout")
@section("content")
	<section id="edit_section">
		<div class="container">
			<div class="row">
				@include('layout.left-sidebar-admin')
					<div class="shopper-informations col-sm-10">
						<div class="row">
							@include('layout.result')
							<form  class="form-horizontal" enctype="multipart/form-data" action="{{URL::route('products.save',['id' => $product['id']])}}" method="POST" role="form" >
								<div class="page-header">
									<h2>{{trans('label.edit_product')}}</h2>
									<button type="submit" class="btn btn-default btn-lg btn_header">{{trans('label.save')}}</button>
									<button type="button" class="btn btn-default btn-lg btn_header" id="btn-delete">{{trans('label.delete')}}</button>
									<button type="button" class="btn btn-default btn-lg btn_header" id="btn-back">{{trans('label.back')}}</button>
								</div>
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="id" value="{{$product['id'] or ''}}">
								<div class="col-sm-8">
									<div class="form-group">
										<label class="control-label col-sm-2" for="name">{{trans('label.name')}}<span class="required"> *</span></label>
										<div class="col-sm-9">
											<input class="form-control" id="name" type="text" name="name" required placeholder="Áo dài" value="{{$product['name'] or ''}}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label col-sm-2" for="sku">{{trans('label.sku')}}<span class="required"> *</span></label>
										<div class="col-sm-9">
											<input class="form-control" id="sku" type="text" name="sku" required placeholder="ao-dai-nhap-khau" value="{{$product['sku'] or ''}}">
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
										<label class="control-label col-sm-2" for="category">{{trans('label.category')}} <span class="required"> *</span></label>
										<div class="col-sm-9">
											<select class="form-control" id="category" required name="category_id">
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
										<div class="form-group">
											<input type="hidden" id="option-count" name="option-count" value="{{ $product['option-count'] or 0 }}">
											<label class="control-label col-sm-2" for="title-0">{{trans('label.option')}}</label>
											<div class="col-sm-9" id="option-wrap">
												@if(!empty($product['option']))
													@foreach($product['option'] as $key => $option)
														<input class="form-control option-title" type="text" name="{{ 'title-' . $key }}" id="{{ 'title-' . $key }}" placeholder="{{trans('label.option_title')}}" value="{{ $option['tilte'] or '' }}">
														<input class="form-control col-sm-10 option-value" type="text" name="{{ 'value-' . $key }}" id="{{ 'value-' . $key }}" placeholder="{{ trans('label.option_value') }}" value="{{ $option['value'] or '' }}">
														<button class="btn btn-warning option-remove" id="{{ 'remove-' . $key }}">{{ trans('label.remove_option') }}</button>
													@endforeach
												@else
													<input class="form-control option-title" type="text" name="title-0" id="title-0" placeholder="{{trans('label.option_title')}}" value="{{old('title-0')}}">
													<input class="form-control col-sm-10 option-value" type="text" name="value-0" id="value-0" placeholder="{{ trans('label.option_value') }}" value="{{ old('value-0') }}">
													<button class="btn btn-warning option-remove" id="remove-0">{{ trans('label.remove_option') }}</button>
												@endif
											</div>
										</div>
									<div class="form-group hidden">
										<label class="control-label col-sm-2" for="title-0">{{trans('label.option')}}</label>
										<div class="col-sm-9">
											<input class="form-control option-title" type="text" placeholder="{{trans('label.option_title')}}" value="{{old('title-0')}}">
											<input class="form-control col-sm-10 option-value" type="text" placeholder="{{ trans('label.option_value') }}" value="{{ old('value-0') }}">
											<button class="btn btn-warning option-remove">{{ trans('label.remove_option') }}</button>
										</div>
									</div>
									<button class="btn btn-default new-option">{{ trans('label.new_option') }}</button>
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
				height: 200,                 // set editor height
				onImageUpload: function(files, editor, welEditable) {
					sendFile(files[0], editor, welEditable);
				}
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
		$("#btn-delete").click(function(){
			var response = confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?");
			if( response) {
				window.location.replace("{{URL::route('products.delete',['id' => $product['id']] )}}");
			}
		});
		$("#btn-back").click(function(){
			window.history.back();
		});
		$("#value-0").keydown(function(){
			$("#option-count").val(1);
		});
		$('.new-option').on('click',function(event){
			parent = $(this).prev();
			newOption = parent.find('.col-sm-9');
			parent = parent.prev().find('.col-sm-9');
			no = parent.find('.option-title').length;
			newOption.find('.option-title').attr({name: 'title-' + no, id: 'title-' + no});
			newOption.find('.option-value').attr({name: 'value-' + no, id: 'value-' + no});
			newOption.find('.option-remove').attr({id: 'remove-' + no});
			parent.append(newOption.children().clone());
			event.preventDefault();
		});
		$("#option-wrap").on('click','.option-remove',function(event){
			event.preventDefault();
			no = $(this).attr('id').split('-')[1];
			var response = confirm("{{ trans('message.delete_this_option') }}");
			if( response){
				$("#title-"+no).remove();
				$("#value-"+no).remove();
				$("#remove-"+no).remove();
			}
		});
	</script>
@endsection
