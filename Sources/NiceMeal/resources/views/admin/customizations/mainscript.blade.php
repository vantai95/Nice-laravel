<script type="text/javascript">
  @if(isset($customization))
    var customization = {!! $customization !!}
  @else
    var customization = undefined;
  @endif
</script>

@include('admin.customizations.formscript')

<script>

    $('#submitForm').submit(function(){
        $('.price').unmask();
    })

</script>

<script type="text/javascript">
  $(function(){
    drawCustomization(customization);
    if(customization !== undefined){
      getOptions(customization.id);
    }
  })

  $('#submitForm').submit(function(e){

        if($('.option-item').length == 0){
            toastr.error("Vui lòng thêm option.");
            e.preventDefault();
            return;
        }

        if(Number($('#max_quantity').attr('value')) < Number($('#min_quantity').attr('value'))){
            toastr.error("Max quantity không thể nhỏ hơn min.");
            e.preventDefault();
            return;
        }

        $('#price,#max_quantity,#min_quantity,#option_price').unmask();
    });
</script>
