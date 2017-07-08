@extends('layouts.app')

@section('page-title', trans('app.status_report'))

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            @lang('app.project_status_report')
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
    <!-- <form method="GET" action="" accept-charset="UTF-8" id="batches-form"> -->
    {!! Form::open(['route' => 'report.getData', 'id' => 'report-form']) !!}
    		@if($show)
    		<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
                {!! Form::select('vendor_code', $vendors, Input::get('vendor_code'), ['id'=>'vendor_code', 'class'=>'form-control'])!!}
            </div>
            @endif
    	<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
                {!! Form::select('code', $projects, Input::get('code'), ['id'=>'code', 'class'=>'form-control'])!!}
        </div>
        <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
                {!! Form::select('name', $projects_name, Input::get('name'), ['id'=>'name', 'class'=>'form-control'])!!}
        </div>
    	<div class="col-xs-2 col-sm-2 col-md-1 col-lg-1">
        	<button type="submit" class="btn btn-success">
            @lang('app.go')
        	</button>
    	</div>
    <!-- </form> -->
</div>

<div class="table-responsive top-border-table" id="users-table-wrapper">
    <table class="table" id="example">
        <thead>
        	<th>@lang('app.vendor_code')</th>
            <th>@lang('app.project_code')</th>
            <th style="display:none;">@lang('app.project_name')</th>
            <th>@lang('app.batch_name')</th>
            <th>@lang('app.number_of_companies')</th>
            <th>@lang('app.staff_processed')</th>
            <th class="text-center">@lang('app.batch_status')</th>
        </thead>
        <tbody>
			@if (count($batches))
                @foreach ($batches as $batch)
                    <tr>
                        <td>{{ $batch->vendor_code }}</td>
                         <td>{{ $batch->code }}</td>
                         <td style="display:none;">{{ $batch->project_name }}</td>
                         <td>{{ $batch->name }}</td>
                         <td>{{ $batch->companies }}</td>
                         <td>{{ $batch->staff }}</td>
                         <td class="text-center">{{ $batch->status }}</td>
                     </tr>
                 @endforeach
             @else
                <tr>
                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                </tr>
             @endif
        </tbody>
        <tfoot>
        	<tr>
        		<th>@lang('app.total')</th>
        		<th colspan="2"></th>
        		<th><span id ="totalcompany"></span></th>
        		<th><span id ="totalstaff"></span></th>
        		<th></th>
        	</tr>
        </tfoot>
    </table>
</div>
@stop

@section('styles')
<style>
  div.dt-buttons {
   float: right;
   margin-left:20px;
}
</style>
@stop

@section('scripts')
<script>
$(document).ready(function() {
    var table = $('#example').dataTable({
    "bPaginate": false,
    "bFilter": false,
    "bInfo": false,
    "bAutoWidth": false,
    	dom: 'Bfrtip',
        buttons: [{ extend: 'excelHtml5',text: '<i class="fa fa-file-excel-o fa-2x"></i>',titleAttr: 'Excel'}],	
		"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
				};

				total_no_companies = api.column( 4 ).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				
				total_staff_count = api.column( 5 ).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );

				// Update footer
				$('#totalcompany').html(total_no_companies);
				$('#totalstaff').html(total_staff_count);		
			},		
	});	
});
</script>
@stop