@extends('layouts.app')

@section('page-title', trans('app.reallocation'))

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            @lang('app.reallocation')
            <!-- <small>@lang('app.list_of_batches')</small> -->
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.reallocation')</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
<!--     <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7"></div> -->
    <form method="GET" action="" accept-charset="UTF-8" id="reallocation-form">
        <div class="col-xs-7 col-sm-5 col-md-3 col-lg-3">
            {!! Form::select('batch_code', $batches, Input::get('batch_code'), ['id'=>'batch_code', 'class'=>'form-control'])!!}
        </div>
    </form>
</div>

{!! Form::open(['route' => 'batches.reassigntouser', 'id' => 'reallocation-form1']) !!}

<div class="table-responsive top-border-table" id="users-table-wrapper">
    <table class="table" id="reallocation_table">
        <thead>
        	<th class="col-sm-2">@lang('app.company_id')</th>
        	<th class="col-sm-3">@lang('app.company_name')</th>
            <th class="col-sm-2">@lang('app.status')</th>
            <th class="col-sm-2">@lang('app.username')</th>
            <th class="text-center">@lang('app.action')</th>
        </thead>
        <tbody>
        	@if(count($companies))
                @foreach ($companies as $company)
                	<tr>
                        <td>{{ $company->id }}</td>
                        <td>{{ $company->company_name }}</td>
                        <td>{{ $company->status }}</td>
                        <td>{{ $company->first_name }} {{ $company->last_name }}</td>
                        
                        <td class="text-center">
	                        <input name="agree[]" id="agree[]" type="checkbox" value="{{ $company->id }}">
                        	<input type="hidden" id="openModel"> 
                        </td>
                     </tr>
                @endforeach
           @else
                <tr>
                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                </tr>
            @endif
        </tbody>
    </table>

</div>

<div class="row" id="btndiv">
    <div class="pull-right">
        <button type="submit" class="btn btn-primary btn-block" id="btnreallocation">
            <i class="fa fa-refresh"></i>
            @lang('app.reallocation')
        </button>
    </div>
</div>
@stop

<!-- Modal -->
<style>
@media screen and (min-width: 768px) {
	#conform .model-dialog{width:600px;}	
}
</style>
<div id="conform" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div id="newCompany" class="modal-body">
				<div class="row">
					<!--First Section-->
					<div class="col-lg-12 col-md-8 col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">Warning</div>
							<div class="panel-body">
								<div class="row">
									<div class="form-group col-lg-12">
										<label id="count"></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8"></div>
									<div class="col-md-2">
										<button type="button" class="btn btn-primary" id="btnOk" value="true" data-dismiss="modal">Ok
										</button>
									</div>
									<div class="col-md-2">
										<button type="button"  id="btnCancel" value="false" class="btn btn-secondary" data-dismiss="modal">Cancel
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@section('scripts')
    <script>
		$("#btndiv").hide();
        $("#batch_code").change(function (){
            $("#reallocation-form").submit();
        });
        
//         $("#chkall").click(function() {
//             var allChecked = $(this);
//             $("#reallocation_table input[type=checkbox]").each(function() {
//               $(this).prop("checked", allChecked.is(':checked'));
//             })
//         });

        $("#reallocation_table input[type=checkbox]").change(function(){
        	  if($(this).prop("checked")) {
        	    $('#btndiv').show();
        	  }
        });

        $(document).ready(function() {
            $("#btnreallocation").click(function() {
            	if($('#upload').val() == '')
      		  	{
      		 	 	$('#upload').css('border-color', 'red');
      			  	return false;
      		  	}else{
      			 		$('#upload').css('border-color', 'green');
      				}
      		  	$("#conform").modal();
      				$("#count").text("Are you sure to Reallocate the Records?");
      				$('#conform button').on('click', function(){
      		        var confirm= $(this).attr('value');
      		        if (confirm=='true') {   
      		        	  $('#openModel').val('conform');
      		        	  $("#btnreallocation").click();
      		       	   }
      			 	});
      			 
      			if ($('#openModel').val() == '') {
      				return false;
      			}
            });

            $("#reallocation_table id[user_id]").select2({
                width: '100%',
                placeholder:'Select a user',
                allowClear: true
            });
            $("#batch_code").select2({
                width: '100%',
                placeholder: 'Select a Batch Code',
                allowClear:true
            });
        });
    </script>
@stop