@extends("layout.layout")

@section("content")
	<section class="manage">
		<div class="container">
			<div class="row">
				@include("layout.left-sidebar-admin")
				<div class="col-sm-10 padding-right">
						@include('layout.result')
						<h3 class="page-header">{{trans('label.manage_order')}}</h3>
						<meta name="_token" content="{{ csrf_token() }}"/>
					<button class="btn btn-default btn_submit" id="btn_update_status">{{trans('label.update_status_order')}}</button>
					{{--<button class="btn btn-default btn_submit" id="btn_delete">{{trans('label.delete')}}</button>--}}
					<a href="{{URL::route('orders.create')}}" class="btn btn-default btn_submit" id="btn_add">{{trans('label.add_new')}}</a>
					<div id="grid">
						@include("order.grid-order")
					</div>
				</div>
			</div>
		</div>
	</section>
	<script>
		$(function(){
			$(document).ready(function() {
				$('table#order-table').DataTable({
					"bPaginate":false
				});
			} );
		});
		{{--$("#btn_delete").click(function(){--}}
			{{--var response = confirm("Bạn có chắc chắn muốn xóa những sản phẩm này không?");--}}
			{{--if( response){--}}
				{{--var arr = [];--}}
				{{--$("input[type='checkbox']:checked").each(function(){--}}
					{{--arr.push($(this).attr('id'))--}}
				{{--});--}}
				{{--if(arr.length==0){--}}
					{{--alert("Chọn SP trước khi xóa");--}}
					{{--return false;--}}
				{{--}--}}
				{{--$.ajax({--}}
							{{--type: 'post',--}}
							{{--url: "/products/massive-delete",--}}
							{{--data: {ids: JSON.stringify(arr),--}}
								{{--_token: "{{ csrf_token() }}"},--}}
							{{--success: function(){--}}
								{{--location.reload(true)--}}
							{{--}--}}
						{{--}--}}
				{{--);--}}
			{{--}--}}
		{{--});--}}
		$("#btn_update_status").click(function(){
{{--			var response = confirm("{{trans('message.update_these_order')}}");--}}
//			if( response){
				var arr = {};
				var status;
				$("input[type='checkbox']:checked").each(function(index,element){
					status = $(this).parent().nextAll('td.status').find('select').val();
					arr[index] = {'id':$(this).attr('id'),'status':status};
				});
				if($.isEmptyObject(arr)){
					alert("Chọn đơn hàng trước khi cập nhật");
					return false;
				}

				$.post("/orders/update-status",
						{data: JSON.stringify(arr),
							_token: "{{ csrf_token() }}"},
						function (result, status) {
							location.reload(true)
						}
				);
//			}
		});
		$("#general_checkbox").click(function(){
			$('.massive_checkbox').trigger('click');
		})
	</script>
@endsection
