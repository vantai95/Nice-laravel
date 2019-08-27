@php
    $lang = Session::get('locale');
@endphp

<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <div class="col-10 ml-auto">
            <h3 class="m-form__section">1. @lang('admin.users.title.details')</h3>
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('full_name') ? 'has-warning' : ''}}">
        <label for="example-text-input"
               class="col-form-label form-control-label col-2 {{ $errors->has('full_name') ? 'has-warning' : ''}}">
            @lang('admin.users.columns.full_name')<span class="text-danger"> *</span></label>
        <div class="col-7">
            {!! Form::text('full_name', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
            {!! $errors->first('full_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('birth_day') ? 'has-warning' : ''}}">
        <label for="example-text-input" class="col-2 col-form-label">@lang('admin.users.columns.dob')<span class="text-danger"> *</span> </label>
        <div class="col-7">
            {!! Form::text('birth_day', null, [ 'class' => 'form-control','onkeydown' => 'return false;','id' => 'm_datepicker_1','readonly' => 'true']) !!}
            {!! $errors->first('birth_day', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('phone') ? 'has-warning' : ''}}">
        <label for="example-text-input" class="col-2 col-form-label">@lang('admin.users.columns.phone')<span class="text-danger"> *</span></label>
        <div class="col-7">
            {!! Form::text('phone', null, ['class' => 'form-control m-input', 'aria-invalid' => 'true']) !!}
            {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('address') ? 'has-warning' : ''}}">
        <label for="example-text-input" class="col-2 col-form-label">@lang('admin.users.columns.address')</label>
        <div class="col-7">
            {!! Form::text('address', null, ['class' => 'form-control m-input']) !!}
            {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group m-form__group row {{ $errors->has('is_locked') ? 'has-warning' : ''}}">
        <label for="example-text-input" class="col-2 col-form-label">@lang('admin.users.columns.locked')</label>
        <div class="col-1">
            {!! Form::checkbox('is_locked', 1, isset($user) ? $user->is_locked : true, ['class' => 'form-control ', 'name'=>'is_locked', 'id'=>'is_locked']) !!}
            {!! $errors->first('is_locked', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    @if (!$isMyProfile && ( Auth::user()->isAdmin() || Auth::user()->isManageAllRestaurant() ))
        <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>

        <div class="form-group m-form__group row {{ $errors->has('role_id') ? 'has-warning' : ''}}">
          <label for="role_id" class="col-2 col-form-label">Role</label>
          <div class="col-10">
            <select id="role_list" class="form-control m-input select-role" name="role_id">
              <option value="">Select Role</option>
              @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ ($user->role_id == $role->id) ? 'selected' : '' }}>{{$role->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group m-form__group row" id="restaurant_list">
          <label for="role_id" class="col-2 col-form-label">Restaurant</label>
          <div class="col-10">
            <select  class="select-restaurant form-control select2" id="restaurant" name="restaurant">
                <option selected disabled >--@lang('admin.users.columns.restaurant')--</option>
                @foreach($restaurants as $index => $item)
                        <option value="{{$index}}" >{{$item}}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="form-group m-form__group row {{ $errors->has('role_id') ? 'has-warning' : ''}}" id="selected_restaurants_section">
            <label for="role_id" class="col-2 col-form-label">Selected Restaurant</label>
            <div class="col-10" id="selected_restaurant_list">
                @foreach($user->restaurants as $restaurant)
                <div class="btn m-btn--pill m-btn--air btn-metal" data-restaurant-id="{{$restaurant->id}}" style="margin-bottom:5px;">
                    {{$restaurant->name_en}}
                    <input type="hidden" name="restaurants[{{$restaurant->id}}]" value='{{$restaurant->id}}'>
                    <i class="fa fa-trash role-remove" value='{{$restaurant->id}}' onclick="removeRestaurant(this)"></i>
                </div>
                @endforeach
                <!-- <input type="hidden" name="role_removed" id="role_removed" value="[]"/>
                <input type="hidden" name="role_add" id="role_add" value="[]"/> -->
            </div>
        </div>

    @endif


</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <div class="col-2">
            </div>
            <div class="col-7">
                {!! Form::submit(isset($submitButtonText) ? $submitButtonText : trans('admin.buttons.save_change'), ['class' => 'btn btn-accent m-btn m-btn--air m-btn--custom']) !!}

                <a href="{{url('admin/users')}}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">{{trans('admin.buttons.cancel')}}</a>
            </div>
        </div>
    </div>
</div>

@section('extra_scripts')
    <script type="text/javascript">
        $('#m_datepicker_1').datepicker({
            language: '{{$lang}}',
            format: 'yyyy-mm-dd'
        });
        $( document ).ready(function() {
            $('.select2').select2();
            showRestaurantForm();
            $('.select-role').change(function () {
                if($(this).val() == 1){
                    $('#restaurant_role').hide();
                }else {
                    $('#restaurant_role').show();
                }
            })


        });
        $('#role_list').change(function(){
          showRestaurantForm();
        });

        $('#restaurant').change(function(){
          var restaurant_id = $(this).val();
          var restaurant_name = $("#restaurant option:selected").html();
          if($('div').find("[data-restaurant-id='" + restaurant_id + "']").length == 0){
            var html = '<div class="btn m-btn--pill m-btn--air btn-metal" data-restaurant-id="'+restaurant_id+'" style="margin-bottom:5px;">'+restaurant_name +
                '<input type="hidden" name="restaurants['+restaurant_id+']" value='+restaurant_id+'>' +
                ' <i class="fa fa-trash role-remove" onclick="removeRestaurant(this)"></i>'+
                '</div>';
            $("#selected_restaurant_list").append(html);
          }
        });

        function removeRestaurant(element){
          $(element).parent('div').remove();
        }

        function showRestaurantForm(){
          if($('#role_list option:selected').html() == 'Restaurant'){
            $('#restaurant_list').show();
            $('#selected_restaurants_section').show();
          }else{
            $('#restaurant_list').hide();
            $('#selected_restaurants_section').hide();
          }
        }
        function showFormAddRole(){
            $("#add_role").show();
        }
    </script>
@endsection
