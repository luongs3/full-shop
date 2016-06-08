@extends("layout.layout")
@section("content")
	<section>
		<div class="container">
			<div class="row">
				@include("layout.left-sidebar")
				<div class="col-sm-9 padding-right">
					{{--sort--}}
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">{{$category['name']}}</h2>
						<div class="sort-category">
							<div class="dropdown">
								<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{trans('label.sort')}}
									<span class="caret"></span></button>
								<ul class="dropdown-menu dropdown-menu-left">
									<li><a href="{{URL::route('products.category',['id' => $category['id'], 'order_by' => 'created_at', 'direction' => 'DESC'])}}">{{trans('general.new_product')}}</a></li>
									<li><a href="{{URL::route('products.category',['id' => $category['id'], 'order_by' => 'price', 'direction' => 'DESC'])}}">{{trans('general.sale_DESC')}}</a></li>
									<li><a href="{{URL::route('products.category',['id' => $category['id'], 'order_by' => 'price', 'direction' => 'ASC'])}}">{{trans('general.sale_ASC')}}</a></li>
									<li><a href="{{URL::route('products.category',['id' => $category['id'], 'order_by' => 'ratio', 'direction' => 'DESC'])}}">{{trans('general.sale_off_ratio_DESC')}}</a></li>
									<li><a href="{{URL::route('products.category',['id' => $category['id'], 'order_by' => 'ratio', 'direction' => 'ASC'])}}">{{trans('general.sale_off_ratio_DESC')}}</a></li>
								</ul>
							</div>
						</div>
						@if(isset($products))
							@foreach($products as $val)
								<div class="col-sm-4">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<a href="{{URL::route('products.detail',['sku'=>$val['sku']])}}">
													@if(isset($val['image_url']))
														<img src="{{url($val['image_url'])}}" alt="">
													@else
														<img src="{{asset('images/images.jpg')}}" alt="" />
													@endif
												</a>
												<div class="product-tab-price">@if(isset($val['sale_price']))
													<div>
														<span class="price">{{number_format($val['sale_price'])}} đ</span>
														<span class="label label-warning">-{{$val['ratio']}}%</span>
													</div>
													<span class="price sale_price">{{number_format($val['price'])}} đ</span>
												@else
														<span class="price">{{number_format($val['price'])}} đ</span>
												@endif</div>
												<p class="product-name">{{$val['name']}}</p>
												<button class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>{{trans('general.add_to_cart')}}</button>
												<input type="hidden" name="product_id" id="{{$val['id']}}">
												{{--<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>--}}
											</div>
										</div>
									</div>
								</div>
							@endforeach
						@endif
					</div><!--features_items-->
				</div>
				{!! $products->render() !!}

			</div>
		</div>
	</section>
	<script>
		$(document).ready(function(){
			$('.add-to-cart').click(function(){
				$.ajax({
					type: "POST",
					url: "/cart/add-item",
					data: {product_id:  $(this).next().attr('id'),
						quantity: 1,
						_token: "{{ csrf_token() }}"},
					success: function(data){
						window.location="{{URL::route('cart')}}"
					}
				});
			});
			$('#advert_remove').click(function(){
				$('#ajax-loading-mask').hide();
				$('#ajax-loading').hide();
			})
		});
	</script>
@endsection
