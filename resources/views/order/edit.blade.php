@extends("layout.layout")
@section("content")
    <section id="edit_section">
        <div class="container">
            @include('layout.left-sidebar-admin')
            <div class="col-sm-10">
                @include('layout.result')
                <div class="page-header">
                    <h2>{{trans('label.review_order')}}</h2>
                    <button type="submit" class="btn btn-default btn-lg btn_header">{{trans('label.save')}}</button>
                    <button type="button" class="btn btn-default btn-lg btn_header" id="btn-delete">{{trans('label.delete')}}</button>
                    <button type="button" class="btn btn-default btn-lg btn_header" id="btn-back">{{trans('label.back')}}</button>
                </div>
                <div class="row">
                    <!-- $order -->
                    <div class="col-lg-6">
                        <div class="panel panel-default order-info">
                            <div class="panel-heading">
                                <h3>{{trans('label.order_infomation')}}</h3>
                            </div>
                            <div class="panel-body form-horizontal">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">{{trans('label.created_at')}}</label>
                                    <div class="col-lg-8">
                                        <p class="form-control-static">{{$order['created_at']}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">{{trans('label.status')}}</label>
                                    <div class="col-lg-8">
                                        <p class="form-control-static">{{$order['status']}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>            <!--$customer-->
                    <div class="col-lg-6">
                        <div class="panel panel-default order-info">
                            <div class="panel-heading">
                                <h3>{{trans('label.customer_information')}}</h3>
                            </div>
                            <div class="panel-body form-horizontal">
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">{{trans('label.name')}}</label>
                                    <div class="col-lg-8">
                                        <p class="form-control-static">{{$order['name']}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 control-label">{{trans('label.email')}}</label>
                                    <div class="col-lg-8">
                                        <p class="form-control-static">{{$order['email']}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
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
                                        <span class="form-control-static">{{$order['name']}}</span>
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
                                        <span class="form-control-static">{{$order['district']}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 control-label">{{trans('label.province')}}</label>
                                    <div class="col-lg-8">
                                        <span class="form-control-static">{{$order['province']}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>{{trans('label.order_total')}}</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <label class="col-lg-4 control-label">{{trans('label.sub_price')}}</label>
                                    <div class="col-lg-8">
                                        <span class="form-control-static">{{number_format($order['sub_price'])}} đ</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 control-label">{{trans('label.tax')}}</label>
                                    <div class="col-lg-8">
                                        <span class="form-control-static">{{number_format($order['tax'])}} đ</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 control-label">{{trans('label.total_price')}}</label>
                                    <div class="col-lg-8">
                                        <span class="form-control-static">{{number_format($order['total_price'])}} đ</span>
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
                                <td class="image">{{trans('label.item')}}</td>
                                <td class="description">{{trans('label.description')}}</td>
                                <td class="price">{{trans('label.price')}}</td>
                                <td class="quantity">{{trans('label.quantity')}}</td>
                                <td class="total">{{trans('label.total')}}</td>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($order['items']))
                                @foreach($order['items'] as $key => $item)
                                    <tr>
                                        <td class="cart_product">
                                            <a href=""><img src="{{url($item['image_url']) or asset('/images/images.jpg')}}" alt=""></a>
                                        </td>
                                        <td class="cart_description">
                                            <h4><a href="">{{$item['name']}}</a></h4>
                                            <p>{{trans('label.sku')}}: {{$item['sku']}}</p>
                                            @if(!empty($item['option']))
                                                @foreach($item['option'] as $option)
                                                    <p>{{ $option['title'] . ": " . $option['value'] }}</p>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="cart_price">
                                            @if(isset($item['sale_price']))
                                                <div class="sale_line">
                                                    <p>{{number_format($item['sale_price'])}} đ</p>
                                                </div>
                                                <p class="sale_price">{{number_format($item['price'])}} đ</p>
                                            @else
                                                <p>{{number_format($item['price'])}} đ</p>
                                            @endif
                                        </td>
                                        <td class="cart_quantity">
                                            <div class="cart_quantity_button">
                                                <div class="cart_quantity_input">{{$item['quantity']}}</div>
                                            </div>
                                        </td>
                                        <td class="cart_total">
                                            <p class="cart_total_price">{{number_format($item['sub_total'])}}</p>
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
        $("#btn-delete").click(function(){
            var response = confirm("Bạn có chắc chắn muốn xóa đơn hàng này không?");
            if( response) {
                window.location.replace("{{URL::route('orders.delete',['id' => $order['id']] )}}");
            }
        });
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
