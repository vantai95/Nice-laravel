        <div class="m-portlet__body">

            <div class="row">
              <div class="col-lg-12">
                <div class="form-group m-form__group">
                  <label>Name
                      <span class="text-danger">*</span>
                  </label>
                  <input type="text" class="form-control" name="name" value="{{ (isset($role)) ? $role->name : ''}}">
                </div>
              </div>
              <div class="col-lg-12" style="margin-top:20px;">
                <div class="form-group m-form__group">
                  <label>Permissions
                      <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="form-group m-form__group" style="padding-top:0px;">
                  <div class="row">
                    @foreach($permissions as $page)
                      <div class="col-lg-4">
                          @foreach($page as $key => $value)
                                <div class="m-checkbox-inline col-lg-12">
                                    <label class="m-checkbox">
                                        <input class="form-control " name="permissions[{{ $value['code'] }}]" id="{{ $value['code'] }}"
                                        @if(isset($role) && in_array($value['code'],$role->permissions))
                                         checked
                                        @endif
                                         type="checkbox"> {{$key}}
                                        <span></span>
                                    </label>
                                </div>
                          @endforeach
                        </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>

        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions">
                <div class="row">
                    <div class="col-lg-9 ml-lg-auto">
                        {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.categories.buttons.create'), ['class' => 'btn btn-accent m-btn m-btn--air m-btn--custom', 'id' => 'submitButton']) !!}
                        <a href="#" type="reset"
                           class="btn btn-secondary m-btn m-btn--air m-btn--custom btn-cancel">
                            @lang('admin.categories.buttons.cancel')
                        </a>
                    </div>
                </div>
            </div>
        </div>
