@extends("layout.layout")
@section("content")
    <section id="edit_section">
        <div class="container">
            @include('layout.left-sidebar')
            <div class="col-sm-10">
                @include('layout.result')
                <div class="page-header">
                    <h2>{{trans('label.user_information')}}</h2>
                    <button type="button" class="btn btn-default btn-lg btn_header" id="btn-back">{{trans('label.back')}}</button>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default order-info">
                            <div class="panel-heading">
                                <h3>{{trans('label.user_information')}}</h3>
                            </div>
                            <div class="panel-body form-horizontal">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">{{trans('label.name')}}</label>
                                    <div class="col-lg-8">
                                        <p class="form-control-static">{{$user['name']}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">{{trans('label.email')}}</label>
                                    <div class="col-lg-8">
                                        <p class="form-control-static">{{$user['email']}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default" id="{{$user['id']}}">
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
                                        <span class="form-control-static">{{$user['name']}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 control-label">{{trans('label.address')}}</label>
                                    <div class="col-lg-8">
                                        <span class="form-control-static">{{$user['address']}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 control-label">{{trans('label.district')}}</label>
                                    <div class="col-lg-8">
                                        <span class="form-control-static">{{$user['district']}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 control-label">{{trans('label.province')}}</label>
                                    <div class="col-lg-8">
                                        <span class="form-control-static">{{$user['province']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive cart_info">
                        <table class="table table-condensed">
                            <thead>
                            <tr class="cart_menu">
                                <td class="order-id">{{trans('label.order_id')}}</td>
                                <td class="created-at">{{trans('label.created_at')}}</td>
                                <td class="items">{{trans('label.items')}}</td>
                                <td class="total-price">{{trans('label.total_price')}}</td>
                                <td class="status">{{trans('label.status')}}</td>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($user['orders']))
                                @foreach($user['orders'] as $key => $item)
                                    <tr>
                                        <td class="order-id">
                                            <a href=""><img src="{{$item['order_id'] or ''}}" alt=""></a>
                                        </td>
                                        <td class="created-at">
                                            <span>{{$item['created-at']}}</span>
                                        </td>
                                        <td class="items">
                                            @foreach($item['items'] as $item1)
                                                <div>{{$item1['name']}}</div>
                                            @endforeach
                                        </td>
                                        <td class="total-price">
                                            <p>{{number_format($item['total-price'])}} đ</p>
                                        </td>
                                        <td class="status">
                                            <span>{{$item['status']}}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div></div>
            </div>
        </div>
    </section>
    <script>
        $("#btn-back").click(function(){
            window.history.back();
        });
        function editAddress(element){
            var panel = $(element).parents('.panel');
            $.ajax({
                type: "GET",
                url: "/orders/load-address-form/"+panel.attr('id'),
                success: function(result,status){
                    panel.hide();
                    panel.parent().html(result).show();
                    panel.remove();
                }

            });
        }
        function updateAddress(element){
            var panel = $(element).parents('.panel');
            var form = panel.find('form');
            var arr = {};
            arr['id'] = panel.attr('id');
            arr['name'] = form.find('input[name="name"]').val();
            arr['email'] = form.find('input[name="email"]').val();
            arr['address'] = form.find('input[name="address"]').val();
            arr['phone_number'] = form.find('input[name="phone_number"]').val();
            arr['province'] = form.find('select[name="province"]').val();
            arr['district'] = form.find('select[name="district"]').val();
            $.ajax({
                type: "POST",
                data: {data: JSON.stringify(arr),
                    _token: "{{csrf_token()}}"},
                url: "/orders/update-address-form",
                success: function(result,status){
                    panel.hide();
                    panel.parent().html(result).show();
                    panel.remove();
                }
            });
        }
    </script>
@endsection
