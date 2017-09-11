@include('partials.messages')

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">@lang('app.child_company_list_big')</div>
			<div class="panel-body">
				<div class="table-responsive top-border-table"
					id="users-table-wrapper">
					<table class="table">
						<thead>
							<th>@lang('app.company_name')</th>
						</thead>
						<tbody>
							@if (count($children)) 
							@foreach ($children as $child)
							<tr>
								<td><a href="#" onclick="moveContactToSubsidaries({{ $child->id }},{{ $contactId }});">{{ $child->company_name }}
								</a></td>
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