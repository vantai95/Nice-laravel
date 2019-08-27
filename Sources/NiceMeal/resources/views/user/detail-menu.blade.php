@extends('layouts.app')
@section('content')
    <!-- Content-->
    <div class="md-content">

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
                                            <div class="rating__rating" title="4.5" count="4.5"><span
                                                        class="rating__icon" style="width: 79%;"></span></div>
                                            <span class="rating__count"><a href="#">(68 review)</a></span>
                                        </div><!-- End / rating -->
                                        <span class="rating"></span>
                                    </div>
                                    <div class="listbox__body">
                                        <h2 class="listbox__name">McDonald's<span class="btn-like"><i
                                                        class="fa fa-heart-o"></i></span>
                                        </h2>
                                        <p class="listbox__text">Pizza & Pasta, Burger & Sandwich, Snack & Fast food</p>
                                        <ul class="listbox__list">
                                            <li><span class="text-success">Open Now</span></li>
                                            <li><span><i class="fa fa-car"></i>50.000đ</span></li>
                                            <li><span><i class="fa fa-map-marker"></i>Quận 1</span></li>
                                            <li><span><i class="fa fa-cart-plus"></i>Min: 100.000đ</span></li>
                                            <li><span><i class="fa fa-check-square-o"></i>Pick up</span></li>
                                            <li class="disable"><span><i class="fa fa-check-square-o"></i>Online Payment</span></li>
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
                        <div class="hero__left"><a href="#"><i class="fa fa-long-arrow-left"></i>Back to restaurants
                                list</a></div>
                        <div class="hero__center">
                            <form class="hero__search">
                                <input class="hero__input" placeholder="Search (Search Food name)"/><i
                                        class="fa fa-search"></i>
                            </form>
                        </div>
                        <div class="hero__right">
                            <div class="hero__card"><a class="add-to-order click-show-popup" href="popup-order.html"
                                                       data-effect="mfp-zoom-in"><i
                                            class="fa fa-shopping-cart"></i><span class="cart-number">01</span></a>
                            </div>
                            <span class="hero__total">Total: <span>1.500.000đ</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End / hero -->


        <!-- Section -->
        <section class="md-section">
            <div class="container">
                <div class="row sticky-wrap">
                    <div class="col-lg-3  sticky">
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
                    <div class="col-lg-6 ">

                        <!-- nav-menu -->
                        <nav class="nav-menu">
                            <div class="nav-menu__toggle"><span class="toggle__text" data-text="Hide">Show </span>menu
                            </div>
                            <ul class="nav-menu__list">
                                <li class="current"><a href="detail-menu.html">Menu</a></li>
                                <li><a href="promotion.html">Promotions (3)</a></li>
                                <li><a href="review.html">Reviews (100)</a></li>
                                <li><a href="new.html">News (69)</a></li>
                                <li><a href="detail-info.html">Info</a></li>
                            </ul>
                        </nav><!-- End / nav-menu -->

                        <div class="textbox">
                            <p>Welcome everyone. please try our menu, we have many choices for you to have a
                                nicemeal.</p>
                            <p>To avoid wasting and protect environment, please choose your plastic tools that you need
                                in the menu .</p>
                        </div>
                        <div class="category-wrapper">

                            <!-- category -->
                            <div class="category" id="section-1">
                                <div class="category__header"><span class="category-to-top click-to-top"><i
                                                class="fa fa-angle-double-up"></i>top</span>
                                    <h4 class="category__cat">Breakfast / Lunch / Dinner</h4>
                                </div>
                                <div class="category__content">

                                    <!-- listing-01 -->
                                    <div class="listing-01" href="detail-menu-switch.html">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="detail-menu-switch.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->

                                </div>
                            </div><!-- End / category -->


                            <!-- category -->
                            <div class="category" id="section-2">
                                <div class="category__header"><span class="category-to-top click-to-top"><i
                                                class="fa fa-angle-double-up"></i>top</span>
                                    <h4 class="category__cat">Breakfast / Lunch / Dinner</h4>
                                </div>
                                <div class="category__content">

                                    <!-- listing-01 -->
                                    <div class="listing-01" href="detail-menu-switch.html">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="detail-menu-switch.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->

                                </div>
                            </div><!-- End / category -->


                            <!-- category -->
                            <div class="category" id="section-3">
                                <div class="category__header"><span class="category-to-top click-to-top"><i
                                                class="fa fa-angle-double-up"></i>top</span>
                                    <h4 class="category__cat">Breakfast / Lunch / Dinner</h4>
                                </div>
                                <div class="category__content">

                                    <!-- listing-01 -->
                                    <div class="listing-01" href="detail-menu-switch.html">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="detail-menu-switch.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->


                                    <!-- listing-01 -->
                                    <div class="listing-01">
                                        <div class="listing-01__media"><a href="#"><img src="assets/img/listing/1.png"
                                                                                        alt=""></a></div>
                                        <div class="listing-01__body">
                                            <h2 class="listing-01__name"><a href="#">The food name #3</a></h2>
                                            <p>Burgers, Pizza, Sandwiches</p>
                                        </div>
                                        <div class="listing-01__footer"><span>100.00đ</span><a
                                                    class="btn-add-to-cart click-show-popup"
                                                    href="popup-add-to-card.html" data-effect="mfp-zoom-in"><i
                                                        class="fa fa-plus-circle"></i></a></div>
                                    </div><!-- End / listing-01 -->

                                </div>
                            </div><!-- End / category -->

                        </div>
                    </div>
                    <div class="col-lg-3  sticky">
                        <div class="sidebar-right">

                            <!-- widget -->
                            <div class="widget">
                                <h2 class="widget__title">Min order: <span class="price">100.000đ</span></h2>
                                <div class="widget__content">

                                    <!-- widget-order -->
                                    <div class="widget-order">
                                        <div class="widget-order__item"><span
                                                    class="widget-order__title">Choose service</span>
                                            <div class="widget-order__check_wrap">

                                                <!-- checkbox -->
                                                <div class="checkbox">
                                                    <label class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                               checked="checked"/><span
                                                                class="custom-control-indicator"></span><span
                                                                class="custom-control-description">Delivery</span>
                                                    </label>
                                                </div><!-- End / checkbox -->


                                                <!-- checkbox -->
                                                <div class="checkbox">
                                                    <label class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"/><span
                                                                class="custom-control-indicator"></span><span
                                                                class="custom-control-description">Pick up</span>
                                                    </label>
                                                </div><!-- End / checkbox -->

                                            </div>
                                            <span class="widget-order__title">Choose payment</span>
                                            <div class="widget-order__check_wrap">

                                                <!-- checkbox -->
                                                <div class="checkbox">
                                                    <label class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                               checked="checked"/><span
                                                                class="custom-control-indicator"></span><span
                                                                class="custom-control-description">COD</span>
                                                    </label>
                                                </div><!-- End / checkbox -->


                                                <!-- checkbox -->
                                                <div class="checkbox">
                                                    <label class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"/><span
                                                                class="custom-control-indicator"></span><span
                                                                class="custom-control-description">Pay Online</span>
                                                    </label>
                                                </div><!-- End / checkbox -->

                                            </div>
                                        </div>
                                        <div class="widget-order__item">
                                            <div class="widget-order__product">
                                                <div class="widget-order__product_list">
                                                    <input class="product__number" type="text" value="10"/><span
                                                            class="product__period">x</span>
                                                    <h4 class="procude__name">Chicken</h4>
                                                    <div class="product__footer"><span
                                                                class="product__price">100.00đ</span><span
                                                                class="btn-del-product"><i
                                                                    class="fa fa-times-circle"></i></span></div>
                                                </div>
                                                <div class="widget-order__product_list">
                                                    <input class="product__number" type="text" value="10"/><span
                                                            class="product__period">x</span>
                                                    <h4 class="procude__name">Cali Chicken Bacon Ranch</h4>
                                                    <div class="product__footer"><span
                                                                class="product__price">100.00đ</span><span
                                                                class="btn-del-product"><i
                                                                    class="fa fa-times-circle"></i></span></div>
                                                </div>
                                                <div class="widget-order__product_list">
                                                    <input class="product__number" type="text" value="5"/><span
                                                            class="product__period">x</span>
                                                    <h4 class="procude__name">Chicken</h4>
                                                    <div class="product__footer"><span
                                                                class="product__price">100.00đ</span><span
                                                                class="btn-del-product"><i
                                                                    class="fa fa-times-circle"></i></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget-order__item">
                                            <div class="widget-order__total">
                                                <p>Subtotal:<span>1.500.000đ</span></p>
                                                <p>Delivery fee:<span>10đ</span></p>
                                                <p class="bigtotal">Total:<span>1.500.000đ</span></p>
                                                <textarea name="" cols="30" rows="10"
                                                          placeholder="Order Note:"></textarea>
                                            </div>
                                        </div>
                                        <div class="widget-order__item">
                                            <div class="widget-order__btn_order">
                                                <a class="md-btn md-btn--danger md-btn--sm md-btn--outline-danger "
                                                   href="#">Full Detail
                                                </a>
                                                <a class="md-btn md-btn--danger md-btn--sm " href="#">ORDER MORE
                                                </a>
                                            </div>
                                        </div>
                                    </div><!-- End / widget-order -->

                                </div>
                            </div><!-- End / widget -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End / Section -->

    </div>
    <!-- End / Content-->
@endsection
@section('extra_scripts')

@endsection
