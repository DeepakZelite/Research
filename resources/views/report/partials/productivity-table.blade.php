    <table class="table" id="productivity_table">
        <thead>
        	<th>@lang('app.vendor_code')</th>
            <th>@lang('app.user_name')</th>
            <th>@lang('app.hour_spend')</th>
            <th>@lang('app.companies_processed')</th>
            <th>@lang('app.staff_processed')</th>
            <th class="text-center">@lang('app.record_per_hour')</th>
        </thead>
        <tbody>
			@if(count($datas))
			    @foreach($datas as $data)
                    <tr>
                        <td>{{ $data->vendor_code }}</td>
                         <td>{{ $data->first_name }}  {{ $data->last_name }}</td>
                         <td>@if($data->hrs!=""){{ $data->hrs }}@else 0 @endif</td>
                         <td>@if($data->comp_count!=""){{ $data->comp_count }}@else 0 @endif</td>
                         <td>@if($data->no_rows!=""){{ $data->no_rows }}@else 0 @endif</td>
                         <td>{{ $data->per_hour }}</td>
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
        		<th><span id="perhour"></span></th>
        	</tr>
        </tfoot>
    </table>
    
<script>
$(document).ready(function() {
	   $('#productivity_table').dataTable({
	    "bPaginate": false,
	    "bFilter": false,
	    "bInfo": false,		
			"footerCallback": function ( row, data, start, end, display ) {
					var api = this.api(), data;	 
					// Remove the formatting to get integer data for summation
					var intVal = function ( i ) {
						return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
					};
					total_no_companies = api.column( 3 ).data().reduce( function (a, b) {
						return intVal(a) + intVal(b);
					},0 );
					
					total_staff_count = api.column( 4 ).data().reduce( function (a, b) {
						return intVal(a) + intVal(b);
					},0 );

					total_hourSpend_count = api.column( 2 ).data().reduce( function (a, b) {
						return intVal(a) + intVal(b);
					},0 );

					avg_per_hour = api.column( 5 ).data().reduce( function (a, b) {
						return intVal(a) + intVal(b);
					},0 );
					// Update footer
					$('#totalcompany').html(total_no_companies);
					$('#totalstaff').html(total_staff_count);	
					$('#hourspend').html(total_hourSpend_count);
					$('#perhour').html(avg_per_hour);
				},		
		});
	});
</script>