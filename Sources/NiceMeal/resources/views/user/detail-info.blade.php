@extends('layouts.app')
@section('content')
    <!-- Content-->
    <div class="md-content">

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
                                                        class="rating__icon" style="width: 74%;"></span></div>
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
                                            <li class="disable"><span><i class="fa fa-check-square-o"></i>Online Payment</span>
                                            </li>
                                            <li class="disable"><span><i
                                                            class="fa fa-check-square-o"></i>Delivery</span></li>
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

        @include('user.social-tools')

        <!-- Section -->
        <section class="md-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9  col-lg-push-3">
                        <div class="main-content">

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

                            <div class="row">
                                <div class="col-lg-5 ">

                                    <!-- title -->
                                    <div class="title">
                                        <h2 class="title__title">Working time:</h2>
                                    </div><!-- End / title -->


                                    <!-- work-time -->
                                    <ul class="work-time">
                                        <li>Monday:<span>09:30 - 03:00</span></li>
                                        <li>Tuesday:<span>09:30 - 03:00</span></li>
                                        <li>Wednesday:<span>09:30 - 03:00</span></li>
                                        <li>Thursday:<span>09:30 - 03:00</span></li>
                                        <li>Friday:<span>09:30 - 03:00</span></li>
                                        <li>Saturday:<span>09:30 - 03:00</span></li>
                                        <li>Sunday:<span>09:30 - 03:00</span></li>
                                    </ul><!-- End / work-time -->

                                </div>
                                <div class="col-lg-5 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-2 ">

                                    <!-- infostore -->
                                    <div class="infostore">
                                        <div class="infostore__item">

                                            <!-- title -->
                                            <div class="title">
                                                <h2 class="title__title">Payment method:</h2>
                                            </div><!-- End / title -->

                                            <div class="infostore__text">

                                                <!-- checkbox -->
                                                <div class="checkbox checkbox-success">
                                                    <label class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                               checked="checked"/><span
                                                                class="custom-control-indicator"></span><span
                                                                class="custom-control-description">COD</span>
                                                    </label>
                                                </div><!-- End / checkbox -->


                                                <!-- checkbox -->
                                                <div class="checkbox checkbox-success">
                                                    <label class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                               checked="checked"/><span
                                                                class="custom-control-indicator"></span><span
                                                                class="custom-control-description">Pay online</span>
                                                    </label>
                                                </div><!-- End / checkbox -->

                                            </div>
                                        </div>
                                        <div class="infostore__item">

                                            <!-- title -->
                                            <div class="title">
                                                <h2 class="title__title">Available services:</h2>
                                            </div><!-- End / title -->

                                            <div class="infostore__text">

                                                <!-- checkbox -->
                                                <div class="checkbox checkbox-success">
                                                    <label class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                               checked="checked"/><span
                                                                class="custom-control-indicator"></span><span
                                                                class="custom-control-description">Delivery</span>
                                                    </label>
                                                </div><!-- End / checkbox -->


                                                <!-- checkbox -->
                                                <div class="checkbox checkbox-success">
                                                    <label class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                               checked="checked"/><span
                                                                class="custom-control-indicator"></span><span
                                                                class="custom-control-description">Pick up</span>
                                                    </label>
                                                </div><!-- End / checkbox -->

                                            </div>
                                        </div>
                                        <div class="infostore__item">

                                            <!-- title -->
                                            <div class="title">
                                                <h2 class="title__title">Restaurant address:</h2>
                                            </div><!-- End / title -->

                                            <div class="infostore__text">
                                                <p><i class="fa fa-map-marker"></i> Phú Mỹ , Bình Thạnh, Hồ Chí Minh
                                                </p>
                                            </div>
                                        </div>
                                    </div><!-- End / infostore -->

                                </div>
                            </div>
                            <hr>

                            <!-- title -->
                            <div class="title">
                                <h2 class="title__title">Available locations that can be delivered:</h2>
                            </div><!-- End / title -->

                            <div class="row">
                                <div class="col-lg-5 ">

                                    <!-- location -->
                                    <table class="location">
                                        <colgroup>
                                            <col/>
                                            <col/>
                                            <col/>
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <td>
                                                <h6 class="location__title">Location</h6>
                                            </td>
                                            <td>
                                                <h6 class="location__title">Minimum</h6>
                                            </td>
                                            <td>
                                                <h6 class="location__title">Delivery fee</h6>
                                            </td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Quận 1</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>Quận 2</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>Quận 3</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>Quận 4</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>Quận 5</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>Quận 6</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        </tbody>
                                    </table><!-- End / location -->

                                </div>
                                <div class="col-lg-5 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-2 ">

                                    <!-- location -->
                                    <table class="location">
                                        <colgroup>
                                            <col/>
                                            <col/>
                                            <col/>
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <td>
                                                <h6 class="location__title">Location</h6>
                                            </td>
                                            <td>
                                                <h6 class="location__title">Minimum</h6>
                                            </td>
                                            <td>
                                                <h6 class="location__title">Delivery fee</h6>
                                            </td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Quận 1</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>Quận 2</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>Quận 3</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>Quận 4</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>Quận 5</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        <tr>
                                            <td>Quận 6</td>
                                            <td>100.000đ</td>
                                            <td>50.000đ</td>
                                        </tr>
                                        </tbody>
                                    </table><!-- End / location -->

                                </div>
                            </div>
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

    </div>
    <!-- End / Content-->

@endsection
@section('extra_scripts')

@endsection