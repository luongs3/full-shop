<div class="panel panel-default" id="{{$order['id']}}">
    <div class="panel-heading">
        <h3>{{trans("label.billing_address")}}
            <a class="edit-address-form" title="Edit Address" onclick="editAddress(this)">
                <i class="fa fa-edit right"></i>
            </a>
        </h3>
    </div>
    <div class="panel-body address-form">
        <div class="row">
            <label class="col-lg-4 control-label">{{trans('label.guest')}}</label>
            <div class="col-lg-8">
                <span class="form-control-static">{{$order['name'] or ''}}</span>
            </div>
        </div>
        <div class="row">
            <label class="col-lg-4 control-label">{{trans('label.address')}}</label>
            <div class="col-lg-8">
                <span class="form-control-static">{{$order['address']}}</span>
            </div>
        </div>
        <div class="row">
            <label class="col-lg-4 control-label">{{trans('label.district')}}</label>
            <div class="col-lg-8">
                <span class="form-control-static">{{$order['district'] or ''}}</span>
            </div>
        </div>
        <div class="row">
            <label class="col-lg-4 control-label">{{trans('label.province')}}</label>
            <div class="col-lg-8">
                <span class="form-control-static">{{$order['province'] or ''}}</span>
            </div>
        </div>
    </div>
</div>
