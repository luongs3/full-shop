    <div class="panel panel-default" id="{{$address['id']}}">
        <div class="panel-heading">
            <h3>{{trans("label.billing_address")}}
                <a class="edit-address-form" title="Update Address" onclick="updateAddress(this)">
                    <i class="fa fa-check-square-o right"></i>
                </a>
            </h3>
        </div>

        <div class="panel-body address-form">
            <div class="form-one">
                <form method="post" action="{{URL::route('post-checkout')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" name="name" placeholder="{{trans('label.name')}}" value="{{$address['name'] or ''}}">
                    <input type="text" name="email" placeholder="{{trans('label.email')}}*" value="{{$address['email'] or ''}}" required>
                    <input type="text" name="address" placeholder="{{trans('label.address')}}*" value="{{$address['address'] or ''}}" required>
                    <select name="province" id="province">
                        <option value="">{{trans('label.choose_province')}}</option>
                        @if(isset($provinces))
                            @foreach($provinces as $val)
                                <option value="{{$val['id']}}" @if($val['id']==array_get($address,'province')) selected @endif>{{$val['name']}}</option>
                            @endforeach
                        @endif
                    </select>
                    <select name="district" id="district">
                        <option value="">{{trans('label.choose_district')}}</option>
                        @if(isset($districts))
                            @foreach($districts as $val)
                                <option value="{{$val['id']}}" @if($val['id']==array_get($address,'district')) selected @endif>{{$val['name']}}</option>
                            @endforeach
                        @endif
                    </select>
                    <input type="text" name="phone_number" placeholder="{{trans('label.phone_number')}}" value="{{$address['phone_number'] or ''}}">
                </form>
            </div>

        </div>

    </div>
<script>
    $('#district').click(function(){
        if($(this).find('option').length==1){
            alert("{{trans("message.choose_province_first")}}");
            return false;
        }
    });
    $("#province").change(function(){
        $.ajax({
            type: "GET",
            url: "/select-districts/"+$(this).val(),
            success: function(data){
                var distrcts = $('#district');
                distrcts.empty();
                distrcts.append('<option value="">'+'{{trans("label.choose_district")}}'+'</option>');
                for(i=0; i<data.length;i++){
                    distrcts.append('<option value='+data[i].id+'>'+data[i].name+'</option>');
                }
            }
        })
    })
</script>
