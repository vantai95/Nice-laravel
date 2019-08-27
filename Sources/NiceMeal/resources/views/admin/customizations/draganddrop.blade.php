<script type="text/javascript">
  function dragging(event){
  }

  function drop(event){
    event.preventDefault();
    var drag_id = event.dataTransfer.getData("drag_id");
    var drag = $('div').find("[data-option-id='"+drag_id+"']");
    var drop = event.target;
    if(!$(drop).hasClass('option-item')){
      drop = $(drop).parents('.option-item');
    }

    $(drop).css({"border":"none"});
    $(drop).css({"border-top":"1px solid #ebedf2"});

    changePosition(drag,drop);
    /*$('.option_price').mask("#.##0",{reverse:true});*/
  }

  function dragLeave(event){
    if($(event.target).hasClass('option-item')){
      $(event.target).css({"border":"none"});
      $(event.target).css({"border-top":"1px solid #ebedf2"});
    }
  }

  function dragEnter(event){
    if($(event.target).hasClass('option-item')){
      $(event.target).css({"border":"1px solid red"});
    }else{
      var parent = $(event.target).parents('.option-item');
      $(parent).css({"border":"1px solid red"});
    }
  }

  function allowDrop(event){
    event.preventDefault();

  }

  function dragStart(event){
    var drag_id = $(event.target).attr('data-option-id');
    event.dataTransfer.setData('drag_id',drag_id);
  }

  function changeClosest(element,up){
    var parent = $(element).parents('.option-item');

    if(up){
      var destination = $(parent).prev();
    }else{
      var destination = $(parent).next();
    }

    if(!$(destination).hasClass('option-item')){
      return;
    }
    changePosition(parent,destination);
  }

  function changePosition(first,second){

    var first_html = $(first).html();
    var second_html = $(second).html();

    var first_data = $(first).attr('data-option-id');
    var second_data = $(second).attr('data-option-id');
    var temp_html = first_html;
    var temp_data = first_data;

    $(first).attr('data-option-id',second_data);
    $(second).attr('data-option-id',temp_data);

    $(first).html(second_html);
    $(second).html(temp_html);

  }

</script>
