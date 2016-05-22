@extends("layout.layout")
@section("content")
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
					<li><a href="#">{{trans('label.home')}}</a></li>
					<li class="active">{{trans('label.check_out')}}</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="step-one">
				<h2 class="heading">{{trans('label.checkout')}}</h2>
			</div>

			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-5">
						<div class="bill-to">
							<p>{{trans('label.billing_address')}}</p>
							<div class="form-one">
								<form method="post" action="{{URL::route('post-checkout')}}">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="text" name="name" placeholder="{{trans('label.name')}}" value="{{$address['name'] or ''}}">
									<input type="text" name="email" placeholder="{{trans('label.email')}}*" value="{{$address['email'] or ''}}" required>
									<input type="text" name="address" placeholder="{{trans('label.address')}}*" value="{{$address['address'] or ''}}" required>
									<select name="province" id="province">
										<option value="">{{trans('label.choose_province')}}</option>
										@if(isset($provinces))
											@foreach($provinces as $val)
												@if(isset($address['province']))
													<option value="{{$val['id']}}"  @if($val['id']==$address['province']) selected @endif>{{$val['name']}}</option>
												@else
													<option value="{{$val['id']}}">{{$val['name']}}</option>
												@endif

											@endforeach
										@endif
									</select>
									<select name="district" id="district">
										<option value="">{{trans('label.choose_district')}}</option>
										@if(isset($districts))
											@foreach($districts as $val)
												@if(isset($address['district']))
													<option value="{{$val['id']}}" @if($val['id']==$address['district']) selected @endif>{{$val['name']}}</option>
												@else
													<option value="{{$val['id']}}">{{$val['name']}}</option>
												@endif
											@endforeach
										@endif
									</select>
									<input type="text" name="phone_number" value="{{$address['address'] or ''}}" placeholder="{{trans('label.phone_number')}}">
									<button type="submit" class="btn btn-warning">{{trans('label.post_order')}}</button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="review-payment">
							<p>{{trans('label.review_and_payment')}}</p>
						</div>
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
												<a href=""><img src="{{url($item['image_url'])}}" alt=""></a>
											</td>
											<td class="cart_description">
												<h4><a href="">{{$item['name']}}</a></h4>
												<p>{{trans('label.sku')}}: {{$item['sku']}}</p>
												@if(!empty($item['option']))
													@foreach($item['option'] as $option)
														<p>{{ $option['title'] . ": " . $option['value'] }}</p>
													@endforeach
												@endif
											</td>
											<td class="cart_price">
												@if(isset($item['sale_price']))
													<div class="sale_line">
														<p>{{number_format($item['sale_price'])}} đ</p>
													</div>
													<p class="sale_price">{{number_format($item['price'])}} đ</p>
												@else
													<p>{{number_format($item['price'])}} đ</p>
												@endif
											</td>
											<td class="cart_quantity">
												<div class="cart_quantity_button">
													<div class="cart_quantity_input">{{$item['quantity']}}</div>
												</div>
											</td>
											<td class="cart_total">
												<p class="cart_total_price">{{number_format($item['sub_total'])}}</p>
											</td>
											<td class="cart_delete">
												<button class="cart_quantity_delete" id="{{$key}}" href=""><i class="fa fa-times"></i></button>
											</td>
										</tr>
									@endforeach
								@endif
								@if(isset($price))
									<tr>
										<td colspan="4">&nbsp;</td>
										<td colspan="2">
											<table class="table table-condensed total-result">
												<tr>
													<td>{{trans('label.sub_total')}}</td>
													<td>{{number_format($price["sub_price"])}}</td>
												</tr>
												{{--<tr>--}}
													{{--<td>Exo Tax</td>--}}
													{{--<td>$2</td>--}}
												{{--</tr>--}}
												<tr class="shipping-cost">
													<td>Shipping Cost</td>
													<td>Free</td>
												</tr>
												<tr>
													<td>{{trans('label.total_price')}}</td>
													<td><span>{{number_format($price['total_price'])}}</span></td>
												</tr>
											</table>
										</td>
									</tr>
								@endif
								</tbody>
							</table>
						</div>
						</div>
				</div>
			</div>
		</div>
	</section> <!--/#cart_items-->
	<script>
		$('#district').click(function(){
			if($("#province").find(":selected").val()==""){
				alert("{{trans("message.choose_province_first")}}");
				return false;
			}
		});
		$("#province").change(function(){
			$.ajax({
				type: "GET",
				url: "/select-districts/"+$(this).val(),
				success: function(data){
					var distrcts = $('#district');
					distrcts.empty();
					distrcts.append('<option value="">'+'{{trans("label.choose_district")}}'+'</option>');
					for(i=0; i<data.length;i++){
						distrcts.append('<option value='+data[i].id+'>'+data[i].name+'</option>');
					}
				}
			})
		})
	</script>
@endsection
