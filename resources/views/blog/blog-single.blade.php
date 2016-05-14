@extends("layout.layout")
@section("content")
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-offset-2 col-sm-9">
					<div class="blog-post-area">
						<h2 class="title text-center">Latest From our Blog</h2>
						<div class="single-blog-post">
							<h3>{{$post['title']}}</h3>
							<div class="post-meta">
								<ul>
									<li><i class="fa fa-user"></i> {{$post['user_name']}}</li>
									<li><i class="fa fa-clock-o"></i> {{$post['time']}}</li>
									<li><i class="fa fa-calendar"></i> {{$post['date']}}</li>
								</ul>
							</div>
							<img class="post-image" src="{{$post['image_url']}}" alt="">
							<p>{!! $post["content"] !!}</p>
						</div>
					</div><!--/blog-post-area-->
					<div class="fb-comments" data-href="{{URL::route('blog.post',['id'=>$post['id']])}}" data-width="800" data-numposts="5"></div>
				</div>
			</div>
		</div>
	</section>
@endsection