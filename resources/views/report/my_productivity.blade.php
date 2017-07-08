@extends('layouts.app')

@section('page-title', trans('app.my_productivity_report'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @lang('app.my_productivity')
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
    {!! Form::open(['route' => 'report.searchReportList', 'method' => 'POST', 'id' => 'myproductivity-report-form']) !!}
        <div class="col-md-2">
             <div class="form-group">
				<div class='input-group date' id='start_date'>
					<input type='text' placeholder="@lang('app.from_date')" name="Start_Date" id='Start_Date' value="" class="form-control" />
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
        	<button type="submit" class="btn btn-success">
            @lang('app.go')
        	</button>
    	</div>
</div>

<div class="table-responsive top-border-table" id="users-table-wrapper1">
    <table class="table" id="example">
        <thead>
            <th>@lang('app.user_name')</th>
            <th>@lang('app.hour_spend')</th>
            <th>@lang('app.companies_processed')</th>
            <th>@lang('app.subsidiary_count')</th>
            <th>@lang('app.staff_processed')</th>
            <th class="text-center">@lang('app.record_per_hour')</th>
        </thead>
        <tbody>
        	@if(count($datas))
			    @foreach($datas as $data)
                    <tr>
                         <td>{{ $data->first_name }}  {{ $data->last_name }}</td>
                         <td>{{ $data->hrs }}</td>
                         <td>{{ $data->comp_count }}</td>
                         <td>{{ $data->subsidiary_count }} </td>
                         <td>{{ $data->no_rows }}</td>
                         <td class="text-center">{{ $data['per_hour'] }}</td>
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

@stop
@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
    <style>
  		div.dt-buttons {
   			float: right;
   			margin-left:20px;
		}
	</style>
@stop
@section('scripts')
<script>
var date=new Date();
$(function () {
    $('#start_date').datetimepicker({
					format: 'YYYY-MM-DD',
					maxDate:date
			});
    $('#expected_date').datetimepicker({
		format: 'YYYY-MM-DD',
		maxDate:date
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

	var table = $('#example').dataTable({
	    "bPaginate": false,
	    "bFilter": false,
	    "bInfo": false,
	    "bAutoWidth": false,
	    	dom: 'Bfrtip',
	        buttons: [{ extend: 'excelHtml5',text: '<i class="fa fa-file-excel-o fa-2x"></i>',titleAttr: 'Excel'}],		
		});
});
</script>
{!! HTML::script('assets/js/moment.min.js') !!}
{!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
@stop