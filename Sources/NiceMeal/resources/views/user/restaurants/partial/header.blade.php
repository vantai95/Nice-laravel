
<section class="hero" style="background-image: url('https://i.imgur.com/n1shiqq.jpg')">
    <div class="md-tb">
        <div class="md-tb__cell">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 ">
                        <div class="listbox">
                            <div class="listbox__media"><a href="#">
                                    @if ($restaurant->image)
                                        <img src="{{ CommonService::buildImageURL($restaurant->image) }}"/>
                                    @else
                                        <img src="https://i.imgur.com/nDOt4XA.jpg"/>
                                    @endif
                                </a>
                                <!-- rating -->
                                <div class="rating">
                                    <div class="rating__rating" title="{{ $restaurant->star }}" count="{{ $restaurant->star }}">
                                        <span class="rating__icon" style="width: {{ round($restaurant->star / 5 * 100,0) }}%;"></span>
                                    </div>
                                    <span class="rating__count">
                                        <a href="#">
                                            ({{ $restaurant->count_review }} review)
                                        </a>
                                    </span>
                                </div><!-- End / rating -->
                                <span class="rating"></span>
                            </div>
                            <div class="listbox__body">
                                <h2 class="listbox__name">
                                    <span class="restaurant-name restaurant-details">{{ $restaurant->name }}</span>

                                    <span class="btn-like" onclick="doLike(this)">
                                        <i class="fa fa-heart"></i>
                                    </span>
                                </h2>
                                <p class="listbox__text">
                                    {!! $restaurant->description_en !!}
                                </p>
                                <ul class="listbox__list">
                                    <li>
                                        @if($restaurant->openStatus)
                                            <span class="text-success">Open Now</span>
                                        @else
                                            <span style="color: red">Closed</span>
                                        @endif
                                    </li>
                                    <li><span><i class="fa fa-motorcycle"></i> <% restaurant.deliveryCost.formatCurrency() %></span></li>
                                    <li><span><i class="fa fa-map-marker"></i> <% restaurant.districtName %></span></li>
                                    <li><span><i class="fa fa-cart-plus"></i> Min: <% restaurant.minOrderAmount.formatCurrency() %></span></li>
                                    <li @if($restaurant->pickup == 0) class="disable" @endif ><span><i class="fa fa-check-square-o"></i>Pick Up</span></li>
                                    <li @if($restaurant->online_payment == 0) class="disable" @endif ><span><i class="fa fa-check-square-o"></i>Online Payment</span></li>
                                    <li @if($restaurant->delivery == 0) class="disable" @endif ><span><i class="fa fa-check-square-o"></i>Delivery</span></li>
                                    <li @if($restaurant->cod_payment == 0) class="disable" @endif ><span><i class="fa fa-check-square-o"></i>COD</span></li>
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
                <div class="hero__left">
                    <a ng-click="goBack()" a href="/locations/{{ Request::get('district')}}">
                        <i class="fa fa-long-arrow-left"></i>
                        Back to restaurants list
                    </a>
                </div>
                <div class="hero__center">
                    <form class="hero__search">
                        <input class="hero__input" ng-model="dishfilter" placeholder="Search (Search Food name)"/><i
                                class="fa fa-search"></i>
                    </form>
                </div>
                <div class="hero__right" data-toggle="modal" data-target="#cartModal">
                    <div class="hero__card" >
                        <a >
                            <i class="fa fa-shopping-cart"></i>
                            <span class="cart-number" ng-if="cart.total_item < 0"><span class="fa fa-refresh"></span></span>
                            <span class="cart-number" ng-if="cart.total_item > 0"> <% cart.total_item %> </span>
                        </a>
                    </div>
                    <span class="hero__total">Total: <span><% cart.order_total.formatCurrency() %> </span></span>
                </div>
            </div>
        </div>
    </div>

</section>
