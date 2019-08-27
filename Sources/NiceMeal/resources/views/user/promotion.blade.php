@endsection
@section('extra_scripts')
@endsection

@include('user.social-tools')

<!-- hero -->
<section class="hero" style="background-image:url(&quot;assets/img/bg/1.jpg&quot;);">
    <div class="md-tb">
        <div class="md-tb__cell">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 ">
                        <div class="listbox">
                            <div class="listbox__media"><a href="#"><img src="assets/img/listbox/1.jpg"/></a>

                                <!-- rating -->
                                <div class="rating"><span class="rating__point">4.5</span>
                                    <div class="rating__rating" title="4.5" count="4.5"><span class="rating__icon"
                                                                                              style="width: 69%;"></span>
                                    </div>
                                    <span class="rating__count"><a href="#">(68 review)</a></span>
                                </div><!-- End / rating -->
                                <span class="rating"></span>
                            </div>
                            <div class="listbox__body">
                                <h2 class="listbox__name">McDonald's<span class="btn-like"><i class="fa fa-heart-o"></i></span>
                                </h2>
                                <p class="listbox__text">Pizza & Pasta, Burger & Sandwich, Snack & Fast food</p>
                                <ul class="listbox__list">
                                    <li><span class="text-success">Open Now</span></li>
                                    <li><span><i class="fa fa-car"></i>50.000đ</span></li>
                                    <li><span><i class="fa fa-map-marker"></i>Quận 1</span></li>
                                    <li><span><i class="fa fa-cart-plus"></i>Min: 100.000đ</span></li>
                                    <li><span><i class="fa fa-check-square-o"></i>Pick up</span></li>
                                    <li class="disable"><span><i class="fa fa-check-square-o"></i>Online Payment</span>
                                    </li>
                                    <li class="disable"><span><i class="fa fa-check-square-o"></i>Delivery</span></li>
                                    <li><span><i class="fa fa-check-square-o"></i>COD</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero__menu">
        <div class="container">
            <div class="hero__menu_wrap">
                <div class="hero__left"><a href="#"><i class="fa fa-long-arrow-left"></i>Back to restaurants list</a>
                </div>
                <div class="hero__center">
                    <form class="hero__search">
                        <input class="hero__input" placeholder="Search (Search Food name)"/><i class="fa fa-search"></i>
                    </form>
                </div>
                <div class="hero__right">
                    <div class="hero__card"><a class="add-to-order click-show-popup" href="popup-order.html"
                                               data-effect="mfp-zoom-in"><i class="fa fa-shopping-cart"></i><span
                                    class="cart-number">01</span></a></div>
                    <span class="hero__total">Total: <span>1.500.000đ</span></span>
                </div>
            </div>
        </div>
    </div>
</section><!-- End / hero -->


<!-- Section -->
<section class="md-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-9  col-lg-push-3">
                <div class="main-content">

                    <!-- nav-menu -->
                    <nav class="nav-menu">
                        <div class="nav-menu__toggle"><span class="toggle__text" data-text="Hide">Show </span>menu</div>
                        <ul class="nav-menu__list">
                            <li class="current"><a href="detail-menu.html">Menu</a></li>
                            <li><a href="promotion.html">Promotions (3)</a></li>
                            <li><a href="review.html">Reviews (100)</a></li>
                            <li><a href="new.html">News (69)</a></li>
                            <li><a href="detail-info.html">Info</a></li>
                        </ul>
                    </nav><!-- End / nav-menu -->


                    <!-- promotions -->
                    <div class="promotions">
                        <ul class="promotions__list">
                            <li><a href="#">
                                    <h3 class="promotions__title">Free soft drink</h3>
                                    <p class="promotions__text">Free 1 soft drink for each item with price's over
                                        99.000</p></a></li>
                            <li><a href="#">
                                    <h3 class="promotions__title">Discount 5%</h3>
                                    <p class="promotions__text">Discount 5% for each order with total from 500.000vnđ to
                                        999.000vnđ</p></a></li>
                            <li><a href="#">
                                    <h3 class="promotions__title">Discount 10%</h3>
                                    <p class="promotions__text">Discount 5% for each order with total over
                                        999.000vnđ</p></a></li>
                        </ul>
                    </div><!-- End / promotions -->

                </div>
            </div>
            <div class="col-lg-3  col-lg-pull-9">
                <div class="sidebar-left">

                    <!-- widget -->
                    <div class="widget">
                        <h2 class="widget__title">Choose Cuisine</h2>
                        <div class="widget__content">

                            <!-- widget-categories -->
                            <ul class="widget-categories">
                                <li><a href="#section-1">Breakfast / Lunch / Dinner</a></li>
                                <li><a href="#section-2">Breakfast / Lunch / Dinner</a></li>
                                <li><a href="#section-3">Breakfast / Lunch / Dinner</a></li>
                            </ul><!-- End / widget-categories -->

                        </div>
                    </div><!-- End / widget -->

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End / Section -->

@endsection
@section('extra_scripts')
@endsection