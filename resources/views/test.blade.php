    {{Session::get('error')}}<br>
    {{old('name')}}<br>
    {{old('description')}}<br>
    {{$name or "not name"}}<br>
    {{$description or "not sku"}}<br>
    @if(Session::has('category'))
        AAAAAAAAAAAAAAAAa
            <div>{{Session::get('category')->name}}</div>
            <div>{{Session::get('category')->description}}</div>
    @endif
    @if(isset($category))
        CATEGORY<br>
            <div>{{$category->name}}</div>
            <div>{{$category->description}}</div>
    @endif
