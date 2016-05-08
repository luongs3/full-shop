
<header id="header"><!--header-->
    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="logo pull-left">
                        <a href="{{URL::route('index')}}"><img src="/images/home/logo.png" alt="" /></a>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="col-sm-4">
                        <form action="{{URL::route('index.search')}}" method="get">
                            <div class="search_box pull-right">
                                <input type="text" class="form-control" id="search" placeholder="Search"/>
                                <div id="result"></div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                                @if(Auth::check())
                                    <li><a href="{{URL::route('users')}}"><span class="hello_user">{{trans('general.hello')}}: </span>{{Auth::user()->email}}</a></li>
                                @endif
                                @if(Auth::check() && Auth::user()->role=="admin")
                                    <li><a href="{{URL::route('manage')}}">{{trans('label.manage')}}</a></li>
                                @endif
                                <li><a href="{{URL::route('blog')}}"><i class="fa fa-crosshairs"></i>{{trans('label.blog')}}</a></li>
                                <li><a href="{{URL::route('cart')}}"><i class="fa fa-shopping-cart"></i> {{trans('label.shopping_cart')}}</a></li>
                                @if(Auth::check())
                                    <li><a href="{{URL::route('auth.logout')}}"><i class="fa fa-unlock"></i> {{trans('label.logout')}}</a></li>
                                @else
                                    <li><a href="{{URL::route('auth.login')}}"><i class="fa fa-lock"></i> {{trans('label.login')}}</a></li>
                                    <li><a href="{{URL::route('auth.register')}}"><i class="fa fa-user"></i> {{trans('label.register')}}</a></li>
                                @endif
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                </div>

            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->
<script>
    $(document).ready(function(){
        // On Search Submit and Get Results
        function search() {
            $.ajax({
                type: "GET",
                url: "/index/search/"+$('input#search').val(),
//                data: {key: $('input#search').val()},
                cache: false,
                success: function(data){
//                    console.log(data);
                    $("div#result").fadeIn().html(data);
                }
            });
        }
        $("input#search").keyup(function(e) {
            // Set Timeout
        clearTimeout($.data(this, 'timer'));
            // Do Search
            if ($(this).val().length>1) {
                $(this).data('timer', setTimeout(search,200));
            }
        });
    $("input#search").on('focusout',function(){
        $("div#result").fadeOut();
    });
    });
</script>