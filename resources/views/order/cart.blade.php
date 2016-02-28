@extends("layout.layout")
@section("content")
	<div id="ajax-loading-mask" class="loading-mask"></div>
	<div id="ajax-loading" class="loading">
		<img src="/images/shop/loading.gif" alt="general.loading..." />
		<p>Please wait</p>
	</div>
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
					<li><a href="#">{{trans('label.home')}}</a></li>
					<li class="active">{{trans('label.shopping_cart')}}</li>
				</ol>
			</div>
			@include('layout.result')
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
					<tr class="cart_menu">
						<td class="image">{{trans('label.item')}}</td>
						<td class="description">{{trans('label.description')}}</td>
						<td class="price">{{trans('label.price')}}</td>
						<td class="quantity">{{trans('label.quantity')}}</td>
						<td class="total">{{trans('label.total')}}</td>
						<td></td>
					</tr>
					</thead>
					<tbody>
					@if(isset($items))
						@foreach($items as $key => $item)
							<tr>
								<td class="cart_product">
									<a href=""><img src="{{$item['image_url'] or ''}}" alt=""></a>
								</td>
								<td class="cart_description">
									<h4><a href="">{{$item['name']}}</a></h4>
									<p>{{trans('label.sku')}}: {{$item['sku']}}</p>
								</td>
								<td class="cart_price">
									@if(isset($item['sale_price']))
										<div class="sale_line">
											<p>{{$item['sale_price']}} đ</p>
										</div>
										<p class="sale_price">{{$item['price']}} đ</p>
									@else
										<p>{{$item['price']}} đ</p>
									@endif
								</td>
								<td class="cart_quantity">
									<div class="cart_quantity_button">
										<input class="cart_quantity_input" type="number" name="quantity" value="{{$item['quantity']}}" min="2" max="10" autocomplete="off" size="5" title="{{trans('general.max_10')}}">
										<input class="item_id" type="hidden" value="{{$key}}">
									</div>
								</td>
								<td class="cart_total">
									<p class="cart_total_price">{{$item['sub_total']}}</p>
								</td>
								<td class="cart_delete">
									<button class="cart_quantity_delete" id="{{$key}}" href=""><i class="fa fa-times"></i></button>
								</td>
							</tr>
						@endforeach
					@endif
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->
	@if(isset($price))
	<section id="do_action">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-6">
					<div class="total_area">
						<ul>
							<li>{{trans('label.cart_sub_total')}}<span>{{$price['sub_price']}} đ</span></li>
							<li>{{trans('label.shipping_cost')}}<span>{{trans('label.free')}}</span></li>
							<li>{{trans('label.total')}}<span>{{$price['total_price']}}</span></li>
						</ul>
						<a class="btn btn-default check_out" href="{{URL::route('get-checkout')}}">{{trans('label.check_out')}}</a>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->
	@endif
	<script>
		$(document).ready(function () {
			$('button.cart_quantity_delete').click(function(){
				$.ajax({
					type: "POST",
					url: "/cart/remove-item",
					data: {key: $(this).attr('id'),
						_token: "{{ csrf_token() }}"},
					success: function(data){
						location.reload(true)
					}
				});
			});

			$('.cart_quantity_input').change(function(){
				console.log($(this).val());
				return false;
				$.ajax({
					beforeSend: function(){
						$('#ajax-loading-mask').show();
						$('#ajax-loading').show();
					},
					type: "POST",
					url: "/cart/change-quantity",
					data: {key: $(this).next().attr('value'),
					quantity: $(this).val(),
						_token: "{{ csrf_token() }}"},
					success: function(data){
						$('#ajax-loading-mask').hide();
						$('#ajax-loading').hide();
					}
				})
			})
		});
	</script>
@endsection
