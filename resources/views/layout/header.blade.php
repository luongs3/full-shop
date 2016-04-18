
<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href=""><i class="fa fa-phone"></i> +84 164 270 1517 </a></li>
                            <li><a href=""><i class="fa fa-envelope"></i> luongr3@gmail.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href=""><i class="fa fa-facebook"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa fa-linkedin"></i></a></li>
                            <li><a href=""><i class="fa fa-dribbble"></i></a></li>
                            <li><a href=""><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="logo pull-left">
                        <a href="{{URL::route('index')}}"><img src="/images/home/logo.png" alt="" /></a>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            @if(Auth::check())
                                <li><a href="#"><span class="hello_user">{{trans('general.hello')}}: </span>{{Auth::user()->email}}</a></li>
                            @endif
                                <li><a href=""><i class="fa fa-user"></i> Account</a></li>
                            <li><a href=""><i class="fa fa-star"></i> Wishlist</a></li>
                            <li><a href="checkout"><i class="fa fa-crosshairs"></i> Checkout</a></li>
                            <li><a href="cart"><i class="fa fa-shopping-cart"></i> Cart</a></li>
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
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{URL::route('index')}}">Home</a></li>
                            <li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="shop">Products</a></li>
                                    <li><a href="product-details">Product Details</a></li>
                                    <li><a href="checkout">Checkout</a></li>
                                    <li><a href="cart">Cart</a></li>
                                    <li><a href="login">Login</a></li>
                                </ul>
                            </li>
                            <li class="dropdown"><a href="#" class="active">Blog<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="{{URL::route('blog')}}" class="active">Blog List</a></li>
                                    <li><a href="blog-single">Blog Single</a></li>
                                </ul>
                            </li>
                            <li><a href="{{URL::route('404')}}">404</a></li>
                            <li><a href="contact-us">Contact</a></li>
                            @if(Auth::check() && Auth::user()->role=="admin")
                                <li><a href="{{URL::route('manage')}}">{{trans('label.manage')}}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-sm-5">
                    <form action="{{URL::route('index.search')}}" method="get">
                        <div class="search_box pull-right">
                            <input type="text" class="form-control" id="search" placeholder="Search"/>
                            <button class="btn btn-default" id="btn-search" type="submit">{{trans('label.find')}}</button>
                            <div id="result">Fuck</div>
                        </div>
                    </form>
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