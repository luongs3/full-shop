<div class="col-sm-3">
	<div class="left-sidebar">
		<h2>Category</h2>
		<div class="panel-group category-products" id="accordian"><!--category-productsr-->
			@if(isset($categories))
				@foreach($categories as $val)
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a href="{{URL::route('products.category',['id' => $val['id']])}}" data-parent="#accordian">{{$val['name']}}</a>
								@if(isset($val['children']))
									<span data-toggle="collapse" data-target="{{'#'.$val['id']}}" class="badge pull-right"><i class="fa fa-plus"></i></span>
								@endif
							</h4>
						</div>
						@if(isset($val['children']))
							<div id="{{$val['id']}}" class="panel-collapse collapse">
								<div class="panel-body">
									<ul>
										@foreach($val['children'] as $val1)
											<li><a href="{{URL::route('products.category',['id' => $val1['id']])}}">{{$val1['name']}} </a></li>
										@endforeach
									</ul>
								</div>
							</div>
						@endif
					</div>
				@endforeach
			@endif
		</div><!--/category-products-->

		{{--<div class="facebook-fanpage">--}}
			{{--<div class="fb-page" data-href="https://www.facebook.com/facebook" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div></div>--}}
		{{--</div>--}}

	</div>
</div>