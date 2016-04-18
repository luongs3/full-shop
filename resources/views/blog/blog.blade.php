@extends("layout.layout")
@section("content")
	<section>
		<div class="container">
			<div class="row">
				@include("layout.left-sidebar")
				<div class="col-sm-9">
					<div class="blog-post-area">
						<h2 class="title text-center">Latest From our Blog</h2>
						@foreach($posts as $post)
							<div class="single-blog-post">
								<h3>								<a href="{{URL::route('blog.post',['id' => $post['id']])}}">
										{{$post['title']}}
									</a>
									</h3>
								<div class="post-meta">
									<ul>
										<li><i class="fa fa-user"></i> {{$post['user_name']}}</li>
										<li><i class="fa fa-clock-o"></i> {{$post['time']}}</li>
										<li><i class="fa fa-calendar"></i> {{$post['date']}}</li>
									</ul>
								{{--<span>--}}
										{{--<i class="fa fa-star"></i>--}}
										{{--<i class="fa fa-star"></i>--}}
										{{--<i class="fa fa-star"></i>--}}
										{{--<i class="fa fa-star"></i>--}}
										{{--<i class="fa fa-star-half-o"></i>--}}
								{{--</span>--}}
								</div>
								<a href="{{URL::route('blog.post',['id' => $post['id']])}}">
									<img src="{{$post['image_url']}}" alt="">
								</a>
								<p>{{$post['subcontent']}}</p>
								<a  class="btn btn-primary" href="{{URL::route('blog.post',['id' => $post['id']])}}">{{trans('label.read_more')}}</a>
							</div>
						@endforeach
						{{--<div class="pagination-area">--}}
							{{--<ul class="pagination">--}}
								{{--<li><a href="" class="active">1</a></li>--}}
								{{--<li><a href="">2</a></li>--}}
								{{--<li><a href="">3</a></li>--}}
								{{--<li><a href=""><i class="fa fa-angle-double-right"></i></a></li>--}}
							{{--</ul>--}}
						{{--</div>--}}
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection