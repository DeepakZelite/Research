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
 	 	<!-- {!! Form::open(['route' => 'report.getProductivityReport', 'id' => 'report-form1']) !!} 
 	 	<div> <input type="hidden" id="vendor_id" name="vendor_id" value="">
 	 	</div>
 	 	 -->
 		<div class="col-md-2">
             	{!! Form::select('user_id', $users, Input::get('user'), ['class' => 'form-control', 'id' => 'user_id']) !!}
        </div>
    	<div class="col-md-1">
    	<input type="button" id="btn_go" class="btn btn-success" value="@lang('app.go')" onclick="getRecord();"/>
        	<!-- <button type="submit" class="btn btn-success" id="btn_go" onclick="">
            @lang('app.go')
        	</button> -->
    	</div>
</div>

<div class="table-responsive top-border-table" id="users-table-wrapper1">
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
			@if(count($datas))
			    @foreach($datas as $data)
                    <tr>
                        <td>{{ $data['code'] }}</td>
                         <td>{{ $data['username'] }}</td>
                         <td>{{ $data['hour_spend'] }}</td>
                         <td>{{ $data['companies_processed'] }}</td>
                         <td>{{ $data['processed_record'] }}</td>
                         <td>{{ $data['per_hour'] }}</td>
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
        		<th></th>
        		<th><span id="hourspend"></span></th>
        		<th><span id ="totalcompany"></span></th>
        		<th><span id ="totalstaff"></span></th>
        		<th></th>
        	</tr>
        </tfoot>
    </table>
</div>

@stop

@section('scripts')
<script>
function getRecord()
{
	var $vendorId	= $("#vendor_code").val();
	var $userId = $("#user_id").val();
	var html = "";
    html += '';
	$.ajax({
		method:"GET",
		url:"{{route('report.getProductivityReport')}}",
		data:{'vendorId':$vendorId,'userId':$userId},
		success:function(data){
			$datas=$(data);
			var trHTML = '';
	        $.each(data, function (i, item) {
	            trHTML += '<tr><td>' + item.code + '</td><td>' + item.username + '</td><td>' + item.hour_spend + '</td><td>' + item.companies_processed + '</td><td>' + item.processed_record + '</td><td>' + item.per_hour + '</td></tr>';
	        });
	        $('#example tbody').append(trHTML);
			//foreach ($datas as $item) {
			//	html += "<tr><td>" + $item['code'] + "</td><td>" + $item['username'] + "</td></tr>"
			//}
			//$('#example tbody').fadeOut(function() {
			//    $('#example tbody').html(trhtml).fadeIn();
			//});
			//$('#users-table-wrapper1').fadeOut(function()
			//	{
			//		 $('#users-table-wrapper1').html($datas).fadeIn(); 
			//	});
			//$('#users-table-wrapper1').fadeOut().html($data).fadeIn();//.html($data).fadeIn();
			}
	})
}

$("#vendor_code").change(function() {
	$("#productivity-report-form").submit();
});

$(document).ready(function() {
   $('#example').dataTable({
    "bPaginate": false,
    "bFilter": false,
    "bInfo": false,		
		"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;	 
				// Remove the formatting to get integer data for summation
				var intVal = function ( i ) {
					return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
				};
				// total_salary over all pages
				total_no_companies = api.column( 3 ).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				
				total_staff_count = api.column( 4 ).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );

				total_hourSpend_count = api.column( 2 ).data().reduce( function (a, b) {
					return intVal(a) + intVal(b);
				},0 );
				// Update footer
				$('#totalcompany').html(total_no_companies);
				$('#totalstaff').html(total_staff_count);	
				$('#hourspend').html(total_hourSpend_count);
			},		
	});
});
</script>
@stop