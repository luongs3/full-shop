@extends("layout.layout")
@section('content')
	<div class="container text-center">
		<div class="logo-404">
			<a href="{{URL::route('/')}}"><img src="/images/home/logo.png" alt="" /></a>
		</div>
		<div class="content-404">
			<img src="/images/404/404.png" class="img-responsive" alt="" />
			@include('layout.result')
			<h1><b>OPPS!</b> {{trans('message.can_not_find_this_page')}}</h1>
			<p>{{trans('message.page_you_are_looking_for_is_disappear')}}.</p>
			<h2><a href="{{URL::route('/')}}">{{trans('message.bring_me_back_home')}}</a></h2>
		</div>
	</div>
@endsection