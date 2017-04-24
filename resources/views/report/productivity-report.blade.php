@extends('layouts.app')

@section('page-title', trans('app.productivity_report'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @lang('app.productivity_report')
            <!-- <small>@lang('app.list_of_batches')</small> -->
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.report')</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
     @if($show)
    <form method="GET" action="" accept-charset="UTF-8" id="productivity-report-form">
    	<div class="col-md-2">
                {!! Form::select('vendor_code', $vendors, Input::get('vendor_code'), ['id'=>'vendor_code', 'class'=>'form-control'])!!}
        </div>
 	 </form>
 	 @endif
 		<div class="col-md-2">
             	{!! Form::select('user_id', $users, Input::get('user'), ['class' => 'form-control', 'id' => 'user_id']) !!}
        </div>
        <div class="col-md-2">
             <div class="form-group">
				<div class='input-group date' id='start_date'>
					<input type='text' name="Start_Date" id='Start_Date' placeholder="@lang('app.from_date')"  value="" class="form-control" />
					<span class="input-group-addon" style="cursor: default;">
                    <span class="glyphicon glyphicon-calendar"></span>
					</span>
				</div>
			 </div>
       </div>
       <div class="col-md-2">
           <div class="form-group">
				<div class='input-group date' id='expected_date'>
					<input type='text' name="Expected_date" id='Expected_date' placeholder="@lang('app.to_date')" value="" class="form-control" />
						<span class="input-group-addon" style="cursor: default;">
                        <span class="glyphicon glyphicon-calendar"></span>
						</span>
				</div>
			</div>
        </div>
    	<div class="col-md-1">
    	<input type="button" id="btn_go" class="btn btn-success" value="@lang('app.go')" onclick="getRecord();"/>
    	</div>
</div>

<div class="table-responsive top-border-table" id="reportData">

<!--  Place it using ajax -->

    <table class="table" id="example">
        <thead>
        	<th>@lang('app.vendor_code')</th>
            <th>@lang('app.user_name')</th>
            <th>@lang('app.hour_spend')</th>
            <th>@lang('app.number_of_companies_processed')</th>
            <th>@lang('app.no_of_record_processed')</th>
            <th class="text-center">@lang('app.record_per_hour')</th>
        </thead>
        <tbody>
                <tr>
                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                </tr>
        </tbody>
    </table>

</div>

@stop
@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop
@section('scripts')
<script>
$(function () {
    $('#start_date').datetimepicker({
					format: 'YYYY-MM-DD',
			});
    $('#expected_date').datetimepicker({
		format: 'YYYY-MM-DD',
			});
});
$(document).ready(function() {
	$("#date").click(function(event)
			{
			var startdate=$("#Start_Date").val();
			var enddate=$("#Expected_date").val();
			if(startdate>enddate){
				$('#Expected_date').css('border-color', 'red');
				return false;
	     	}
			else{
					$('#Expected_date').css('border-color', 'green');
					return true;
				}	
	});
});

function getRecord()
{
	var $vendorId	= $("#vendor_code").val();
	var $userId = $("#user_id").val();
	var $startdate=$("#Start_Date").val();
	var $enddate=$("#Expected_date").val();
	$.ajax({
		method:"GET",
		url:"{{route('report.getProductivityReport')}}",
		data:{'vendorId':$vendorId,'userId':$userId,'fromDate':$startdate,'toDate':$enddate},
		success:function(data){
			$('#reportData').html(data).fadeIn();
		}
	});
}

$("#vendor_code").change(function() {
	$("#productivity-report-form").submit();
});
</script>
    {!! HTML::script('assets/js/moment.min.js') !!}
    {!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
@stop