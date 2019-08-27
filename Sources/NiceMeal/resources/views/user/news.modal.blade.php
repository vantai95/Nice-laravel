<div class="new-detail">
  <div class="new-detail__inner">
  <div class="new-detail__media"><img ng-src="{{details.thumbnail_image}}" alt=""></div>
  <div class="new-detail__body">
  <h1 class="new-detail__title">{{details.title}}</h1>
  <div class="new-detail__meta">
    <span class="meta-date">{{details.published_time | date : "longDate"}}</span>
    <span class="meta-view"> <i class="fa fa-eye"></i>{{::details.num_of_view}}</span>
    <span class="meta-heart"> <i class="fa fa-heart"></i>{{::details.num_of_like}}</span>
    <!-- <span class="meta-out"> <i class="fa fa-mail-forward"></i>100</span> -->
  </div>
  <div class="new-detail__entry" ng-bind-html="details.content">

  </div>
  <div class="new-detail__footer">
  <div class="new-detail__author"><span>Written by<a href="#">{{details.author_name}}</a></span></div>
  <div class="new-detail__meta_2">
  <div class="new-detail__status">
    <span class="like" ng-click="toggleLike()">
        <i class="fa "
        ng-class="{'fa-heart': like,
                   'fa-heart-o': !like}"></i>
                   Like
    </span>
    <!-- <span class="share"><i class="fa fa-share"></i>Share</span> -->
  </div>
  <!-- <div class="new-detail__tag"><span>tags: </span><a href="#">#new </a><a href="#">#wp </a><a href="#">#theme </a><a href="#">#hosting</a></div> -->
  </div>
  </div>
  </div>
  </div>
  <button title="Close (Esc)"
          class="mfp-close"
          type="button"
          ng-click="close()">×</button>
</div>
