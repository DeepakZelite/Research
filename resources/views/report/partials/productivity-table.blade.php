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
        		<th><span id="perhour"></span></th>
        	</tr>
        </tfoot>
    </table>
