<script>
    $('#percent').hide();
    const PROMOTION_TYPES = @json(\App\Models\Promotion::PROMOTION_TYPES);

    // ==================================================
    // run when page load
    // ==================================================
    $(document).ready(function() {
        @php
            if (!isset($slug) || !isset($promotion))
            {
                $promotion = new App\Models\Promotion();
                $promotion['free_item'] = NULL;
                $promotion['dishes_id'] = NULL;
                $promotion['categories_id'] = NULL;
            }
        @endphp

        applyToChange();
        typeChange();
        allDayChange();
        allTimeChange();
        $('.validate-message').hide();
        $('.m-content.hidden').removeClass('hidden');


        //time picker
        $('#from_time').timepicker({
            format: 'HH:mm',
            showMeridian: true,
            minuteStep: 1,
        });
        $('#to_time').timepicker({
            format: 'HH:mm P',
            showMeridian: true,
            minuteStep: 1,
        });
        if (@json(isset($slug))) {
            $('#free_item').val(@json($promotion['free_item'])).trigger('change');
            $('#dishes').val(@json($promotion['dishes_id'])).trigger('change');
            $('#categories_id').val(@json($promotion['categories_id'])).trigger('change');
        }
        $("input[name='number_usage']").mask("0#");
        $("input[name='maximun_discount']").mask("#.##0",{reverse:true});
        $("input[name='min_order_value']").mask("#.##0",{reverse:true});
        $("input[name='max_order_value']").mask("#.##0",{reverse:true});
        $("input[name='item_value_from']").mask("#.##0",{reverse:true});
        $("input[name='item_value_to']").mask("#.##0",{reverse:true});
        $(".panel-default .note-statusbar.locked").remove();
    });


    // ==================================================
    // trigger elements
    // ==================================================
    $('#apply_to').change(function() {
        applyToChange();
    });
    $('#type').change(function() {
        typeChange();
    });
    $('#all_days').change(function () {
        allDayChange();
    });
    $('#all_times').change(function () {
        allTimeChange();
    });


    $('#submitButton').on("click", function () {
        if ($('#all_days').val() == '0') {
            let count = $('#specific_date').find('input[type=checkbox]:checked').length;
            if (count > 0) {
                $('#submitForm').submit();
            } else {
                $('.validate-message').show();
                //scroll to validation message
                $('html, body').animate({
                    scrollTop: $("#choose_date").offset().top
                }, 300);
            }
        } else {
            $('#submitForm').submit();
        }
    });


    // ==================================================
    // functions
    // ==================================================
    function allDayChange() {
        ($('#all_days').val() == 1) ? disabledElement($('#specific_date')) : enabledElement($('#specific_date'));
    }

    function allTimeChange() {
        ($('#all_times').val() == 1) ? disabledElement($('#specific_time')) : enabledElement($('#specific_time'));
    }

    function typeChange() {
        var typeId = $('#type').val();

        if (typeId == PROMOTION_TYPES.free_item) {
            enabledElement($('.free_item'));
            disabledElement($('.value'));
            disabledElement($('.maximun-discount'));
            $('#percent').hide();
        }
        else if (typeId == PROMOTION_TYPES.value) {
            enabledElement($('.value'));
            disabledElement($('.free_item'));
            disabledElement($('.maximun-discount'));
            $("input[name='value']").mask("#.##0",{reverse:true});
            $('#percent').hide();
        }
        else {
            enabledElement($('.value'));
            enabledElement($('.maximun-discount'));
            disabledElement($('.free_item'));
            $("input[name='value']").mask("0#");
            $('#percent').show();
        }
    }

    function applyToChange() {
        var applyToId = $('#apply_to').val();
        $.each($('.apply_form .apply_to'), function() {
            if ($(this).attr('id') == 'apply_to_'+applyToId) {
                $(this).show();
                $(this).find('input, select').prop('disabled', false);
            }
            else {
                $(this).hide();
                $(this).find('input, select').prop('disabled', true);
            }
        })
    }

    function disabledElement(element) {
        $(element).hide();
        $(element).find('input, select').prop('disabled', true);
    }

    function enabledElement(element) {
        $(element).show();
        $(element).find('input, select').prop('disabled', false);
    }
</script>
