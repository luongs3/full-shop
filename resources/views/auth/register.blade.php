@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('label.register')}}</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> {{trans('auth.access_error')}}<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">{{trans('label.name')}}</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="phone_number">{{trans('label.phone_number')}}</label>
							<div class="col-md-6">
								<input type="text" id="phone_number" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="address">{{trans('label.address')}}</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="address" name="address" value="{{ old('phone_number') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"> {{trans('label.email')}}<span class="required"> *</span></label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
							</div>
						</div>
						@if(isset($is_admin))
							<div class="form-group">
								<label class="col-md-4 control-label" for="role"> {{trans('label.role')}}</label>
								<div class="col-md-6">
									<select class="form-control" id="role" name="role">
										<option value="user" selected>{{trans('general.user')}}</option>
										<option value="admin">{{trans('general.admin')}}</option>
									</select>
								</div>
							</div>
						@endif
						<div class="form-group">
							<label class="col-md-4 control-label">{{trans('label.password')}}<span class="required"> *</span></label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">{{trans('label.confirm_password')}}</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									{{trans('label.register')}}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			{{--log in with facebook or google account--}}
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('label.register_via_facebook_or_google_account')}}</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">{{trans('label.name')}}</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="phone_number">{{trans('label.phone_number')}}</label>
							<div class="col-md-6">
								<input type="text" id="phone_number" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="address">{{trans('label.address')}}</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="address" name="address" value="{{ old('phone_number') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label"> {{trans('label.email')}}<span class="required"> *</span></label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
							</div>
						</div>
						@if(isset($is_admin))
							<div class="form-group">
								<label class="col-md-4 control-label" for="role"> {{trans('label.role')}}</label>
								<div class="col-md-6">
									<select class="form-control" id="role" name="role">
										<option value="user" selected>{{trans('general.user')}}</option>
										<option value="admin">{{trans('general.admin')}}</option>
									</select>
								</div>
							</div>
						@endif
						<div class="form-group">
							<label class="col-md-4 control-label">{{trans('label.password')}}<span class="required"> *</span></label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">{{trans('label.confirm_password')}}</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									{{trans('label.register')}}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
