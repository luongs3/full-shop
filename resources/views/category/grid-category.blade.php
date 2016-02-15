<table id="myTable" class="table table-bordered table-striped table-responsive">
		<thead>
		<tr role="row">
			<th></th>
			<th title="Asc">{{trans('label.id')}}</th>
			<th title="Asc">{{trans('label.name')}}</th>
			<th data-name="edit" title="edit">{{trans('label.edit')}}</th>
		</tr>
		</thead>
		<tbody>
			@foreach($categories as $key => $val)
				<tr id="{{$val->id}}">
					<td><input class="massive_checkbox" name="massive_checkbox" type="checkbox" id="{{$val->id}}"></td>
					<td>{{$val->id}}</td>
					<td>{{$val->name}}</td>
					<td><a href="edit/{{$val->id}}" title="edit"><i class="fa fa-edit"></i> </a> </td>
				</tr>
			@endforeach
			{!! $categories->render() !!}

		</tbody>
	</table>
<script>

</script>
