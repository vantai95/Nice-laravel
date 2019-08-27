<!-- footer -->
<footer class="mg-t-150">
    <div class="container">
        <div class="footer__inner">
            <div class="footer__coppyright footer-style">
            @if(CommonService::isTakeawayDomain())
                <p>2019 &copy; Copyright <span>vntakeaway</span>. All rights Reserved.</p>
            @else
                <p>2019 &copy; Copyright <span>NiceMeal</span>. All rights Reserved.</p>
                

                <a href="#">|</a>
                <a href="{{ url('/contact-us') }}">@lang('b2c.footer.contact_us')</a>
                <a href="#">@lang('b2c.footer.jobs')</a>
                <a href="#">@lang('b2c.footer.about_us')</a>
            @endif
            </div>
            <div class="footer__subscribe">
                <!-- form-item  -->
                <form id="submitEmailForm" class="form-item form-item--button form-item-subscribe">
                    <div class="form-group row" style="display: flex; margin-bottom: 5px">
                        <div class="col-md-10 email-form">
                            <input class="form-control" type="email" name="email" id="email" required
                                   placeholder="{{trans('b2c.footer.place_holder')}}"/>
                        </div>
                        <div class="col-md-2 btn-sent-email">
                            <input class="btn btn-info md-btn--primary btn-sent-text submit" type="submit"
                                   id="submitEmailButton"
                                   value="@lang('b2c.footer.button')"/>
                        </div>
                    </div>
                </form>
                <!-- End / form-item -->
            </div>
        </div>
    </div>

    <script>
        function Open(element) {
            if ($('#dropdown_arrow').hasClass('fa-angle-down')) {
                $('#dropdown_arrow').attr('class', 'fa fa-angle-up')
                $('#dropdown_footer_language').addClass('open');
                $('#dropdown_content').addClass('open');
            } else if ($('#dropdown_arrow').hasClass('fa-angle-up')) {
                $('#dropdown_arrow').attr('class', 'fa fa-angle-down')
                $('#dropdown_footer_language').removeClass('open');
                $('#dropdown_content').removeClass('open');
            }
        }
    </script>
</footer><!-- End / footer -->
