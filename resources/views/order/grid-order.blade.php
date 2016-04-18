<table id="order-table" class="table table-bordered table-striped table-responsive table-grid">
		<thead>
		<tr role="row">
			<th><input class="general_checkbox" name="general_checkbox" type="checkbox" id="general_checkbox"></th>
			<th title="Asc">{{trans('label.id')}}</th>
			<th title="Asc">{{trans('label.customer_name')}}</th>
			<th title="Asc">{{trans('label.customer_email')}}</th>
			<th title="Asc">{{trans('label.total_price')}}</th>
			<th title="Asc">{{trans('label.status')}}</th>
			<th title="Asc">{{trans('label.created_at')}}</th>
			{{--<th title="Asc">{{trans('label.updated_at')}}</th>--}}
			<th data-name="edit"title="edit">{{trans('label.view')}}</th>
		</tr>
		</thead>
		<tbody>
			@foreach($orders as $key => $val)
				<tr id="{{$val->id}}">
					<td id="wam"><input class="massive_checkbox" name="massive_checkbox" type="checkbox" id="{{$val->id}}"></td>
					<td>{{$val->id}}</td>
					<td>{{$val->name}}</td>
					<td>{{$val->email}}</td>
					<td>{{number_format($val->total_price)}}</td>
					<td class="status">
						<select name="status">
							<option value="SUCCESS" @if($val->status=='SUCCESS') selected @endif>{{trans('general.success')}}</option>
							<option value="CANCEL" @if($val->status=='CANCEL') selected @endif>{{trans('general.cancel')}}</option>
							<option value="PENDING" @if($val->status=='PENDING') selected @endif>{{trans('general.pending')}}</option>
							<option value="PAID" @if($val->status=='PAID') selected @endif>{{trans('general.paid')}}</option>
							<option value="REFUND" @if($val->status=='REFUND') selected @endif>{{trans('general.refund')}}</option>
						</select>
					</td>
					<td>{{$val->created_at}}</td>
					{{--<td>{{$val->updated_at}}</td>--}}
					<td><a href="edit/{{$val->id}}" title="{{trans('general.view')}}"><i class="fa fa-edit"></i> </a> </td>
				</tr>
			@endforeach
			{!! $orders->render() !!}

		</tbody>
	</table>
<script>

</script>
