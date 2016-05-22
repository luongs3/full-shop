@extends("layout.layout")
@section("content")
	@if(isset($ad))
		<div id="ajax-loading-mask" class="loading-mask advert_mask"></div>
		<div id="ajax-loading" class="loading">
			<img id="advert_image" src="{{url($ad['url']) or ''}}" alt="general.loading..." />
			<img id="advert_remove" src="{{url('/images/home/remove.jpg')}}" alt="{{trans('label.turn_off')}}">
		</div>
	@endif
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel" data-interval="3000">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>

						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Free E-Commerce Template</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<a href="{{ URL::route('/') }}" type="button" class="btn btn-default get">Get it now</a>
								</div>
								<div class="col-sm-6">
									<img src="{{url($files[0]['url']) or ''}}" class="girl img-responsive" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>100% Responsive Design</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<a href="{{ URL::route('/') }}" type="button" class="btn btn-default get">Get it now</a>
								</div>
								<div class="col-sm-6">
									<img src="{{url($files[1]['url']) or ''}}" class="girl img-responsive" alt="" />
									{{--<img src="/images/home/pricing.png"  class="pricing" alt="" />--}}
								</div>
							</div>

							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Free Ecommerce Template</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<a href="{{ URL::route('/') }}" type="button" class="btn btn-default get">Get it now</a>
								</div>
								<div class="col-sm-6">
									<img src="{{url($files[2]['url']) or ''}}" class="girl img-responsive" alt="" />
									{{--<img src="/images/home/pricing.png" class="pricing" alt="" />--}}
								</div>
							</div>

						</div>

						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>

				</div>
			</div>
		</div>
	</section><!--/slider-->

	<section>
		<div class="container">
			<div class="row">
				@include('layout.left-sidebar')
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>
						@if(isset($featured_products))
							@foreach($featured_products as $val)
								<div class="col-sm-4">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<a href="{{URL::route('products.detail',['sku' => $val['sku']])}}">
													<img src="{{url($val['image_url'])}}" alt="" />
												</a>
												@if(isset($val['sale_price']))
													<div class="sale_line">
														<span class="price">{{number_format($val['sale_price'])}} đ</span>
														<span class="label label-warning">-{{$val['ratio']}}%</span>
													</div>
													<span class="price sale_price">{{number_format($val['price'])}} đ</span>
												@else
													<span class="price">{{number_format($val['price'])}} đ</span>
												@endif
												<p class="product-name">{{$val['name']}}</p>
												<button class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>{{trans('general.add_to_cart')}}</button>
												<input type="hidden" name="product_id" id="{{$val['product_id']}}">
											</div>
										</div>
										{{--<div class="choose">--}}
											{{--<ul class="nav nav-pills nav-justified">--}}
												{{--<li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>--}}
												{{--<li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>--}}
											{{--</ul>--}}
										{{--</div>--}}
									</div>
								</div>
							@endforeach
						@endif
					</div><!--features_items-->
					@if(!empty($categoryProducts))
						<div class="category-tab"><!--category-tab-->
							<div class="col-sm-12">
								<ul class="nav nav-tabs">
									@foreach($categoryNames as $key => $categoryName)
										@if($key==0)
											<li class="active"><a href="#{{ $key }}" data-toggle="tab">{{ $categoryName }}</a></li>
										@else
											<li><a href="#{{ $key }}" data-toggle="tab">{{ $categoryName }}</a></li>
										@endif
									@endforeach
								</ul>
							</div>
							<div class="tab-content">
								@foreach($categoryProducts as $key => $categoryProduct)
									@if($key==0)
										<div class="tab-pane fade active in " id="{{ $key }}" >
									@else
										<div class="tab-pane fade" id="{{ $key }}" >
									@endif
										@if(!empty($categoryProduct))
											@foreach($categoryProduct as $key1 => $product)
													<div class="col-sm-3">
														<div class="product-image-wrapper">
															<div class="single-products">
																<div class="productinfo text-center">
																	<a href="{{URL::route('products.detail',['sku' => $product['sku']])}}">
																		<img class="product-tab-img" src="{{url($product['image_url']) or asset('images/images.jpg')}}" alt="" />
																	</a>
																	<div class="product-tab-name">{{$product['name']}}</div>
																	<div class="product-tab-price">
																		@if(empty($product['sale_price']))
																			<span class="price">{{number_format($product['price'])}} đ</span>
																		@else
																			<div>
																				<span class="price">{{number_format($product['sale_price'])}} đ</span>
																				<span class="label label-warning">-{{$product['ratio']}}%</span>
																			</div>
																			<span class="price sale_price">{{number_format($product['price'])}} đ</span>
																		@endif
																	</div>
																	<button class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>{{trans('general.add_to_cart')}}</button>
																	<input type="hidden" name="product_id" id="{{$product['id']}}">
																</div>

															</div>
														</div>
													</div>
											@endforeach
										@endif
									</div>
								@endforeach
							</div>
						</div><!--/category-tab-->
				</div>
					@endif

				</div>
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
