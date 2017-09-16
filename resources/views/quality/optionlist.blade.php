@extends('layouts.app')

@section('page-title', trans('app.quality-analysis'))

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            @lang('app.download_main_database')
            <!-- <small>@lang('app.list_of_batches')</small> -->
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.quality')</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

{!! Form::open(['route' => 'quality.download', 'id' => 'quality-download-form']) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.download_final_data')</div>
            <div class="panel-body">
            <div class="col-md-6">
            	<div class="form-group">
                    <label for="name">@lang('app.all')</label>&nbsp; &nbsp; 
                    <input type="radio" id="radioAll" name="option" value="All"> 
                </div>
            </div>
            <div class="col-md-6">
            	<div class="form-group">
                    <label for="name">@lang('app.specific')</label>&nbsp; &nbsp; 
                    <input type="radio" id="radioOption" name="option" value="Option">
                </div>
            </div>
          </div>
       </div>
   </div>
</div>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4"></div>
    <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
        <a href="{{ route('quality.list') }}" class="btn btn-primary btn-block" id="cancel">
            @lang('app.cancel')
        </a>
    </div>
</div>
<br>
<div class="row" id="divall" style = "display: none;">
   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
   	<div class="panel panel-default">
            <div class="panel-heading">@lang('app.download')</div>
            <div class="panel-body">
                <div class="form-group">
                    {!! Form::select('timespan', $timelist, '', ['id'=>'timespan', 'class'=>'form-control'])!!}
                </div>
                <div class="form-group">
					<button type="submit" class="btn btn-primary btn-block btnDownload">
            		<i class="fa fa-download"></i>
            		@lang('app.download')
        			</button>
				</div>
            </div>
         </div>
   </div>
</div>

<div class="row" id="divoption" style = "display: none;">
   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
   	<div class="panel panel-default">
            <div class="panel-heading">@lang('app.select_filter_option')</div>
            <div class="panel-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="vendor_id">@lang('app.project_Name')</label><br>
                    {!! Form::select('project_name', $projects_name, '', ['class'=>'form-control', 'id'=>'project_name']) !!}
                </div>
                <div class="form-group">
					<label for="employee_size">@lang('app.employee_size')</label> 
					{!!Form::select('employee_size', $codes,'', ['class'=>'form-control','id'=>'employee_size']) !!}
				</div>
				<div class="form-group">
					<label for="specialization">@lang('app.specialization')</label>
					<input type="text" class="form-control" id="specialization" name="specialization"
						placeholder="@lang('app.specialization')" value="">
				</div>
				<div class="form-group">
					<label for="state">@lang('app.state')</label> 
					<input type="text" class="form-control" id="state" name="state"
						placeholder="@lang('app.state')" maxlength="255" value="">
				</div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="project_id">@lang('app.project_code')</label><br>
                    {!! Form::select('project_code', $projects,'' ,['class' => 'form-control', 'id' => 'project_id']) !!}
                </div>
				<div class="form-group">
					<label for="industry_classfication">@lang('app.industry_classfication')</label>
					{!! Form::select('industry_classfication',$classfication ,'' , ['class'=>'form-control','id'=>'industry_classfication']) !!}
				</div>
				<div class="form-group">
					<label for="physician_size">@lang('app.physician_size')</label> 
					<input type="text" class="form-control" id="physician_size" name="physician_size"
						placeholder="@lang('app.physician_size')" maxlength="255" value="">
				</div>
				<input type="hidden" id="openModel">
            </div>
            <div class="form-group">
					<button type="submit" class="btn btn-primary btn-block btnDownload">
            		<i class="fa fa-download"></i>
            		@lang('app.download')
        			</button>
			</div>
           </div>
       </div>
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
$(document).ready(function() {
 	$("#divoption").hide();
 	$("#divall").hide();
 	
    $('input[type=radio][name=option]').change(function() {
        if (this.value == 'All') {
            	$("#divall").show();
            	$("#divoption").hide();
        }
        else if (this.value == 'Option') {
            $("#divoption").show();
            $("#divall").hide();
        }
    });

    $(".btnDownload").click(function(){
    	if($('#upload').val() == '')
		  {
		 	  $('#upload').css('border-color', 'red');
			  return false;
		  }else{
			  $('#upload').css('border-color', 'green');
			}
		  $("#conform").modal();
			$("#count").text("Are you sure to Download the data from Main Database?");
			$('#conform button').on('click', function(){
		       var confirm= $(this).attr('value');
		       if (confirm=='true') {   
		        	  $('#openModel').val('conform');
		        	  $(".btnDownload").click();
		       	   }
			 });
			 
		if ($('#openModel').val() == '') {
			return false;
		}else
		{
			$('#openModel').val('');
		}
    });

    $("#project_name").select2({
    	width: '100%',
    	placeholder: "Select a Project Name",
        allowClear: true
    });
    $("#project_id").select2({
        width: '100%',
        placeholder: "Select a Project Code",
        allowClear: true
    });
});
</script>

@stop