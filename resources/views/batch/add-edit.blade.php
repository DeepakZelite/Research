@extends('layouts.app')

@section('page-title', trans('app.batches'))

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            {{ $edit ? $batch->name : trans('app.create_new_batch') }}
            <small>{{ $edit ? trans('app.edit_batch_details') : trans('app.batch_details') }}</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('batch.list') }}">@lang('app.batches')</a></li>
                    <li class="active">{{ $edit ? trans('app.edit') : trans('app.create') }}</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['batch.update', $batch->id], 'method' => 'PUT','files' => true, 'id' => 'batch-form']) !!}
@else
    {!! Form::open(['route' => 'batch.store','files' => true, 'id' => 'batch-form']) !!}
@endif

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.batch_details_big')</div>
            <div class="panel-body">
            	<div class="form-group">
                    <label for="vendor_id">@lang('app.input_type')<i style="color:red;">*</i></label>
                    {!! Form::select('type_id', $type,'',
                        ['class' => 'form-control', 'id' => 'type_id']) !!}
                </div>
            	<div class="form-group">
                    <label for="vendor_id">@lang('app.vendor_code')<i style="color:red;">*</i></label>
                    {!! Form::select('vendor_id', $vendors, $edit ? $batch->vendor_id : '',
                        ['class' => 'form-control', 'id' => 'vendor_id']) !!}
                </div>
            	<div class="form-group">
                    <label for="project_id">@lang('app.project_code')<i style="color:red;">*</i></label>
                    {!! Form::select('project_id', $projects, $edit ? $batch->project_id : '',
                        ['class' => 'form-control', 'id' => 'project_id']) !!}
                </div>
                
                <div class="form-group">
                    <label for="name">@lang('app.batch_name')<i style="color:red;">*</i></label>
                    <input type="text" class="form-control" id="name" 
                           name="name" placeholder="@lang('app.batch_name')" value="{{ $edit ? $batch->name : old('name') }}" readonly="readonly" >
                </div>
		      <div class="form-group">
                    <label for="startdate">@lang('app.target_date')<i style="color:red;">*</i></label>
                    <div class="form-group">
							<div class='input-group date' id='target_date'>
								<input type='text' name="Target_Date" id='Target_Date' value="{{ $edit ? $batch->Target_Date : '' }}" class="form-control" />
								<span class="input-group-addon" style="cursor: default;">
                                <span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
					</div>
                </div>
                 <div class="form-group">
				  <label class="control-label" for="upload file">@lang('app.upload')<i style="color:red;">*</i></label>
 					<div class="input-group">
				    	<input type='text' name="upload" id='upload'  placeholder="@lang('select file')"  value="" class="form-control" />
				    	<span class="input-group-btn">
				    	<input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="file" id="attachement" name="attachement" style="display: none;" onchange="fileSelected(this)"/>
				    	<button class="btn btn-success" type="button"  id="btnAttachment" onclick="openAttachment()">@lang('app.upload')</button>
    					</span>
  					</div>
				</div>
                </div>
            </div>
        </div>
    </div>

<div class="row">
	<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2"></div>
    <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.update_batch') : trans('app.create_batch') }}
        </button>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
        <a href="{{ route('batch.list') }}" class="btn btn-primary btn-block" id="cancel">
            @lang('app.cancel')
        </a>
    </div>
</div>

@stop
@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop
@section('scripts')
<script>
var date=new Date();
date.setDate(date.getDate()-1);
$(function () {
    $('#target_date').datetimepicker({
					format: 'YYYY-MM-DD',
					minDate:date
						});
});
	function openAttachment() {
	  document.getElementById('attachement').click();
	}

	function fileSelected(input){
	  document.getElementById('upload').value =input.files[0].name
	}

    $("#vendor_id,#project_id").change(function() {
       var vendorId = $("#vendor_id").val();
       var projectId = $("#project_id").val();
       $.ajax({
           method: "GET",
           url: "{{ route('batch.getbatchName') }}",
           data: {vendorId:vendorId, projectId:projectId}
       })
       .done(function(data) {
			$("#name").val(data);
       });
   });
</script>
    @if ($edit)
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Batch\UpdateBatchRequest', '#batch-form') !!}
    @else
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Batch\CreateBatchRequest', '#batch-form') !!}
    @endif
    {!! HTML::script('assets/js/moment.min.js') !!}
    {!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
@stop