//modal filter
$('#filter-search').click(function(){
    $('#modal-filter').toggle();
});
$('.li_span_title label input').click(function(){
    $(this).closest( 'li' ).toggleClass( 'selected' );
    if(this.checked) {
        $(this).attr('value', '1');
    } else {
        if ($(this).attr('value')) {
            $(this).removeAttr('value');
        }
    }
});

var NewContent='<div class="modal-backdrop fade in class-modal-filter"></div>';
//click Filter
$('#filter-search').click(function() {
    $('.filter').toggleClass('filter-active');
    if (NewContent != '') {
        $("body").after(NewContent);
        NewContent = '';
    } else {
        $('body').next().toggle();
    }
});
//click random
$('.random select').click(function() {
    $('.filter').toggleClass('filter-active');
    $('#filter-search').attr('disabled','disabled');
    if (NewContent != '') {
        $("body").after(NewContent);
        NewContent = '';
    } else {
        $('body').next().toggle();
    }
});
//click outside window
$(document).mouseup(function(e) 
{
    var container = $(".filter");
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        $('#modal-filter').hide();
        container.removeClass('filter-active');
        $('.restaurants-list').removeClass('res-active');
        $('.random').removeClass('random-disabled');
        $('.class-modal-filter').hide();
        $('.random select').removeAttr("disabled");
    }
});
