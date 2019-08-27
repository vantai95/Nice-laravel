{{ csrf_field() }}
<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">

    @include('admin.customizations.formbody')

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                @if(isset($customization))
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText :
                trans('admin.customizations.buttons.update'), ['class' => 'btn btn-success', 'id' => 'submitButton'])
                !!}
                @else
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText :
                trans('admin.customizations.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton'])
                !!}
                @endif
                <a href="{{url($backUrl)}}" class="btn btn-secondary">
                    @lang('admin.customizations.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>
