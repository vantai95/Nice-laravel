@extends('layouts.app')
@section('content')
    <div class="md-content">

    @include('user.social-tools')

    <!-- hero -->
    <section class="hero" style="background-image:url(&quot;assets/img/bg/1.jpg&quot;);">
        <div class="md-tb">
            <div class="md-tb__cell">
                <div class="container">
                    <div class="hero__page">
                        <div class="row">
                            <div class="col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-0 col-lg-offset-3 ">
                                <h1 class="hero__page_title">Ready to eat?</h1>
                                <p class="hero__page_text">Where do you want your order to be delivered?</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero__menu">
            <div class="container">
                <div class="hero__menu_wrap">
                    <div class="hero__left"><a href="#"><i class="fa fa-long-arrow-left"></i>Back</a></div>
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
                <div class="col-lg-9 ">
                    <div class="main-content">

                        <!-- form-wrap -->
                        <div class="form-wrap">
                            <h3 class="form-wrap__title">Contact info:</h3>
                            <div class="form-wrap__inner">

                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">Title<span>*</span>
                                    </label>
                                    <select class="form-control form-select" data-placeholder="placeholder">
                                        <option></option>
                                        <option>Groupon</option>
                                        <option>AMEX</option>
                                        <option>Cash</option>
                                        <option>Breadcrumb Payments</option>
                                    </select>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">full name<span>*</span>
                                    </label>
                                    <input class="form-control" type="text" name="input" placeholder="placeholder"/>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">Email<span>*</span>
                                    </label>
                                    <input class="form-control" type="text" name="input" placeholder="placeholder"/>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">phone<span>*</span>
                                    </label>
                                    <input class="form-control" type="text" name="input" placeholder="placeholder"/>
                                </div><!-- End / form-item -->

                            </div>
                        </div><!-- End / form-wrap -->


                        <!-- form-wrap -->
                        <div class="form-wrap">
                            <h3 class="form-wrap__title">Delivery info:</h3>
                            <div class="form-wrap__inner">

                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">Choose you address<span>*</span>
                                    </label>
                                    <select class="form-control form-select" data-placeholder="placeholder">
                                        <option></option>
                                        <option>Groupon</option>
                                        <option>AMEX</option>
                                        <option>Cash</option>
                                        <option>Breadcrumb Payments</option>
                                    </select>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">Residence type<span>*</span>
                                    </label>
                                    <select class="form-control form-select" data-placeholder="placeholder">
                                        <option></option>
                                        <option>Groupon</option>
                                        <option>AMEX</option>
                                        <option>Cash</option>
                                        <option>Breadcrumb Payments</option>
                                    </select>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item">
                                    <label class="form__label">Full address<span>*</span>
                                    </label>
                                    <input class="form-control" type="text" name="input" placeholder="placeholder"/>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">District<span>*</span>
                                    </label>
                                    <input class="form-control" type="text" name="input" placeholder="placeholder"/>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">Ward<span>*</span>
                                    </label>
                                    <select class="form-control form-select" data-placeholder="placeholder">
                                        <option></option>
                                        <option>Groupon</option>
                                        <option>AMEX</option>
                                        <option>Cash</option>
                                        <option>Breadcrumb Payments</option>
                                    </select>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">Hotel name<span>*</span>
                                    </label>
                                    <input class="form-control" type="text" name="input" placeholder="placeholder"/>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">Room
                                    </label>
                                    <input class="form-control" type="text" name="input" placeholder="placeholder"/>
                                </div><!-- End / form-item -->

                            </div>
                        </div><!-- End / form-wrap -->


                        <!-- form-wrap -->
                        <div class="form-wrap">
                            <h3 class="form-wrap__title">Note:</h3>
                            <div class="form-wrap__inner">

                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">Delivery time<span>*</span>
                                    </label>
                                    <select class="form-control form-select" data-placeholder="placeholder">
                                        <option></option>
                                        <option>Groupon</option>
                                        <option>AMEX</option>
                                        <option>Cash</option>
                                        <option>Breadcrumb Payments</option>
                                    </select>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item form-item--half">
                                    <label class="form__label">Payment amount<span>*</span>
                                    </label>
                                    <select class="form-control form-select" data-placeholder="placeholder">
                                        <option></option>
                                        <option>Groupon</option>
                                        <option>AMEX</option>
                                        <option>Cash</option>
                                        <option>Breadcrumb Payments</option>
                                    </select>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item">
                                    <label class="form__label">Direction:
                                    </label>
                                    <textarea class="form-control" name="" cols="30" rows="10"></textarea>
                                </div><!-- End / form-item -->

                            </div>
                        </div><!-- End / form-wrap -->


                        <!-- form-wrap -->
                        <div class="form-wrap">
                            <h3 class="form-wrap__title">Input your promotion code here:</h3>
                            <div class="form-wrap__inner">

                                <!-- form-item -->
                                <div class="form-item form-item-80">
                                    <input class="form-control" type="text" name="input" placeholder="placeholder"/>
                                </div><!-- End / form-item -->


                                <!-- form-item -->
                                <div class="form-item form-item-20">
                                    <a class="md-btn md-btn--danger md-btn--block " href="#">Check
                                    </a>
                                </div><!-- End / form-item -->

                            </div>
                        </div><!-- End / form-wrap -->

                    </div>
                </div>
                <div class="col-lg-3 ">
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
                                                <div class="product__footer"><span class="product__price">100.00đ</span><span
                                                            class="btn-del-product"><i
                                                                class="fa fa-times-circle"></i></span></div>
                                            </div>
                                            <div class="widget-order__product_list">
                                                <input class="product__number" type="text" value="10"/><span
                                                        class="product__period">x</span>
                                                <h4 class="procude__name">Cali Chicken Bacon Ranch</h4>
                                                <div class="product__footer"><span class="product__price">100.00đ</span><span
                                                            class="btn-del-product"><i
                                                                class="fa fa-times-circle"></i></span></div>
                                            </div>
                                            <div class="widget-order__product_list">
                                                <input class="product__number" type="text" value="5"/><span
                                                        class="product__period">x</span>
                                                <h4 class="procude__name">Chicken</h4>
                                                <div class="product__footer"><span class="product__price">100.00đ</span><span
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
                                            <textarea name="" cols="30" rows="10" placeholder="Order Note:"></textarea>
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
                                    <div class="widget-order__item">
                                        <div class="widget-order__note">
                                            <label>

                                                <!-- checkbox -->
                                                <div class="checkbox">
                                                    <label class="custom-control custom-checkbox">
                                                        <input class="custom-control-input" type="checkbox"
                                                               checked="checked"/><span
                                                                class="custom-control-indicator"></span><span
                                                                class="custom-control-description"></span>
                                                    </label>
                                                </div><!-- End / checkbox -->
                                                I would like to receive newest informations about best deals!
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <a class="md-btn md-btn--danger md-btn--sm md-btn--block " href="#">Finish
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
@endsection
@section('extra_scripts')
@endsection