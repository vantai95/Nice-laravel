<div class="m-portlet__body m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    @if(Auth::user()->isAdmin())
    <div class="form-group m-form__group row">
        <div class="col-lg-12 {{ $errors->has('status') ? 'has-error' : ''}}">
            {!! Form::label('status', trans('admin.orders.forms.status').' *', ['class' => 'col-form-label col-sm-12']) !!}
            <div class="col-sm-12">
                <select required name="status" class="form-control select2" id="status">
                    <option disabled selected>--@lang('admin.orders.forms.choose_status')--</option>
                    @foreach([0,1,2,3] as $index => $value)
                        <option value="{{ $value }}" @if($value == $order->status) selected="selected" @endif>{{ $order->getStatus($value) }}</option>
                    @endforeach
                </select>
                {!! $errors->first('status', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group notes row {{ 3 != $order->status ? '' : 'd-none' }}">
        <div class="col-lg-12 {{ $errors->has('notes') ? 'has-error' : ''}}">
            <label for="notes" class="col-form-label col-sm-12">@lang('admin.orders.forms.notes')
                <span class="text-danger"></span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('notes', $order->notes, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('notes', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>
    <div class="form-group m-form__group reject_reason row {{ 3 == $order->status ? '' : 'd-none' }}">
        <div class="col-lg-12 {{ $errors->has('reject_reason') ? 'has-error' : ''}}">
            <label for="reject_reason" class="col-form-label col-sm-12">@lang('admin.orders.forms.reject_reason')
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                {!! Form::text('reject_reason', $order->reject_reason, ['class' => 'form-control m-input']) !!}
                {!! $errors->first('reject_reason', '<p class="help-block field-error">:message</p>') !!}
            </div>
        </div>
    </div>
    @endif

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions">
        <div class="row">
            <div class="col-lg-9 ml-lg-auto">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.orders.buttons.create'), ['class' => 'btn btn-success', 'id' => 'submitButton']) !!}
                <a href="{{\Session::has('res') ? url('admin/'.$res->res_Slug.'/orders') : url('admin/orders')}}" class="btn btn-secondary">
                    @lang('admin.orders.buttons.cancel')
                </a>
            </div>
        </div>
    </div>
</div>

@section('extra_scripts')
    <script>
        $(document).ready(function(){
            $('#status').change(function(){
                if(parseInt($('#status').val()) === 3) {
                    $('.notes').addClass('d-none');
                    $('.reject_reason').removeClass('d-none');
                } else {
                    $('.reject_reason').addClass('d-none');
                    $('.notes').removeClass('d-none');
                }
            });
        });
    </script>
@endsection
