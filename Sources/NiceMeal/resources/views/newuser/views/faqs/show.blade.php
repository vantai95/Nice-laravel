@extends('newuser.layouts.app')
@section('content')
    <div id="faqs">
        <div class="row">
            <div class="col-md-12">
                <h5 style="color: #d10921">FAQs</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-9 col-sm-9 col-md-9">
                @foreach($faqsTypeArr as $faqsType)
                <div class="faq_type_left" id="faq-{{$faqsType->id}}">
                        <p class="title_type">{{$faqsType->name}}</p>
                        <ul>
                            @foreach($faqsType->faqs as $faq)
                                <li class="question">{!! $faq->question !!}</li>
                                <li class="anwser">{!! $faq->answer !!}</li>
                            @endforeach
                        </ul>
                </div>
                @endforeach
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 faq_type_right">
                <ul>
                    @foreach($faqsTypeArr as $faqsType)
                        <li class="faq_type_menu"><a href="#faq-{{$faqsType->id}}">{{$faqsType->name}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
@push('extra_scripts')
<script type="text/javascript">
    $('.anwser').slideUp();
    $('.question').click(function(event) {
        $(this).next().slideToggle();
        $(this).toggleClass('active');
    });
    $('.faq_type_menu').click(function(event) {
        $('.faq_type_menu').removeClass('line-red');
        $(this).addClass('line-red');
    });
</script>
@endpush
