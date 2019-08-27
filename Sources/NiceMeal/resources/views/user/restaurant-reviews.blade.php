<div class="col-lg-9 col-lg-push-3">
  <div class="main-content">

    <!-- nav-menu -->
    <nav class="nav-menu">
      <div class="nav-menu__toggle"><span class="toggle__text" data-text="Hide">Show </span>menu</div>
      <ul class="nav-menu__list">
        <li ng-repeat="item in nav" ng-class="{'current': item.url === currentStateName}">
          <a ui-sref="{{item.url}}({restaurant_slug: restaurant_slug})">{{item.name}}</a>
        </li>
      </ul>
    </nav><!-- End / nav-menu -->


    <!-- commentbox -->
    <div class="commentbox">
      <div class="comment-header">

        <!-- rating -->
        <div class="rating"><span class="rating__point">{{$parent.restaurant.review_rate}}</span>
          <div class="rating__rating" title="{{$parent.restaurant.review_rate}}" count="{{$parent.restaurant.review_rate}}">
            <span class="rating__icon" ng-style="{'width': ($parent.restaurant.review_rate / 5 * 100) + '%'}"></span>
          </div>
        </div><!-- End / rating -->
        <span>Average {{$parent.restaurant.review_rate}} stars out of {{$parent.restaurant.num_reviews}} reviews</span>
      </div>
      <div class="mycomment" ng-hide="!isLoggedIn">
        <div class="comment_container">
          <div class="comment-avatar"><a href="#"><img class="avatar" ng-src="https://uinames.com/api/photos/female/20.jpg" alt=""/></a></div>
          <div class="comment-text">
            <div class="comment-meta"><span class="author">{{user.display_name}}</span>
              <span class="date"></span>
            </div>
            <div class="comment-star">
              <div class="comment-star-item"> <span>Food:</span>

                <!-- rating -->
                <div class="rating">
                  <div class="rating__rating" ng-mousemove="rating_move($event, 'food')" ng-click="rating_click($event, 'food')"><span class="rating__icon" ng-style="{'width': (food_rate / 5 * 100) + '%'}"></span></div>
                </div><!-- End / rating -->

              </div>
              <div class="comment-star-item"><span>Service:</span>

                <!-- rating -->
                <div class="rating">
                  <div class="rating__rating" ng-mousemove="rating_move($event, 'service')" ng-click="rating_click($event, 'service')"><span class="rating__icon" ng-style="{'width': (service_rate / 5 * 100) + '%'}"></span></div>
                </div><!-- End / rating -->

              </div>
            </div>
            <div class="comment-description">
              <form class="comment-submit">
                  <div class="col-md-10"><textarea placeholder="Your comment" ng-model="comment_content"  rows="8"></textarea></div>
                  <div class="col-md-2" style="margin-top: 5px">
                    <button class="md-btn md-btn--primary md-btn--sm" type="submit" ng-click="comment($event)">Submit</button>
                  </div>
              </form>
            </div>
            <div class="comment-footer"><span class="comment-note"></span></div>
          </div>
        </div>
      </div>
      <ol class="commentlist">
        <li class="comment" ng-repeat="item in $parent.restaurant.reviews">
          <div class="comment_container">
            <div class="comment-avatar"><a href="#"><img class="avatar" ng-src="{{item.customer_avatar}}" alt=""/></a></div>
            <div class="comment-text">
              <div class="comment-meta">
                <span class="author">{{item.customer_display_name}}</span>
                <span class="date">{{item.comment_time}}
                    <a class="reply-click" ng-click="open_reply(item)" ng-if="isLoggedIn">| Reply</a>
                </span>
              </div>
              <div class="comment-star">
                <div class="comment-star-item"> <span>Food:</span>

                  <!-- rating -->
                  <div class="rating">
                    <div class="rating__rating" title="{{::item.food_rate}}" count="{{::item.food_rate}}"><span class="rating__icon" ng-style="{'width': (item.food_rate / 5 * 100) + '%'}"></span></div>
                  </div><!-- End / rating -->

                </div>
                <div class="comment-star-item"><span>Service:</span>

                  <!-- rating -->
                  <div class="rating">
                    <div class="rating__rating" title="{{::item.service_rate}}" count="{{::item.service_rate}}"><span class="rating__icon" ng-style="{'width': (item.service_rate / 5 * 100) + '%'}"></span></div>
                  </div><!-- End / rating -->

                </div>
              </div>
              <div class="comment-description" ng-bind-html="item.content">
              </div>
              <div class="comment-footer"><span class="comment-note"></span></div>
            </div>
          </div>
          <ol class="children">
              <li class="mycomment" ng-if="isLoggedIn" style="display: none;" data-comment-id="{{item.id_comment}}">
                  <div class="comment_container">
                    <div class="comment-avatar"><a href="#"><img class="avatar" ng-src="https://uinames.com/api/photos/female/20.jpg" alt=""/></a></div>
                    <div class="comment-text">
                      <div class="comment-meta"><span class="author">{{user.display_name}}</span><span class="date"></span></div>
                      <div class="comment-star">
                        <div class="comment-star-item"> <span>Food:</span>

                          <!-- rating -->
                          <div class="rating">
                            <div class="rating__rating" ng-mousemove="rating_move($event, 'food', item.id_comment)" ng-click="rating_click($event, 'food', item.id_comment)"><span class="rating__icon" ng-style="{'width': (food_rate_{{item.id_comment}} / 5 * 100) + '%'}"></span></div>
                          </div><!-- End / rating -->

                        </div>
                        <div class="comment-star-item"><span>Service:</span>

                          <!-- rating -->
                          <div class="rating">
                            <div class="rating__rating" ng-mousemove="rating_move($event, 'service', item.id_comment)" ng-click="rating_click($event, 'service', item.id_comment)"><span class="rating__icon" ng-style="{'width': (service_rate_{{item.id_comment}} / 5 * 100) + '%'}"></span></div>
                          </div><!-- End / rating -->

                        </div>
                      </div>
                      <div class="comment-description">
                        <form class="comment-submit">
                            <div class="col-md-10"><textarea rows="8" placeholder="Your comment" class="form-control" name="comment_content_{{item.id_comment}}"></textarea></div>
                            <div class="col-md-2" style="margin-top: 5px">
                              <button class="md-btn md-btn--primary md-btn--sm" type="submit" ng-click="comment($event, item.id_comment)">Submit</button>
                            </div>
                        </form>
                      </div>
                      <div class="comment-footer"><span class="comment-note"></span></div>
                    </div>
                  </div>
                </li>
            <li class="comment" ng-repeat="subitem in item.sub_topic">
              <div class="comment_container">
                <div class="comment-avatar"><a href="#"><img class="avatar" ng-src="{{subitem.customer_avatar}}" alt=""/></a></div>
                <div class="comment-text">
                    <div class="comment-meta">
                        <span class="author">{{subitem.customer_display_name}}</span>
                        <span class="date">{{subitem.comment_time}}</span>
                      </div>
                    <div class="comment-star">
                    <div class="comment-star-item"> <span>Food:</span>

                      <!-- rating -->
                      <div class="rating">
                        <div class="rating__rating" title="{{::subitem.food_rate}}" count="{{::subitem.food_rate}}"><span class="rating__icon" ng-style="{'width': (subitem.food_rate / 5 * 100) + '%'}"></span></div>
                      </div><!-- End / rating -->

                    </div>
                    <div class="comment-star-item"><span>Service:</span>

                      <!-- rating -->
                      <div class="rating">
                        <div class="rating__rating" title="{{::subitem.service_rate}}" count="{{::subitem.service_rate}}"><span class="rating__icon" ng-style="{'width': (subitem.service_rate / 5 * 100) + '%'}"></span></div>
                      </div><!-- End / rating -->

                    </div>
                  </div>
                  <div class="comment-description" ng-bind-html="subitem.content">
                  </div>
                  <div class="comment-footer"><span class="comment-note unhappy"></span></div>
                </div>
              </div>
            </li>
          </ol>
        </li>

      </ol>
    </div><!-- End / commentbox -->

  </div>
</div>
<div class="col-lg-3 col-lg-pull-9">
  <div class="sidebar-left sticky">

    <!-- widget -->
    <div class="widget">
      <h2 class="widget__title">Choose Cuisine</h2>
      <div class="widget__content">

        <!-- widget-categories -->
        <ul class="widget-categories">
          <li ng-repeat="(category_name, category) in restaurant_dishes">
            <a href="#section-{{$index}}">{{::category_name}}</a>
          </li>
        </ul><!-- End / widget-categories -->

      </div>
    </div><!-- End / widget -->

  </div>
</div>
