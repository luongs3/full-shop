<table id="product-table" class="table table-bordered table-striped table-responsive table-grid">
		<thead>
		<tr role="row">
			<th><input class="general_checkbox" name="general_checkbox" type="checkbox" id="general_checkbox"></th>
			<th title="Asc">{{trans('label.id')}}</th>
			<th title="Asc">{{trans('label.name')}}</th>
			<th title="Asc">{{trans('label.sku')}}</th>
			<th title="Asc">{{trans('label.price')}}</th>
			<th title="Asc">{{trans('label.status')}}</th>
			<th title="Asc">{{trans('label.quantity')}}</th>
			<th title="Asc">{{trans('label.buy_times')}}</th>
			<th data-name="edit" title="edit">{{trans('label.edit')}}</th>
		</tr>
		{{--<tr class="filter">--}}
			{{--<td><input class="massive_checkbox" name="massive_checkbox" type="checkbox" value=""></td>--}}
			{{--<td><input class="grid-filter form-control input-sm" name="id" type="number" value=""></td>--}}
			{{--<td><input class="grid-filter form-control input-sm" name="name" type="text" value=""></td>--}}
			{{--<td><input class="grid-filter form-control input-sm" name="sku" type="text" value=""></td>--}}
			{{--<td>--}}
				{{--<input class="grid-filter form-control input-from input-sm" placeholder="From" min="0" name="price[from]" type="number" value="">--}}
				{{--<input class="grid-filter form-control input-sm" placeholder="To" min="0" name="price[to]" type="number" value="">--}}
			{{--</td>--}}
			{{--<td><input class="grid-filter form-control input-sm" name="status" type="number" value=""></td>--}}
			{{--<td>--}}
				{{--<input class="grid-filter form-control input-from input-sm" placeholder="From" min="0" name="quantity[from]" type="number" value="">--}}
				{{--<input class="grid-filter form-control input-sm" placeholder="To" min="0" name="quantity[to]" type="number" value="">--}}
			{{--</td>--}}
			{{--<td>--}}
				{{--<input class="grid-filter form-control input-from input-sm" placeholder="From" min="0" name="buy_times[from]" type="number" value="">--}}
				{{--<input class="grid-filter form-control input-sm" placeholder="To" min="0" name="buy_times[to]" type="number" value="">--}}
			{{--</td>--}}
			{{--<td></td>--}}
		{{--</tr>--}}
		</thead>
		<tbody>
			@foreach($products as $key => $val)
				<tr id="{{$val->id}}">
					<td><input class="massive_checkbox" name="massive_checkbox" type="checkbox" id="{{$val->id}}"></td>
					<td>{{$val->id}}</td>
					<td>{{$val->name}}</td>
					<td>{{$val->sku}}</td>
					<td>{{number_format($val->price)}}</td>
					@if($val->status==1)
						<td class="alert alert-success">{{trans('general.in_stock')}}</td>
					@else
						<td class="alert alert-danger">{{trans('general.out_of_stock')}}</td>
					@endif
					<td>{{$val->quantity}}</td>
					<td>{{$val->buy_times}}</td>
					<td><a href="edit/{{$val->id}}" title="edit"><i class="fa fa-edit"></i> </a> </td>
				</tr>
			@endforeach
			{!! $products->render() !!}

		</tbody>
	</table>