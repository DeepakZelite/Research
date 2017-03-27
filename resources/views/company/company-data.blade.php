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
			<a href="#" class="btn btn-primary" id="task_brief"> <i
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
				<th>@lang('app.email')</th>
				<th>@lang('app.job_title')</th>
				<th>@lang('app.action')</th>
			</thead>
			<tbody>
				@if (count($contacts)) 
				@foreach ($contacts as $contact)
				<tr>
					<td>{{ $contact->first_name }}</td>
					<td>{{ $contact->last_name }}</td>
					<td>{{ $contact->email }}</td>
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
<!-- 				@include('company.partials.contact-edit') -->
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

<!-- --------------------------------------------------------------------------------------------------------------- -->

<div id="myModal1" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
				@if ($editCompany) 
					{!! Form::open(['route' => ['dataCapture.updateCompany', $company->id], 'method' => 'PUT', 'id' => 'company-form']) !!} 
				@else 
					{!! Form::open(['route' => 'dataCapture.storeCompany', 'id' => 'company-form']) !!} 
				@endif
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="panel panel-default">
							<div class="panel-heading">@lang('app.additional-info')</div>
							<div class="panel-body">
								<div class="form-group col-lg-6">
									<label for="company_remark">@lang('app.company_remark')</label>
									<input type="text" class="form-control" id="company_remark"
										name="company_remark"
										placeholder="@lang('app.company_remark')"
										value="{{ $editCompany ? $company->employee_size : old('company_remark') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="foundation_year">@lang('app.foundation_year')</label>
									<input type="text" class="form-control" id="foundation_year"
										name="foundation_year"
										placeholder="@lang('app.foundation_year')"
										value="{{ $editCompany ? $company->foundation_year : old('foundation_year') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="additional_info1">@lang('app.additional_info1')</label>
									<input type="text" class="form-control" id="additional_info1"
										name="additional_info1"
										placeholder="@lang('app.additional_info1')"
										value="{{ $editCompany ? $company->additional_info1 : old('additional_info1') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="additional_info2">@lang('app.additional_info2')</label>
									<input type="text" class="form-control" id="additional_info2"
										name="additional_info2"
										placeholder="@lang('app.additional_info2')"
										value="{{ $editCompany ? $company->additional_info2 : old('additional_info2') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="additional_info3">@lang('app.additional_info3')</label>
									<input type="text" class="form-control" id="additional_info3"
										name="additional_info3"
										placeholder="@lang('app.additional_info3')"
										value="{{ $editCompany ? $company->additional_info3 : old('additional_info3') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="additional_info4">@lang('app.additional_info4')</label>
									<input type="text" class="form-control" id="additional_info4"
										name="additional_info4"
										placeholder="@lang('app.additional_info4')"
										value="{{ $editCompany ? $company->additional_info4 : old('additional_info4') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="annual_revenue">@lang('app.annual_revenue')</label>
									<input type="text" class="form-control" id="annual_revenue"
										name="annual_revenue"
										placeholder="@lang('app.annual_revenue')"
										value="{{ $editCompany ? $company->annual_revenue : old('annual_revenue') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="products_services">@lang('app.products_services')</label>
									<input type="text" class="form-control" id="products_services"
										name="products_services"
										placeholder="@lang('app.products_services')"
										value="{{ $editCompany ? $company->products_services : old('products_services') }}">
								</div>

								<div class="form-group col-lg-6">
									<label for="number_of_beds">@lang('app.number_of_beds')</label>
									<input type="text" class="form-control" id="number_of_beds"
										name="number_of_beds"
										placeholder="@lang('app.number_of_beds')"
										value="{{ $editCompany ? $company->number_of_beds : old('number_of_beds') }}">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-7"></div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary">
								<i class="fa fa-save"></i> {{ $editCompany ? trans('app.save') :
								trans('app.save') }}
							</button>
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-default"
								data-dismiss="modal">
								<i class=""></i> {{ $editCompany ? trans('app.cancel') :
								trans('app.cancel') }}
							</button>
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
                 url: "http://localhost:88/vguard/public/dataCapture/getcountryCode",
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
