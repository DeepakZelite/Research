@extends('layouts.app') 

@section('page-title', trans('app.companys'))

@section('content') 

@include('partials.messages') 

<br />
<div class="row">
	<div class="col-lg-12 col-md-8 col-sm-6">
		<div class="col-md-7"></div>
		<div class="col-md-2 col-sm-6">
			<a href="#" class="btn btn-info" id="duplicate_check">
				@lang('app.duplicate_check') </a>
		</div>

		<div class="col-md-2 col-sm-6">
			<a href="#" class="btn btn-success" id="add_child_record" data-toggle="modal"
			data-target="#newCompanyModal"> <i
				class="glyphicon glyphicon-plus"></i> @lang('app.add_child_record')
			</a>
		</div>
		<div class="col-md-1">
			<a href="{{ URL::to('project/download',$projects->brief_file) }}" class="btn btn-primary" id="task_brief"> <i
				class="glyphicon glyphicon-info"></i> @lang('app.task_brief')
			</a>
		</div>
	</div>
</div>
<br />
@include('company.partials.company-edit')
<hr style="width: 100%; color: black; height: 1px; background-color: black;" />
<div class="row">
	<div class="col-md-11"></div>
	@if ($editCompany)
	<div class="col-md-1">
		<button type="button" class="btn btn-primary" data-toggle="modal"
			data-target="#myModal" onclick="addContact({{ $company->id }})">
			<i class="glyphicon glyphicon-plus"></i> {{ trans('app.add_contact')
			}}
		</button>
	</div>
	@endif
</div>
<br />
@if($editCompany)
<div class="row">
	<div class="table-responsive top-border-table" id="users-table-wrapper">
		<table class="table">
			<thead>
				<th>@lang('app.first_name')</th>
				<th>@lang('app.last_name')</th>
				<th>@lang('app.staff_email')</th>
				<th>@lang('app.job_title')</th>
				<th>@lang('app.action')</th>
			</thead>
			<tbody>
				@if (count($contacts)) 
				@foreach ($contacts as $contact)
				<tr>
					<td>{{ $contact->first_name }}</td>
					<td>{{ $contact->last_name }}</td>
					<td>{{ $contact->staff_email }}</td>
					<td>{{ $contact->job_title }}</td>
					<td class="text-left"><a href="#" 
						class="btn btn-primary btn-circle" data-toggle="modal" 
						data-target="#myModal" title="@lang('app.edit_contact')" onclick="editContact({{ $contact->id }});"
						data-toggle="tooltip" data-placement="top"> <i
							class="glyphicon glyphicon-edit"></i>
					</a></td>
				</tr>
				@endforeach 
				@else
				<tr>
					<td colspan="6"><em>@lang('app.no_records_found')</em></td>
				</tr>
				@endif
			</tbody>
		</table>

		{!! $contacts->render() !!}
	</div>
</div>
@endif

<div class="row">
	<div class="col-md-11"></div>

	<div class="col-md-1">
		<a href="{{ route('dataCapture.submitCompany', $company->id) }}"
			class="btn btn-primary btn-block pull-right">Submit</a>
	</div>
</div>


<!-- Modal -->
<style>
<!--
@media screen and (min-width: 768px) {
	#myModal .modal-dialog {
		width: 1200px;
	}
}
-->
</style>

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div id="editContact" class="modal-body">
 				@include('company.partials.contact-edit') 
			</div>
		</div>

	</div>
</div>

<div id="newCompanyModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div id="newCompany" class="modal-body">

<div class="row">
	<!--First Section-->
	<div class="col-lg-12 col-md-8 col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">@lang('app.add_child_company_details_big')</div>

			<div class="panel-body">
			<div class="row">
				<div class="form-group col-lg-12">
					<label for="new_company_name">@lang('app.company_name')<i
						style="color: red;">*</i></label> <input type="text"
						class="form-control" id="new_company_name" name="new_company_name"
						placeholder="@lang('app.company_name')"
						value="">
				</div>
				</div>
				<div class="row">
					<div class="col-md-8"></div>
					<div class="col-md-2">
						<button type="button" class="btn btn-primary">
							<i class="fa fa-save"></i> {{ trans('app.save') }}
						</button>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default" data-dismiss="modal">
							<i class=""></i> {{ trans('app.cancel') }}
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

@stop 

@section('scripts')

<script>

hideMenu();
function hideMenu() {
	as.toggleSidebar()
}

$('#myModal').on('shown.bs.modal', function() {
	  $('#firstName').focus();
	});
	
	$("#country").change(function() {
			 var batchId = $( this ).val();
             $.ajax({
                 method: "GET",
                 url: "http://localhost:88/Research/public/dataCapture/getcountryCode",
             })
	});
	$('#add_child_record').click(function(){
    $('#company_name').attr('readonly',false);
    $('#parent_company').attr('readonly',false);

	});
    </script>
@stop 

@section('styles') 
{!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!} 
@stop

@section('scripts') 

function hideMenu() {
	as.toggleSidebar()
}

@if ($editCompany) 
	{!! JsValidator::formRequest('Vanguard\Http\Requests\Company\UpdateCompanyRequest', '#company-form') !!} 
@else 
	{!! JsValidator::formRequest('Vanguard\Http\Requests\Company\CreateCompanyRequest', '#company-form') !!} 
@endif

@if ($editContact) 
	{!! JsValidator::formRequest('Vanguard\Http\Requests\Contact\UpdateContactRequest', '#staff-form') !!} 
@else 
	{!! JsValidator::formRequest('Vanguard\Http\Requests\Contact\CreateContactRequest', '#staff-form') !!} 
@endif
 

{!! HTML::script('assets/js/moment.min.js') !!} 
{!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
{!! HTML::script('assets/js/as/profile.js') !!} 


@stop
