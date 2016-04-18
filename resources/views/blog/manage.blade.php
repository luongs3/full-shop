@extends("layout.layout")

@section("content")
	<section class="manage">
		<div class="container">
			<div class="row">
				@include("layout.left-sidebar-admin")
				<div class="col-sm-10 padding-right">
						@include('layout.result')
						<h3 class="page-header">{{trans('label.manage_blog')}}</h3>
						<meta name="_token" content="{{ csrf_token() }}"/>
					<button class="btn btn-default btn_submit" id="btn_delete">{{trans('label.delete')}}</button>
					<a href="{{URL::route('blog.create')}}" class="btn btn-default btn_submit" id="btn_add">{{trans('label.add_new')}}</a>
					<div id="grid">
						@include("blog.grid")
					</div>
				</div>
			</div>
		</div>
	</section>
	<script>
			$(document).ready(function() {
				$('table#category-table').DataTable({
					"bPaginate":false
				});
			});
		$("#btn_delete").click(function(){
			var response = confirm("Bạn có chắc chắn muốn xóa những bài viết này không?");
			if( response){
				var arr = [];
				$("input[type='checkbox']:checked").each(function(){
					arr.push($(this).attr('id'))
				});
				if(arr.length==0){
					alert("Chọn bài viết trước khi Xóa");
					return false;
				}
				$.ajax({
							type: 'post',
							url: "/blog/massive-delete",
							data: {ids: JSON.stringify(arr),
								_token: "{{ csrf_token() }}"},
							success: function(){
								window.location.replace("/blog/manage");
							}
						}
				);
			}
		});
	</script>
@endsection
