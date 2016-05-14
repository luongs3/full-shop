@extends("layout.layout")
@section("content")
    <section id="edit_section">
        <div class="container">
            <div class="row">
                @include('layout.left-sidebar-admin')
                    <div class="col-sm-10">
                        <div class="row">
                            <h3 class="page-header">{{trans('label.add_new_product')}}</h3>
                            @include('layout.result')
                            <form  class="form-horizontal" enctype="multipart/form-data" action="{{URL::route('products.save')}}" method="POST" role="form" >
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="name">{{trans('label.name')}}<span class="required"> *</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="name" type="text" name="name" required placeholder="Áo dài" value="{{old('name')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sku">{{trans('label.sku')}}<span class="required"> *</span></label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="sku" type="text" name="sku" required placeholder="ao-dai-nhap-khau" value="{{old('sku') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="price">{{trans('label.price')}}</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="price" type="text" name="price" placeholder="100000" maxlength="8" value="{{old('price') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="status">{{trans('label.status')}}</label>
                                        <div class="col-sm-9">
                                            @if(old('status'))
                                                <input class="form-control" type="checkbox" id="status" name="status" checked>
                                            @else
                                                <input class="form-control" type="checkbox" id="status" name="status">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="description">{{trans('label.description')}}</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control summernote" id="description" rows="5" name="description" placeholder="Loại áo cổ truyền của phụ nữ Việt Nam">{{old('description')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="category">{{trans('label.category')}}<span class="required"> *</span></label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="category" required name="category_id">
                                                <option value="">{{trans('label.category')}}</option>
                                                @if(!empty($categories))
                                                    @foreach($categories as $key => $val)
                                                        <option value="{{$val['id']}}">{{$val['name']}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sale_price">{{trans('label.sale_off')}}</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="number" name="sale_price" maxlength="8" placeholder="Giá sale off" value="{{old('sale_off')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="ratio">{{trans('label.ratio_sale_off')}}</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="ratio" type="number" name="ratio" min="0" max="100" placeholder="40" value="{{old('sale_off')}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="quantity">{{trans('label.quantity')}}</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="number" name="quantity" placeholder="Số lượng" value="{{old('quantity')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group" id="image-preview">
                                        <label class="control-label" id="image-label" for="image">{{trans('label.image')}}</label>
                                        <input class="hidden" id="image_hidden" name="image_hidden" value="">
                                        <input class="form-control" id="image-upload" type="file"  name="image" value="{{old('image_id')}}">
                                        <img class="img img-responsive" id="image_url" src="{{old('image_url')}}">
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-default btn-lg">{{trans('label.save')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200                 // set editor height
            });
            function readURL(input) {

                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#image_url').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#image-upload").change(function(){
                readURL(this);
            });
        });
    </script>
@endsection
