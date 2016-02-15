@extends("layout.layout")

@section("content")
	<section>
		<div class="container">
			<div class="row">
				@include("layout.left-sidebar-admin")
					<div class="col-sm-10 padding-right">
						@include('layout.result')
						<meta name="_token" content="{{ csrf_token() }}"/>
					<button class="btn btn-default btn_submit" id="btn_update_fp">{{trans('label.featured_product')}}</button>
					<button class="btn btn-default btn_submit" id="btn_delete">{{trans('label.delete')}}</button>
					<a href="{{URL::route('products.create')}}" class="btn btn-default btn_submit" id="btn_add">{{trans('label.add_new')}}</a>
					<div id="grid">
						@include("product.grid-product")
					</div>
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
			var response = confirm("Bạn có chắc chắn muốn xóa những sản phẩm này không?");
			if( response){
				var arr = [];
				$("input[type='checkbox']:checked").each(function(){
					arr.push($(this).attr('id'))
				});
				if(arr.length==0){
					alert("Chọn SP trước khi xóa");
					return false;
				}
				$.ajax({
							type: 'post',
							url: "/products/massive-delete",
							data: {ids: JSON.stringify(arr),
								_token: "{{ csrf_token() }}"},
							success: function(){
								location.reload(true)
							}
						}
				);
			}
		});
		$("#btn_update_fp").click(function(){
			var response = confirm("Cập nhật những sản phẩm này không?");
			if( response){
				var arr = [];
				$("input[type='checkbox']:checked").each(function(){
					arr.push($(this).attr('id'))
				});
				if(arr.length==0){
					alert("Chọn SP trước khi cập nhật");
					return false;
				}

				$.post("/products/update-fp",
						{ids: JSON.stringify(arr),
							_token: "{{ csrf_token() }}"},
						function (result, status) {
							location.reload(true)
						}
				);
			}
		});
	</script>
@endsection
