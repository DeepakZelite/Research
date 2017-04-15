
@include('partials.messages')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">@lang('app.duplicate_contact_list')</div>
			<div class="panel-body">
				<div class="table-responsive top-border-table"
					id="users-table-wrapper">
					<table class="table">
						<thead>
							<th>@lang('app.company_name')</th>
							<th>@lang('app.website')</th>
							<th>@lang('app.firstname')</th>
							<th>@lang('app.lastname')</th>
							<th>@lang('app.job_title')</th>
							<th>@lang('app.staff_email')</th>
							<th>@lang('app.city')</th>
							<th>@lang('app.address1')</th>
							<th>@lang('app.state')</th>
							<th>@lang('app.zipcode')</th>
						</thead>
						<tbody>
							@if(count($duplicate)) 
							@foreach ($duplicate as $contact)
							<tr>
								<td>{{ $contact->company_name }}</td>
								<td>{{ $contact->website }}</td>
								<td>{{ $contact->first_name }}</td>
								<td>{{ $contact->last_name }}</td>
								<td>{{ $contact->job_title }}</td>
								<td>{{ $contact->staff_email }}</td>
								<td>{{ $contact->city }}</td>
								<td>{{ $contact->address1 }}<td>
								<td>{{ $contact->state }}</td>
								<td>{{ $contact->zipcode }}</td>
							</tr>
							@endforeach @else
							<tr>
								<td colspan="6"><em>@lang('app.no_records_found')</em></td>
							</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10"></div>
		<div class="col-md-1">
			<button type="button" id="btnCloseChildren" class="btn btn-default" data-dismiss="modal"> <i class=""></i> 
			@lang('app.close')
			</button>
		</div>
	</div>
</div>
