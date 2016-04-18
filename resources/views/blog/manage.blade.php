@extends("layout.layout")

@section("content")
	<section class="manage">
		<div class="container">
			<div class="row">
				@include("layout.left-sidebar-admin")
				<div class="col-sm-10 padding-right">
						@include('layout.result')
						<h3 class="page-header">{{trans('label.manage_category')}}</h3>
						<meta name="_token" content="{{ csrf_token() }}"/>
					<button class="btn btn-default btn_submit" id="btn_delete">{{trans('label.delete')}}</button>
					<a href="{{URL::route('categories.create')}}" class="btn btn-default btn_submit" id="btn_add">{{trans('label.add_new')}}</a>
					<div id="grid">
						@include("category.grid-category")
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
			var response = confirm("Bạn có chắc chắn muốn xóa những Loại SP này không?");
			if( response){
				var arr = [];
				$("input[type='checkbox']:checked").each(function(){
					arr.push($(this).attr('id'))
				});
				if(arr.length==0){
					alert("Chọn Loại SP trước khi Xóa");
					return false;
				}
				$.ajax({
							type: 'post',
							url: "/categories/massive-delete",
							data: {ids: JSON.stringify(arr),
								_token: "{{ csrf_token() }}"},
							success: function(){
								window.location.replace("/categories/manage");
							}
						}
				);
			}
		});
	</script>
@endsection
