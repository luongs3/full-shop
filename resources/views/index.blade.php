@extends("layout.layout")
@section("content")
	@if(isset($ad))
		<div id="ajax-loading-mask" class="loading-mask advert_mask"></div>
		<div id="ajax-loading" class="loading">
			<img id="advert_image" src="{{url($ad['url'])}}" alt="general.loading..." />
			<img id="advert_remove" src="{{url('/images/home/remove.jpg')}}" alt="{{trans('label.turn_off')}}">
		</div>
	@endif
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel" data-interval="3000">
						<ol class="carousel-indicators">
								@if(isset($files[0])) <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>@endif
								@if(isset($files[1])) <li data-target="#slider-carousel" data-slide-to="1"></li>@endif
								@if(isset($files[2])) <li data-target="#slider-carousel" data-slide-to="2"></li>@endif
						</ol>

						<div class="carousel-inner">
							@if(isset($files[0]))
								<div class="item active">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Giảm giá đến 50%</h2>
									<p>Phiên chợ sách cuối tuần, cửa hàng sẽ giảm sốc đến 50% tất cả các sản phẩm. Khuyến mãi sẽ diễn ra vào Chủ Nhật ngày 29/05/2016</p>
									<a href="{{ URL::route('blog.post',['id' => '8']) }}" type="button" class="btn btn-default get">Xem chi tiết</a>
								</div>
								<div class="col-sm-6">
									<img src="{{url($files[0]['url'])}}" class="girl img-responsive" alt="" />
								</div>
							</div>
							@endif
														@if(isset($files[0]))

							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Đọc truyện Harry Potter</h2>
									<p>Cùng đón đọc truyện Harry Potter phần 8 - Harry Potter và bảo bối tử thần. Được phát hành vào ngày 25/05/2016</p>
									<a href="{{ URL::route('blog.post',['id' => '9']) }}" type="button" class="btn btn-default get">Xem chi tiết</a>
								</div>
								<div class="col-sm-6">
									<img src="{{url($files[1]['url'])}}" class="girl img-responsive" alt="" />
								</div>
							</div>
							@endif
							@if(isset($files[0]))

							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Giảm giá 49% các đầu sách trẻ</h2>
									<p>Chương trình đặc biệt, khuyến mãi đầu hè, giảm giá tất cả các đầu sách trẻ lên đến 49%. Khuyến mãi bắt đầu áp dụng từ ngày 30/05 đến ngày 02/06</p>
									<a href="{{ URL::route('blog.post',['id' => '10']) }}" type="button" class="btn btn-default get">Xem chi tiết</a>
								</div>
								<div class="col-sm-6">
									<img src="{{url($files[2]['url'])}}" class="girl img-responsive" alt="" />
								</div>
							</div>

							@endif
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
						<h2 class="title text-center">Sản phẩm</h2>
						@if(isset($featured_products))
							@foreach($featured_products as $val)
								<div class="col-sm-4">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<a href="{{URL::route('products.detail',['sku' => $val['sku']])}}">
													@if(isset($val['image_url']))
														<img src="{{url($val['image_url'])}}" alt="" />
													@else
														<img src="{{asset('images/images.jpg')}}" alt="" />
													@endif
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
																		@if(isset($product['image_url']))
																			<img class="product-tab-img" src="{{url($product['image_url'])}}" alt="" />
																		@else
																			<img src="{{asset('images/images.jpg')}}" alt="" />
																		@endif
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
			if($('.loading').length>0){
				$('.loading').css('display','block');
				$('.loading-mask').css('display','block');
			}
			$('#advert_remove').click(function(){
				$('#ajax-loading-mask').hide();
				$('#ajax-loading').hide();
			})
		});
	</script>
@endsection
