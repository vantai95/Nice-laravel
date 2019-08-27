<div class="container">
    <div class="row">
        <div class="col-md-4 col-lg-3" style="margin-top: 30px">
            <div class="sidebar-left">

                <!-- widget -->
            {{--<div class="widget widget__info">--}}
            {{--<h2 class="widget__title">{{profile.display_name}}</h2>--}}
            {{--<div class="widget__content">--}}

            {{--<!-- widget-categories -->--}}
            {{--<ul class="widget-categories">--}}
            {{--<li ng-repeat="item in tabInfo" ng-class="{'active': item.url === currentStateName}">--}}
            {{--<a ui-sref="{{item.url}}"><span class="fa {{item.icon}}"></span>{{item.name}}</a>--}}
            {{--</li>--}}
            {{--</ul><!-- End / widget-categories -->--}}
            {{--</div>--}}
            {{--</div><!-- End / widget -->--}}

            <!-- widget -->
                <nav class="nav-menu">
                    <div ng-click="menuStatus = !menuStatus" ng-class="{'active': menuStatus}" class="nav-menu__toggle">
                        <span class="toggle__text" data-text="Hide">Show </span>menu
                    </div>
                    <ul class="nav-menu__list" ng-style="{ 'display' : menuStatus ? 'block' : '' }">
                        <li value="menu">
                            <a href="my-info">My Info</a>
                        </li>
                        <li value="order-history" class="current">
                            <a href="order-history">Order History</a>
                        </li>
                    </ul>
                </nav><!-- End /idget -->

            </div>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive form-wrap" style="margin-top: 30px; padding: 10px 0">
            <table class="mycart table">
                <thead>
                <tr>
                    <td class="thead-pd">
                        <h6 class="mycart__title"><% lang.date %></h6>
                    </td>
                    <td class="thead-pd">
                        <h6 class="mycart__title"><% lang.order_code %></h6>
                    </td>
                    <td class="thead-pd">
                        <h6 class="mycart__title"><% lang.status %></h6>
                    </td>
                    <td class="thead-pd">
                        <h6 class="mycart__title"><% lang.price %></h6>
                    </td>
                    <td class="thead-pd">
                        <h6 class="mycart__title"><% lang.restaurant_name %></h6>
                    </td>
                    <td class="thead-pd">
                        <h6 class="mycart__title"><% lang.action %></h6>
                    </td>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="order in ordersHistory">
                    <td class="table-td-pd"><% formatDate(order.created_at) %></td>
                    <td class="table-td-pd" style="color:red;"><span style="cursor:pointer" data-toggle="modal" data-target="#orderDetailModal" ng-click="openOrderDetail(order.id)"><% order.order_number %></span></td>
                    <td class="table-td-pd" style="color:<% order_status[order.status].color %>">
                        <% getStatus(order.status) %>
                    </td>
                    <td class="table-td-pd"><% formatPrice(order.total_amount) %></td>
                    <td class="table-td-pd"><% order.restaurant_name %></td>
                    <td class="table-td-pd"><% order.order_type %></td>
                    <td class="table-td-pd"><% order.payment_method %></td>
                    <td class="table-td-pd"><a ng-click="openOrderDetail(order.id)"  data-toggle="modal" data-target="#orderDetailModal"><i class="fa fa-shopping-cart"></i></a></td>
                </tr>
                <tr>
                    <td class="total-title">Total</td>
                    <td class="table-td-pd"></td>
                    <td class="table-td-pd"></td>
                    <td class="table-td-pd price-text"><% formatPrice(totalPrice()) %></td>
                    <td class="table-td-pd"></td>
                    <td class="table-td-pd"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

