@extends("layout.layout")

@section("content")
	<section>
		<div class="container">
			<div class="row">
				@include("layout.left-sidebar-admin")
					<div class="col-sm-10 padding-right">
						@include('layout.result')
						<meta name="_token" content="{{ csrf_token() }}"/>
					<button class="btn btn-default btn_submit" id="btn_delete">Xóa</button>
					<a href="{{URL::route('products.manage')}}" class="btn btn-default btn_submit" id="btn_add">{{trans('label.add_new')}}</a>
					<div id="grid">
						<table id="myTable" class="table table-bordered table-striped table-responsive">
							<thead>
							<tr role="row">
								<th></th>
								<th title="Asc">{{trans('label.id')}}</th>
								<th title="Asc">{{trans('label.product_id')}}</th>
								<th title="Asc">{{trans('label.name')}}</th>
								<th title="Asc">{{trans('label.sku')}}</th>
								<th data-name="edit"title="edit">{{trans('label.edit')}}</th>
							</tr>
							</thead>
							<tbody>
							@foreach($products as $key => $val)
								<tr id="{{$val->id}}">
									<td><input class="massive_checkbox" name="massive_checkbox" type="checkbox" id="{{$val->id}}"></td>
									<td>{{$val->id}}</td>
									<td>{{$val->product_id}}</td>
									<td>{{$val->name}}</td>
									<td>{{$val->sku}}</td>
									<td><a href="{{URL::route('products.edit') .'/'.$val->product_id}}" title="edit"><i class="fa fa-edit"></i> </a> </td>
								</tr>
							@endforeach
							{!! $products->render() !!}
							</tbody>
						</table>
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
					alert("Chọn sản phẩm trước khi xóa");
					return false;
				}
				$.ajax({
							type: 'post',
							url: "/products/massive-delete-fp",
							data: {ids: JSON.stringify(arr),
								_token: "{{ csrf_token() }}"},
							success: function(){
								location.reload(true)
							}
						}
				);
			}
		});
	</script>
@endsection
