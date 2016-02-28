@extends("layout.layout")
@section("content")
    <section id="edit_section">
        <div class="container">
            @include('layout.left-sidebar-admin')
            <div class="col-sm-10">
                <h2 class="page-header">{{trans('label.edit_order')}}</h2>
                @include('layout.result')
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
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>Billing Address
                                    <a title="Edit address" href="{{URL::route('orders.edit-address')}}">
                                        <i class="fa fa-edit right"></i>
                                    </a>
                                </h3>
                            </div>
                            <div class="panel-body address-form">
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
                                        <span class="form-control-static">{{$order['sub_price']}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 control-label">{{trans('label.tax')}}</label>
                                    <div class="col-lg-8">
                                        <span class="form-control-static">{{$order['tax']}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-lg-4 control-label">{{trans('label.total_price')}}</label>
                                    <div class="col-lg-8">
                                        <span class="form-control-static">{{$order['total_price']}}</span>
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
                                            <a href=""><img src="{{$item['image_url'] or ''}}" alt=""></a>
                                        </td>
                                        <td class="cart_description">
                                            <h4><a href="">{{$item['name']}}</a></h4>
                                            <p>{{trans('label.sku')}}: {{$item['sku']}}</p>
                                        </td>
                                        <td class="cart_price">
                                            @if(isset($item['sale_price']))
                                                <div class="sale_line">
                                                    <p>{{$item['sale_price']}} đ</p>
                                                </div>
                                                <p class="sale_price">{{$item['price']}} đ</p>
                                            @else
                                                <p>{{$item['price']}} đ</p>
                                            @endif
                                        </td>
                                        <td class="cart_quantity">
                                            <div class="cart_quantity_button">
                                                <div class="cart_quantity_input">{{$item['quantity']}}</div>
                                            </div>
                                        </td>
                                        <td class="cart_total">
                                            <p class="cart_total_price">{{$item['sub_total']}}</p>
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
    <script type="text/javascript">

    </script>
@endsection
