@extends("layout.layout")

@section("content")
	<section>
		<div class="container">
			<div class="row">
				@include("layout.left-sidebar-admin")
					<div class="col-sm-10 padding-right">
						@include('layout.result')
						<meta name="_token" content="{{ csrf_token() }}"/>
					<button class="btn btn-default" id="btn_delete">{{trans('label.delete')}}</button>
					<a href="{{URL::route('categories.create')}}" class="btn btn-default" id="btn_add">{{trans('label.add_new')}}</a>
					@include("category.grid-category")
				</div>
			</div>
		</div>
	</section>
	<script>
		$(function(){
			$(document).ready(function() {
				$('table#myTable').DataTable({
					"bPaginate":false
				});
			} );
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
