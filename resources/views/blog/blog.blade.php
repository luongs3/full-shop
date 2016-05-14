@extends("layout.layout")
@section("content")
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-offset-2 col-sm-9">
					<div class="blog-post-area">
						<h2 class="title text-center">Latest From our Blog</h2>
						@foreach($posts as $post)
							<div class="single-blog-post">
								<h3>
									<a href="{{URL::route('blog.post',['id' => $post['id']])}}">
										{{$post['title']}}
									</a>
								</h3>
								<div class="post-meta">
									<ul>
										<li><i class="fa fa-user"></i> {{$post['user_name']}}</li>
										<li><i class="fa fa-clock-o"></i> {{$post['time']}}</li>
										<li><i class="fa fa-calendar"></i> {{$post['date']}}</li>
									</ul>
								</div>
								<a href="{{URL::route('blog.post',['id' => $post['id']])}}">
									<img src="{{$post['image_url']}}" alt="">
								</a>
								<p>{{$post['subcontent']}}</p>
								<a  class="btn btn-primary" href="{{URL::route('blog.post',['id' => $post['id']])}}">{{trans('label.read_more')}}</a>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection