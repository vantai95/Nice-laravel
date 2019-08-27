@extends('admin.layouts.app') 
@section('content')
	<div>
		<div class="m-subheader">
	        <div class="d-flex align-items-center">
	            <div class="mr-auto">
	                <h3 class="m-subheader__title m-subheader__title--separator">
	                    District
	                </h3>
	                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
	                    <li class="m-nav__item m-nav__item--home">
	                        <a href="" class="m-nav__link m-nav__link--icon">
	                            <i class="m-nav__link-icon la la-home"></i>
	                        </a>
	                    </li>
	                    <li class="m-nav__separator"></li>
	                    <li class="m-nav__item">
	                        <a href="" class="m-nav__link">
	                            <span class="m-nav__link-text">District list</span>
	                        </a>
	                    </li>
	                </ul>
	            </div>
	        </div>
    	</div>
		<div class="m-content">
		    <div class="m-portlet m-portlet--mobile">
		        <div class="m-portlet__body">
		            <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
		               	<div class="row align-items-center">
			                <div class="col-xl-9 order-2 order-xl-1">    
			                </div>
			                <div class="col-xl-3 order-1 order-xl-2 m--align-right">
			                    <input class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill" type="button"  value="Update sequence" onclick="updateSequence(event)">
			                </div>
			            </div>
			        </div>
		            <table class="table table-striped table-bordered table-responsive-md">
		                <thead>
		                    <tr class="table-dark text-center">
		                        <th>Sequence</th>
		                        <th>District</th>
		                        <th></th>
		                    </tr>
		                </thead>
		                <tbody class="m-datatable__body" id="district_sort">
		                	@foreach($districts as $district)
		                	<tr id="{{ $district->id }}" class="text-center drag-cursor item_sequence" data-sequence="{{$district->sequence}}">
		                        <td class="align-middle">{{ $district->sequence }}</td>
		                        <td class="align-middle">{{ $district->name_en }}</td>
		                        <td class="text-nowrap align-middle">
		                        	<span class="label label-default pull-right icon-wrapper" onclick="changeSequence(this,true)"><i class="fa fa-angle-up icon"></i></span>
		                        	<span class="label label-default pull-right icon-wrapper" onclick="changeSequence(this,false)"><i class="fa fa-angle-down icon"></i></span>
		                        </td>
		                    </tr> 
		                     @endforeach             
		                </tbody>
		            </table>
		        </div>
		    </div>
		</div>
	</div>
@endsection
@section('extra_scripts')
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function () {
            $('#district_sort').sortable({
                cursor: "move",
                stop: function (event, ui) {
                    var disIds = [];
                    $('tbody tr').each(function () {
                        disIds.push($(this).attr('id'));
                    });
                }
            });
        })
    </script>
    <script type="text/javascript">
    	function changeSequence(element,up){
		    var parent = $(element).parents('.item_sequence');
		    //var parent = $(this).data('sequence');
		    //console.log(parent);
		    if(up){
		      var seoption = $(parent).prev();
		    }else{
		      var seoption = $(parent).next();
		    }

		    if(!$(seoption).hasClass('item_sequence')){
		      return;
		    }
		    changePosition(parent,seoption);
		}

		function changePosition(first,second){

		    var first_html = $(first).html();
		    var second_html = $(second).html();

		    var first_data = $(first).attr('data-sequence');
		    var second_data = $(second).attr('data-sequence');

		    var temp_html = first_html;
		    var temp_data = first_data;
		    //console.log(first_data,second_data);

		    $(first).attr('data-sequence',second_data);
		    $(second).attr('data-sequence',temp_data);

		    $(first).html(second_html);
		    $(second).html(temp_html);

		}
    </script>
    <script type="text/javascript">
    	function updateSequence(event) {
    		var disIds = [];
            $('tbody tr').each(function () {
            	disIds.push($(this).attr('id'));
            });
            console.log(disIds);
    		$.ajax({
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                url: '{{url('admin/location/district/update-sequence-district')}}',
                type: 'POST',
                dataType: 'json',
                data: {disIds: disIds},
                success: function (response) {
                    var sequence = 1;
                    $('tbody tr').each(function () {
                    var sequenceE = $(this).find('td').first();
                    sequenceE.text(sequence);
                    sequence = sequence + 1;
                    });
                    toastr.success('{{trans('admin.categories.flash_messages.change_sequence')}}');
                },
                    error: function (error) {
                    console.log(error);
                    toastr.error('{{trans('admin.categories.flash_messages.change_sequence_error')}}');
                }
            })
    	}
    </script>
@endsection