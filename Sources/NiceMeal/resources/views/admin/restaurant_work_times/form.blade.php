<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
  @if(isset($work_times))
    @include('admin.timesetting.form',['time_setting' => $work_times->time_setting])
  @else
    @include('admin.timesetting.form')
  @endif
</div>

<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                <a href="{{url('admin/'.$res->res_Slug.'/restaurant-work-times')}}" class="btn btn-secondary">
                    @lang('admin.buttons.cancel')
                </a>
                {!! Form::button(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
            </div>
        </div>
    </div>
</div>
