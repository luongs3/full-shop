@extends("layout.layout")
@section("content")
<body>

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
							{{--<div class="dropdown">--}}
								{{--<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Hiển thị--}}
									{{--<span class="caret"></span></button>--}}
								{{--<ul class="dropdown-menu">--}}
									{{--<li><a href="#">10</a></li>--}}
									{{--<li><a href="#">20</a></li>--}}
									{{--<li><a href="#">30</a></li>--}}
								{{--</ul>--}}
							{{--</div>--}}
						</div>
						@if(isset($products))
							@foreach($products as $val)
								<div class="col-sm-4">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<a href="{{URL::route('products.detail',['sku'=>$val['sku']])}}"><img src="{{$val['image_url']}}" alt="" /></a>
												<h2>{{$val['price']}} đ</h2>
												<p>{{$val['name']}}</p>
												<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
											</div>
										</div>
										<div class="choose">
											<ul class="nav nav-pills nav-justified">
												<li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
												<li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
											</ul>
										</div>
									</div>
								</div>
							@endforeach
						@endif
						{{--<ul class="pagination">--}}
							{{--<li class="active"><a href="">1</a></li>--}}
							{{--<li><a href="">2</a></li>--}}
							{{--<li><a href="">3</a></li>--}}
							{{--<li><a href="">&raquo;</a></li>--}}
						{{--</ul>--}}
					</div><!--features_items-->
				</div>
				{!! $products->render() !!}

			</div>
		</div>
	</section>
@endsection
