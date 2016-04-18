<script>
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '488056531319009',
			xfbml      : true,
			version    : 'v2.5'
		});
	};

	(function(d, s, id){
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
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
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#" data-parent="#accordian">Sportswear</a>
						<span data-toggle="collapse" data-target="#sportswear" class="badge pull-right"><i class="fa fa-plus"></i></span>
					</h4>
				</div>
				<div id="sportswear" class="panel-collapse collapse">
					<div class="panel-body">
						<ul>
							<li><a href="">Nike </a></li>
							<li><a href="">Under Armour </a></li>
							<li><a href="">Adidas </a></li>
							<li><a href="">Puma</a></li>
							<li><a href="">ASICS </a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordian" href="#mens">
							<span class="badge pull-right"><i class="fa fa-plus"></i></span>
							Mens
						</a>
					</h4>
				</div>
				<div id="mens" class="panel-collapse collapse">
					<div class="panel-body">
						<ul>
							<li><a href="">Fendi</a></li>
							<li><a href="">Guess</a></li>
							<li><a href="">Valentino</a></li>
							<li><a href="">Dior</a></li>
							<li><a href="">Versace</a></li>
							<li><a href="">Armani</a></li>
							<li><a href="">Prada</a></li>
							<li><a href="">Dolce and Gabbana</a></li>
							<li><a href="">Chanel</a></li>
							<li><a href="">Gucci</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordian" href="#womens">
							<span class="badge pull-right"><i class="fa fa-plus"></i></span>
							Womens
						</a>
					</h4>
				</div>
				<div id="womens" class="panel-collapse collapse">
					<div class="panel-body">
						<ul>
							<li><a href="">Fendi</a></li>
							<li><a href="">Guess</a></li>
							<li><a href="">Valentino</a></li>
							<li><a href="">Dior</a></li>
							<li><a href="">Versace</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><a href="#">Kids</a></h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><a href="#">Fashion</a></h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><a href="#">Households</a></h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><a href="#">Interiors</a></h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><a href="#">Clothing</a></h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><a href="#">Bags</a></h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><a href="#">Shoes</a></h4>
				</div>
			</div>
		</div><!--/category-products-->

		<div class="brands_products"><!--brands_products-->
			<h2>Brands</h2>
			<div class="brands-name">
				<ul class="nav nav-pills nav-stacked">
					<li><a href=""> <span class="pull-right">(50)</span>Acne</a></li>
					<li><a href=""> <span class="pull-right">(56)</span>Grüne Erde</a></li>
					<li><a href=""> <span class="pull-right">(27)</span>Albiro</a></li>
					<li><a href=""> <span class="pull-right">(32)</span>Ronhill</a></li>
					<li><a href=""> <span class="pull-right">(5)</span>Oddmolly</a></li>
					<li><a href=""> <span class="pull-right">(9)</span>Boudestijn</a></li>
					<li><a href=""> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
				</ul>
			</div>
		</div><!--/brands_products-->
		{{--<div class="facebook-fanpage">--}}
			{{--<div class="fb-page" data-href="https://www.facebook.com/facebook" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/facebook"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div></div>--}}
		{{--</div>--}}

	</div>
</div>