var leftSideBarIndex = 0;
var rightSideBarIndex = 0;

$(function(){
  sideBarChange(0,"left");
  sideBarChange(0,"right");
})

function getCurrentIndex(sidebar){
  if(sidebar === "left"){
    return leftSideBarIndex;
  }else if(sidebar === "right"){
    return rightSideBarIndex;
  }
}

function setCurrentIndex(value,sidebar){
  if(sidebar === "left"){
    leftSideBarIndex = value;
  }else if(sidebar === "right"){
    rightSideBarIndex = value;
  }
}

function getHeaderList(sidebar){
  return $('.fixed-sidebar.sidebar-'+sidebar+' .widget').get();
}

function sideBarChange(value,sidebar){
  var index = getCurrentIndex(sidebar);
  var headers = getHeaderList(sidebar);
  $(headers[index]).hide();
  if(value == 1) index += 1;
  if(value == -1) index -= 1;
  if(index > headers.length - 1) index = 0;
  if(index < 0) index = headers.length - 1;
  $(headers[index]).show();
  setCurrentIndex(index,sidebar);
}

function footerSideBarClick(value,sidebar) {
    var element = $('.fixed-sidebar.sidebar-right a.fixed-sidebar-header-text span').html();
    if(element != "Let's talk"){
        sideBarChange(value,sidebar);
    }else {
        return false;
    }
}
