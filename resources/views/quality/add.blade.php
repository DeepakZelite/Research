@extends('layouts.app')

@section('page-title', trans('app.QC_upload'))

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
        	@lang('app.upload_QC_data')
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="#">@lang('app.quality')</a></li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

{!! Form::open(['route' => 'quality.store','files' => true, 'id' => 'quality-form']) !!}

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.upload_QC_data')</div>
            <div class="panel-body">
                 <div class="form-group">
				  <label class="control-label" for="upload file">@lang('app.select_file')<i style="color:red;">*</i></label>
 					<div class="input-group">
				    	<input type='text' name="upload" id='upload'  placeholder="@lang('select file')"  value="" class="form-control" />
				    	<span class="input-group-btn">
				    	<input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="file" id="attachement" name="attachement" style="display: none;" onchange="fileSelected(this)"/>
				    	<button class="btn btn-success" type="button"  id="btnAttachment" onclick="openAttachment()">@lang('app.select_file')</button>
    					</span>
  					</div>
				</div>
				<input type="hidden" id="openModel" value=""> 
                </div>
            </div>
        </div>
    </div>

<div class="row">
	<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2"></div>
    <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
        <button type="submit" class="btn btn-primary btn-block" id="btnUpload">
            <i class="fa fa-save"></i>
            @lang('app.upload')
        </button>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
        <a href="{{ route('quality.list') }}" class="btn btn-primary btn-block" id="cancel">
            @lang('app.cancel')
        </a>
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
<script type="text/javascript">
	function openAttachment() {
	  document.getElementById('attachement').click();
	}

	function fileSelected(input){
	  document.getElementById('upload').value =input.files[0].name
	}

	$(document).ready(function() {
	  $("#btnUpload").click(function() {
		  if($('#upload').val() == '')
		  {
		 	  $('#upload').css('border-color', 'red');
			  return false;
		  }else{
			  $('#upload').css('border-color', 'green');
			}
		  $("#conform").modal();
			$("#count").text("Are you sure to upload the data in Main Database?");
			$('#conform button').on('click', function(){
		       var confirm= $(this).attr('value');
		       if (confirm=='true') {   
		        	  $('#openModel').val('conform');
		        	  $("#btnUpload").click();
		       	   }
			 });
			 
			if ($('#openModel').val() == '') {
				return false;
		 	}
	  });	
	});
</script>
    {!! HTML::script('assets/js/moment.min.js') !!}
    {!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
@stop