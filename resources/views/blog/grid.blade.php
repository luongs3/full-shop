<table id="category-table" class="table table-bordered table-striped table-responsive table-grid">
		<thead>
		<tr role="row">
			<th><input class="general_checkbox" name="general_checkbox" type="checkbox" id="general_checkbox"></th>
			<th title="Asc">{{trans('label.id')}}</th>
			<th title="Asc">{{trans('label.title')}}</th>
			<th title="Asc">{{trans('label.author')}}</th>
			<th title="Asc">{{trans('label.active')}}</th>
			<th title="Asc">{{trans('label.created_at')}}</th>
			<th data-name="edit" title="edit">{{trans('label.edit')}}</th>
		</tr>
		</thead>
		<tbody>
			@foreach($posts as $key => $val)
				<tr id="{{$val->id}}">
					<td><input class="massive_checkbox" name="massive_checkbox" type="checkbox" id="{{$val->id}}"></td>
					<td>{{$val->id}}</td>
					<td>{{$val->title}}</td>
					<td>{{$val->user_name}}</td>
					@if($val->active==1)
						<td class="alert alert-success">{{trans('general.active')}}</td>
					@else
						<td class="alert alert-danger">{{trans('general.deactivate')}}</td>
					@endif
					<td>{{$val->created_at}}</td>
					<td><a href="edit/{{$val->id}}" title="edit"><i class="fa fa-edit"></i> </a> </td>
				</tr>
			@endforeach
			{!! $posts->render() !!}

		</tbody>
	</table>

