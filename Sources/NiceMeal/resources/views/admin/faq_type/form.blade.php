<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    <div class="form-group m-form__group row">
        <div class="col-lg-6 {{ $errors->has('name_vn') ? 'has-danger' : ''}}">
            <label for="name_vn" class="col-form-label col-sm-12">@lang('admin.faq_type.forms.name_vn')
            <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_vn', null, ['class' => 'form-control m-input']) !!} {!! $errors->first('name_vn', '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-lg-6 {{ $errors->has('name_en') ? 'has-danger' : ''}}">
            <label for="name_en" class="col-form-label col-sm-12">@lang('admin.faq_type.forms.name_en')
            </label>
            <div class="col-sm-12">
                {!! Form::text('name_en', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!} {!! $errors->first('name_en',
                '
                <div id="email-error" class="form-control-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
@if(!empty($faqs))
<div class="m-content">
    <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
        <div class="row align-items-center">
            <div class="col-md-8 col-xs-8">
                <div class="form-group m-form__group row align-items-center">
                    <div class="col-md-4">
                        <div class="m-portlet__head-title">
                            <h5 class="m-portlet__head-text">
                                @lang('admin.faq_type.forms.chosen_faq')
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xs-4 m--align-right">
                <a href="/admin/faqs?faq-type={{$faqType->id}}"
                   class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                <span>
                    <span>
                        @lang('admin.faq_type.breadcrumbs.edit')
                    </span>
                </span>
                </a>
                <div class="m-separator m-separator--dashed d-xl-none"></div>
            </div>
        </div>
    </div>
    <table class="table table-striped table-bordered table-responsive-md">
        <thead>
        <tr class="table-dark text-center">
            <th>@lang('admin.faq.columns.question_en')</th>
            <th>@lang('admin.faq.columns.anwser_en')</th>
        </tr>
        </thead>
        <tbody class="m-datatable__body">
        @foreach($faqs as $key => $item)
            <tr class="text-center">
                <td class="align-middle">{{ $item->question_en }}</td>
                <td class="align-middle">{!! $item->anwser_en !!}</td>
            </tr>
        @endforeach
        @if(count($faqs) == 0)
            <tr>
                <td colspan="100%">
                    <i><h6>@lang('admin.faq_type.not_found')</h6></i>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
@endif
<div class="m-portlet__foot m-portlet__foot--fit" style="border-top: unset;">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.faq_type.buttons.update'), ['class' =>
                'btn btn-accent m-btn m-btn--air m-btn--custom', 'id' => 'submitButtonType']) !!}
                <a href="{{url('admin/faqs-type')}}" type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom btn-cancel">
                        @lang('admin.faq_type.buttons.cancel')
                    </a>
            </div>
        </div>
    </div>
</div>
