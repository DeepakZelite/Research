@extends('layouts.app') @section('page-title', trans('app.companys'))

@section('content') @include('partials.messages')

<br />

<!-- ----------------Company-edit-details start-------------- -->
@if ($editCompany) {!! Form::open(['route' =>['dataCapture.updateCompany', $company->id], 'method' => 'PUT', 'id' =>'company-form','autocomplete'=>'off']) !!} 
@else {!! Form::open(['route' =>['dataCapture.storeCompany', $company->id], 'id' => 'company-form']) !!}
@endif
<div class="row">
	<!--First Section-->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading" id='pan_head'>
				@lang('app.company_details_big')
				<div class="pull-right" style="margin-top: -7px;">
					<a href="{{ URL::to('project/download',$projects->brief_file) }}"
						class="btn btn-default" id="task_brief"> <i
						class="glyphicon glyphicon-download"></i> @lang('app.task_brief')
					</a>
				</div>
				<div class="pull-right" style="margin-top: -7px; margin-right: 2px;">
					<button type="button" class="btn btn-default" id="add_child_record"
						data-toggle="modal" data-target="#newCompanyModal">
						<span class="glyphicon glyphicon-plus"></span>
						@lang('app.add_child_company')
					</button>
				</div>
				<div class="pull-right" style="margin-top: -7px; margin-right: 2px;">
					<button type="button" class="btn btn-default" data-toggle="modal"
						data-target="#childrenModal" id="btn_check"
						onclick="getChildren({{ $company->id }});">
						<span class="glyphicon glyphicon-search"></span> @lang('app.subsidiary')
					</button>
				</div>
			</div>


			<div class="panel-body">
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.company_instructions')</label> <input
						type="text" class="form-control" id="company_instructions"
						readonly="readonly" name="company_instructions"
						placeholder="@lang('app.company_instructions')"
						value="{{ $editCompany ? $company->company_instructions : old('company_instructions') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.parent_company')</label> <input
						type="text" class="form-control" id="parent_company"
						name="parent_company" placeholder="" readonly
						value="{{ $editCompany ? $company->parent_company : old('parent_company') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="company_name">@lang('app.company_name')</label> <input
						type="text" class="form-control" id="company_name"
						name="company_name" placeholder="@lang('app.company_name')"
						readonly="readonly"
						value="{{ $editCompany ? $company->company_name : old('company_name') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="updated_company_name">@lang('app.updated_company_name')<i style="color: red;">*</i></label>
						 	<input type="text" class="form-control" id="updated_company_name" name="updated_company_name" placeholder="@lang('app.company_name')"
						 	@if($company->updated_company_name!="")	value="{{ $editCompany ? $company->updated_company_name : old('updated_company_name') }}" 
						 	@else value="{{ $editCompany ? $company->company_name : old('company_name') }}" @endif>
				</div>
				<div class="form-group col-lg-2">
					<label for="address1">@lang('app.address1')<i style="color: red;">*</i></label>
					<input type="text" class="form-control" id="address1" required
						name="address1" placeholder="@lang('app.address1')"
						value="{{ $editCompany ? $company->address1 : old('address1') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.address2')</label> <input type="text"
						class="form-control" id="address2" name="address2"
						placeholder="@lang('app.address2')"
						value="{{ $editCompany ? $company->address2 : old('address2') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="city">@lang('app.city')<i style="color: red;">*</i></label>
					<input type="text" class="form-control" id="city" name="city"
						placeholder="@lang('app.city')" maxlength="255" required
						value="{{ $editCompany ? $company->city : old('city') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="state">@lang('app.state')<i style="color: red;">*</i></label>
					<input type="text" class="form-control" id="state" name="state"
						placeholder="@lang('app.state')" required maxlength="255"
						value="{{ $editCompany ? $company->state : old('state') }}">
				</div>

				<div class="form-group col-lg-2">
					<label for="zipcode">@lang('app.zipcode')<i style="color: red;">*</i></label>
					<input type="text" class="form-control" id="zipcode" name="zipcode"
						required placeholder="@lang('app.zipcode')" maxlength="255"
						value="{{ $editCompany ? $company->zipcode : old('zipcode') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="address">@lang('app.country')<i style="color: red;">*</i></label>
					@if($company->country !='')
					{!! Form::select('country', $countries,$editCompany ? $company->country:old(''), ['class' =>'form-control','id'=>'country']) !!}
					@else
					{!! Form::select('country', $countries,'840', ['class'=>'form-control','id'=>'country']) !!}
					@endif
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.switchboardnumber')</label>
					<div class="row">
						<div class="col-md-5">
							<input type="text" id="isd_code" name="isd_code" class="form-control" @if($company->country !='') value="{{ $editCompany ? $company->isd_code : old('isd_code') }}" @else value="1" @endif>
						</div>
						<div class="col-md-7">
							<input type="text" class="form-control" id="switchboardnumber"
								name="switchboardnumber"
								placeholder="@lang('app.switchboardnumber')"
								value="{{ $editCompany ? $company->switchboardnumber : old('switchboardnumber') }}">
						</div>
					</div>
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.website')</label> <input type="text"
						class="form-control" id="website" name="website"
						placeholder="@lang('app.website')"
						value="{{ $editCompany ? $company->website : old('website') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.company_email')</label> <input
						type="text" class="form-control" id="company_email"
						name="company_email" placeholder="@lang('app.company_email')"
						value="{{ $editCompany ? $company->company_email : old('company_email') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="branchNumber">@lang('app.branchNumber')</label> <input
						type="text" class="form-control" id="branchNumber" 
						name="branchNumber" placeholder="@lang('app.branchNumber')"
						value="{{ $editCompany ? $company->branchNumber : old('branchNumber') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="addresscode">@lang('app.addresscode')<i style="color: red;">*</i></label> <input
						type="text" class="form-control" id="addresscode"
						name="addresscode" placeholder="@lang('app.addresscode')"
						value="{{ $editCompany ? $company->addresscode : old('addresscode') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="employee_size">@lang('app.employee_size')</label> 
					{!!Form::select('employee_size', $codes,$editCompany ? $company->employee_size : old('employee_size'), ['class'=>'form-control','id'=>'employee_size']) !!}
				</div>
				<div class="form-group col-lg-2">
					<label for="industry_classfication">@lang('app.industry_classfication')</label>
					{!! Form::select('industry_classfication', $classication, $editCompany ? $company->industry_classfication : old('industry_classfication'), ['class'=>'form-control','id'=>'industry_classfication']) !!}
				</div>
				<div class="form-group col-lg-2">
					<label for="prm">@lang('app.prm')</label> <input
						type="text" class="form-control" id="prm" name="prm"
						placeholder="@lang('app.prm')" 
						value="{{ $editCompany ? $company->prm : old('prm') }}">
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<!-- <div class="col-md-9"></div> -->
	<div class=" pull-right">
		<button type="button" id="add_contact" class="btn btn-primary"
			data-toggle="modal" data-target="#myModal"
			onclick="addContact({{ $company->id }})">
			<i class="glyphicon glyphicon-plus"></i> {{ trans('app.add_contact')
			}}
		</button>
		<button type="button" id="additionalinfo" class="btn btn-primary"
			data-toggle="modal" data-target="#myModal1">
			<i class="glyphicon glyphicon-minus"></i> {{
			trans('app.additional-info') }}
		</button>
		<button type="submit" id="btnSave" class="btn btn-primary">
			<i class="fa fa-save"></i> {{ $editCompany ? trans('app.save') :
			trans('app.save') }}
		</button>
	</div>

</div>


<!-- ------------------------------------------------- Additional info for Company edit Start ----------------------------------------------------- -->
<div id="myModal1" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="panel panel-default">
							<div class="panel-heading">@lang('app.additional-info')</div>
							<div class="panel-body">
								<div class="form-group col-lg-6">
									<label for="physician_size">@lang('app.physician_size')</label> 
									<input type="text" class="form-control" id="physician_size" name="physician_size"
											placeholder="@lang('app.physician_size')" maxlength="255"
											value="{{ $editCompany ? $company->physician_size : old('physician_size') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="company_remark">@lang('app.company_remark')</label>
									<input type="text" class="form-control" id="company_remark"
										name="company_remark"
										placeholder="@lang('app.company_remark')"
										value="{{ $editCompany ? $company->company_remark : old('company_remark') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="foundation_year">@lang('app.foundation_year')</label>
									<input type="text" class="form-control" id="foundation_year"
										name="foundation_year" placeholder="@lang('app.foundation_year')" maxlength="255"
										value="{{ $editCompany ? $company->foundation_year : old('foundation_year') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="annual_revenue">@lang('app.annual_revenue')</label>
									<input type="text" class="form-control" id="annual_revenue"
										name="annual_revenue" placeholder="@lang('app.annual_revenue')"
										value="{{ $editCompany ? $company->annual_revenue : old('annual_revenue') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="products_services">@lang('app.products_services')</label>
									<input type="text" class="form-control" id="products_services"
										name="products_services" placeholder="@lang('app.products_services')"
										value="{{ $editCompany ? $company->products_services : old('products_services') }}">
								</div>

								<div class="form-group col-lg-6">
									<label for="number_of_beds">@lang('app.number_of_beds')</label>
									<input type="text" class="form-control" id="number_of_beds"	name="number_of_beds" placeholder="@lang('app.number_of_beds')" maxlength="255"
										value="{{ $editCompany ? $company->number_of_beds : old('number_of_beds') }}">
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
									<label for="additional_info4">@lang('app.additional_info5')</label>
									<input type="text" class="form-control" id="additional_info5"
										name="additional_info5"
										placeholder="@lang('app.additional_info5')"
										value="{{ $editCompany ? $company->additional_info5 : old('additional_info5') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="additional_info4">@lang('app.additional_info6')</label>
									<input type="text" class="form-control" id="additional_info6"
										name="additional_info6"
										placeholder="@lang('app.additional_info6')"
										value="{{ $editCompany ? $company->additional_info6 : old('additional_info6') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="additional_info4">@lang('app.additional_info7')</label>
									<input type="text" class="form-control" id="additional_info7"
										name="additional_info7"
										placeholder="@lang('app.additional_info4')"
										value="{{ $editCompany ? $company->additional_info7 : old('additional_info7') }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="additional_info4">@lang('app.additional_info8')</label>
									<input type="text" class="form-control" id="additional_info8"
										name="additional_info8"
										placeholder="@lang('app.additional_info4')"
										value="{{ $editCompany ? $company->additional_info8 : old('additional_info8') }}">
								</div>
								<input type="hidden" id="openmodel" value=""/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-10"></div>
						<div class="col-md-2">
							<button type="button" class="btn btn-default"
								data-dismiss="modal">
								<i class=""></i> {{ $editCompany ? trans('app.close') : trans('app.close') }}
							</button>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ------------------------------------------------- Additional info for Company edit Start ----------------------------------------------------- -->
{{ Form::close() }}

<!-- ----------------Company-edit-details end-------------- -->

<hr  style="width: 100%; color: black; height: 1px; background-color: black;" />
<br />
<!-- ------------------------------------------------- Displaying Contact information dependent on company if record are present Start ----------------------------------------------------- -->
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
				@if (count($contacts)) @foreach ($contacts as $contact)
				<tr>
					<td>{{ $contact->first_name }}</td>
					<td>{{ $contact->last_name }}</td>
					<td>{{ $contact->staff_email}}</td>
					<td>{{ $contact->job_title }}</td>
					<td class="text-left"><a href="#"
						class="btn btn-primary btn-circle" data-toggle="modal"
						data-target="#myModal" title="@lang('app.edit_contact')"
						onclick="editContact({{ $contact->id }});" data-toggle="tooltip"
						data-placement="top"> <i class="glyphicon glyphicon-edit"></i>
					</a>
					<a href="{{ route('dataCapture.delete', $contact->id) }}" class="btn btn-danger btn-circle" title="@lang('app.delete_staff')"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-method="DELETE"
                                    data-confirm-title="@lang('app.please_confirm')"
                                    data-confirm-text="@lang('app.are_you_sure_delete_staff')"
                                    data-confirm-delete="@lang('app.yes')">
                                <i class="glyphicon glyphicon-trash"></i>
                    </a>
                    <a href="#" class="btn btn-primary btn-circle" data-toggle="modal"
						data-target="#moveModal" title="@lang('app.move_staff')"
						onclick="moveContact({{ $company->id }},{{ $contact->id }});" data-toggle="tooltip"
						data-placement="top"> <i class="glyphicon glyphicon-move"></i>
                    </a>
					</td>
				</tr>
				@endforeach @else
				<tr>
					<td colspan="6"><em>@lang('app.no_records_found')</em></td>
				</tr>
				@endif
			</tbody>
		</table>

		{!! $contacts->render() !!}
	</div>
</div>
<!-- ------------------------------------------------- Displaying Contact information dependent on company if record are present End ----------------------------------------------------- -->

<div class="row">
	<div class="col-md-10"></div>
	<div class="col-md-1">
	</div> 

	<div class="col-md-1">
	<button type="button" id="btnSubmit" class="btn btn-primary btn-block pull-right" onclick="submitCompany();">@lang('app.submit')</button>
	</div>	
</div>


<!-- Modal -->
<style>
@media screen and (min-width: 768px) {
	#myModal .modal-dialog {
		width: 1200px;
	}
	#duplicateModel .modal-dialog{width:1200px;}
	#conform .model-dialog{width:600px;}
	#moveModal .model-dialog{width:600px;}
	
}
</style>
<!-- ---------------------------- code for opening the contact Pop-Up Start------------------------------#duplicateModel .modal-content{ max-width:1300px; max-height:600px; overflow-y: auto;} -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div id="editContact" class="modal-body">
				<!-- --------------contact-edit-start----------------- -->
				<!-- --------------contact-edit-start----------------- -->
			</div>
		</div>

	</div>
</div>
<!-- ---------------------------- code for opening the contact Pop-Up End ------------------------------ -->
<!-- ---------------------------------- code for moving the staff Pop-up Start ------------------------------------ -->
<div id="moveModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="row">
		<div class="modal-content">
			<div id="moveContact" class="modal-body">@lang('app.loading')
			</div>
		</div>
		</div>
	</div>
</div>
<!-- --------------------------------- code for moving the staff Pop-up End ------------------------------------- -->

<!-- --------------------Child company list start----------------------- -->

<div id="childrenModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="row">
			<div class="modal-content">
				<div id="children" class="modal-body">@lang('app.loading')</div>
			</div>
		</div>
	</div>
</div>
<!-- --------------------Child compaby list end ------------------------ -->

<!-- --------------------Child company list start----------------------- -->

<div id="duplicateModel" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="row">
			<div class="modal-content">
				 <div id="duplicate" class="modal-body">@lang('app.loading')</div> 
			</div>
		</div>
	</div>
</div>
<!-- --------------------Child compaby list end ------------------------ -->
<div id="conform" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div id="newCompany" class="modal-body">
				<div class="row">
					<!--First Section-->
					<div class="col-lg-12 col-md-8 col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">Warning</div>
							<div class="panel-body">
								<div class="row">
									<div class="form-group col-lg-12">
										<label id="count"></label>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8"></div>
									<div class="col-md-2">
										<button type="button" class="btn btn-primary" id="btnOk" data-dismiss="modal">Ok
										</button>
									</div>
									<div class="col-md-2">
										<button type="button"  id="btnCancel" class="btn btn-secondary" data-dismiss="modal">Cancel
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
<!-- ---------------------------------------- add subsidiary button click code start --------------------------------------------- -->
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
								{!! Form::open(['route' => ['dataCapture.addCompany', $company->id], 'method' => 'PUT', 'id' => 'add-company-form']) !!}
								<div class="row">
									<div class="form-group col-lg-12">
										<label for="new_company_name">@lang('app.company_name')<i
											style="color: red;">*</i></label> <input type="text"
											class="form-control" id="new_company_name"
											name="new_company_name"
											placeholder="@lang('app.company_name')" value="">
									</div>
								</div>
								<div class="row">
									<div class="col-md-8"></div>
									<div class="col-md-2">
										<button type="submit" class="btn btn-primary" id="btnSave1">
											<i class="fa fa-save"></i> {{ trans('app.save') }}
										</button>
									</div>
									<div class="col-md-2">
										<button type="button" class="btn btn-default"
											data-dismiss="modal">
											<i class=""></i> {{ trans('app.cancel') }}
										</button>
									</div>
								</div>
								{{ Form::close() }}

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ---------------------------------------- add subsidiary button click code End -------------------------------------------------- -->

@stop 
@section('scripts')
<script>
hideMenu();
function hideMenu() {
	as.toggleSidebar();
	as.sidebartoggle();
}


$("#country").change(function() {
	 var batchId = $( this ).val();
	 var url = "{{ route('dataCapture.getcountryCode')}}";
	 url = url.replace("getcountryCode", batchId + "/getcountryCode") 
 $.ajax({
     method: "GET",
     url: url,
     data:{}
 })
 .done(function(data) {
		$("#isd_code").val(data);
 });
});

$(document).ready(function() {
	$(window).focus(function(){ 
		if(!localStorage.getItem('close'))
		{
			window.close();
		}
	});
	if($('#parent_company').val()!='')
	{
		$('#add_child_record').css("visibility", "hidden");
		$('#btn_check').css("visibility", "hidden");
	}
	
	
	// <!-- ------------------------------------- Client Side validation for Add Subsidory start ----------------------------------------------- -->
	$("#btnSave1").click(function(event)
	{
		if ($('#new_company_name').val() == '') {
			$('#new_company_name').css('border-color', 'red');
			return false;
		}
		else {
			$('#new_company_name').css('border-color', 'green');
		}
		return true;
	});
	// <!-- ------------------------------------- Client Side validation for Add Subsidory End ----------------------------------------------- -->
	// <!-- ------------------------------------- Client Side validation for Company Edit start ----------------------------------------------- -->
	$('#updated_company_name').focus();
	$("#btnSave").click(function(event)
	{
		if ($('#updated_company_name').val() == '') {
		    $('#updated_company_name').css('border-color', 'red');
		    return false;
		}
		else {
		    $('#updated_company_name').css('border-color', 'green');
		}
		if ($('#address1').val() == '') {
		    $('#address1').css('border-color', 'red');
		    return false;
		}
		else {
		    $('#address1').css('border-color', 'green');
		}
		if ($('#city').val() == '') {
		    $('#city').css('border-color', 'red');
		    return false;
		}
		else {
		    $('#city').css('border-color', 'green');
		}
		if ($('#state').val() == '') {
		    $('#state').css('border-color', 'red');
		    return false;
		}
		else {
		    $('#state').css('border-color', 'green');
		}
		
		if ($('#zipcode').val() == '') {
		    $('#zipcode').css('border-color', 'red');
		    return false;
		}
		else {
		    $('#zipcode').css('border-color', 'green');
		}
		
		if($('#addresscode').val() == ''){
			$('#addresscode').css('border-color', 'red');
		    return false;
		}else{
			$('#addresscode').css('border-color', 'green');
		}

		if($('#website').val() != '')
		{
			var re = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
			var re1 = /.[a-zA-Z]{2,3}$/;
			var is_url=$('#website').val();
			if(re.test(is_url))
			{
				$('#website').css('border-color', 'red');
		    	return false
			}
			else
			{
				$('#website').css('border-color', 'green');
			}
		}

		if($('#company_email').val() != '')
		{
			var regix = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
			var email= $('#company_email').val();
			if(!regix.test(email))
			{
				$('#company_email').css('border-color', 'red');
				return false;
			}
			else
			{
				$('#company_email').css('border-color', 'green');
			}
		}
		return true;
	});

	// <!-- ------------------------------------- Client Side validation for Company Edit End ----------------------------------------------- -->	
});

//<!-- --------------------------------------Client side validation for inputing only number Start ------------------------------------------------ -->
function isNumberKey(evt)
{
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57 || charcode == 86))
  			return false;
		return true;
}

var mod;
var numeric = $('#branchNumber,#switchboardnumber,#physician_size,#foundation_year,#number_of_beds').keydown(function(e){
  mod = e.which; 
  if(!((e.which >= 96 && e.which <= 105)||(e.which >= 48 && e.which <= 57)) && (e.which != 8 && e.which != 46 && e.which != 37 && e.which != 39 && e.which != 9 && e.which !=35 && e.which != 36) && (mod && (e.which == 67 || e.which != 86))){
      e.preventDefault();
  }
});
//<!-- --------------------------------------Client side validation for inputing only number End ------------------------------------------------ -->

$('#myModal').on('shown.bs.modal', function() {
	$('#first_name').focus();

});

function editContact(id) {
	var $contactId=id;
    $.ajax({
        method: "GET",
        url: "{{ route('dataCapture.getContact') }}",
        data:{'contactId':$contactId},
        success: function(data){
            $data = $(data); 
            $('#editContact').fadeOut().html($data).fadeIn();
            }
    })	
}

function moveContact(companyId,staffId){
	var $companyId = companyId;
	var $contactId = staffId;
	$.ajax({
		method: "GET",
		url: "{{ route('dataCapture.getSubsidaryCompany') }}",
		data: {'companyId':$companyId,'contactId':$contactId},
		success: function(data){
			$data = $(data);
			$('#moveContact').html($data).fadeIn();
		}
	})
}

function moveContactToSubsidaries(companyId,staffId)
{
	var $companyId = companyId;
	var $contactId = staffId;
	$.ajax({
		method: "GET",
		url: "{{ route('dataCapture.moveContact') }}",
		data: {'companyId':$companyId,'contactId':$contactId},
		success: function(data){
			window.location.reload();
		}
	})
}

function getChildren(id) {
    $.ajax({
        method: "GET",
        url:"{{ route('dataCapture.getChildren', $company->id) }}",
        success: function(data){
            $data = $(data); 
            $('#children').html($data).fadeIn();
            }
    })	
}
function getduplicateRecord()
{
	var $firstname	= $('#first_name').val();
	var $lastname 	= $('#last_name').val();
	var $jobtitle 	= $('#job_title').val();
	var $email	 	= $('#staff_email').val();
	var $company_name=$('#updated_company_name').val();
	var $website= $('#website').val();
	var $address= $('#address1').val();
	var $city	= $('#city').val();
	var $state	= $('#state').val();
	var $zipcode= $('#zipcode').val();
	var $specility=$('#specialization').val();
	var $phone	=$('#branchNumber').val();
	var $prm 	=$('#prm').val();
	$.ajax({
		method:"GET",
		url:"{{route('dataCapture.getduplicateRecord')}}",
		data:{'firstname':$firstname,'lastname':$lastname,'jobtitle':$jobtitle,'email':$email,'company_name':$company_name,'website':$website,'address':$address,'city':$city,'state':$state,'zipcode':$zipcode,'specility':$specility,'phone':$phone,'prm':$prm},
		success:function(data){
			$data=$(data);
			$('#duplicate').html($data).fadeIn();
			}
	})
}
function addContact(companyId) {
    $.ajax({
        method: "GET",
        url: "{{ route('dataCapture.createContact', $company->id) }}",
        success: function(data){
            $data = $(data); 
            $('#editContact').html($data).fadeIn();
            }
    })	
}

function submitCompany()
{
	var count=0;
	var a="";
	var val= 0;
	@foreach ($contacts as $contact)
		@if($contact->updated_at == '')
			count++;
		@endif 
	@endforeach
	if(count>0)
	{
		$("#conform").modal();
		$("#btnCancel").css('visibility','hidden');
		$("#count").text("There are "+ count +" staff record(s) are pending to process. It is recommended to process pending staff record(s) before you submit the company.");
        return false;
	}else
	{
		if($('#openmodel').val() == '')
		{
			$("#conform").modal();
			$("#count").text("Are you sure you want to Submit this record?");
			$("#btnOk").click(function(){
				$('#openmodel').val('conform');
				submitCompany();
			});
		}
	}	
 		
 	if ($('#openmodel').val() == '') {
 	    return false;
 	}
		
	if ($('#updated_company_name').val() == '') {
	    $('#updated_company_name').css('border-color', 'red');
	    return false;
	}
	else {
	    $('#updated_company_name').css('border-color', 'green');
	}
	if ($('#address1').val() == '') {
	    $('#address1').css('border-color', 'red');
	    return false;
	}
	else {
	    $('#address1').css('border-color', 'green');
	}
	if ($('#city').val() == '') {
	    $('#city').css('border-color', 'red');
	    return false;
	}
	else {
	    $('#city').css('border-color', 'green');
	}
	if ($('#state').val() == '') {
	    $('#state').css('border-color', 'red');
	    return false;
	}
	else {
	    $('#state').css('border-color', 'green');
	}
	
	if ($('#zipcode').val() == '') {
	    $('#zipcode').css('border-color', 'red');
	    return false;
	}
	else {
	    $('#zipcode').css('border-color', 'green');
	}

	if($('#addresscode').val() == ''){
		$('#addresscode').css('border-color', 'red');
	    return false;
	}else{
		$('#addresscode').css('border-color', 'green');
	}
	
	if($('#website').val() != '')
	{
		var re = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
		var re1 = /.[a-zA-Z]{2,3}$/;
		var is_url=$('#website').val();
		if(re.test(is_url))
		{
			$('#website').css('border-color', 'red');
	    	return false
		}
		else
		{
			$('#website').css('border-color', 'green');
		}
	}

	if($('#company_email').val() != '')
	{
		var regix = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		var email= $('#company_email').val();
		if(!regix.test(email))
		{
			$('#company_email').css('border-color', 'red');
			return false;
		}
		else
		{
			$('#company_email').css('border-color', 'green');
		}
	}
	var $updated_company_name = $('#updated_company_name').val();
	var $address1=$('#address1').val();
	var $address2=$('#address2').val();
	var $city=$('#city').val();
	var $state=$('#state').val();
	var $zipcode=$('#zipcode').val();
	var $country=$('#country').val();
	var $isd_code=$('#isd_code').val();
	var $switchboardnumber=$('#switchboardnumber').val();
	var $website = $('#website').val();
	var $company_email = $('#company_email').val();
	var $branchNumber = $('#branchNumber').val();
	var $addresscode = $('#addresscode').val();
	var $employee_size = $('#employee_size').val();
	var $industry_classfication = $('#industry_classfication').val();
	var $prm = $('#prm').val();
	var $physician_size = $('#physician_size').val();
	var $company_remark = $('#company_remark').val();
	var $foundation_year = $('#foundation_year').val();
	var $annual_revenue = $('#annual_revenue').val();
	var $products_services = $('#products_services').val();
	var $number_of_beds = $('#number_of_beds').val();
	var $additional_info1 = $('#additional_info1').val();
	var $additional_info2 = $('#additional_info2').val();
	var $additional_info3 = $('#additional_info3').val();
	var $additional_info4 = $('#additional_info4').val();
	
	$.ajax({
		method:"GET",
		url:"{{ route('dataCapture.submitCompany', $company->id) }}",
		data:{'updated_company_name':$updated_company_name,'address1':$address1,'address2':$address2,'city':$city,'state':$state,'zipcode':$zipcode,'country':$country,'isd_code':$isd_code,'switchboardnumber':$switchboardnumber,'website':$website,'company_email':$company_email,'branchNumber':$branchNumber,'addresscode':$addresscode,'employee_size':$employee_size,'industry_classfication':$industry_classfication,'prm':$prm,'physician_size':$physician_size,'company_remark':$company_remark,'foundation_year':$foundation_year,'annual_revenue':$annual_revenue,'products_services':$products_services,'number_of_beds':$number_of_beds,'additional_info1':$additional_info1,'additional_info2':$additional_info2,'additional_info3':$additional_info3,'additional_info4':$additional_info4},
		success:function(data){
			 window.location.reload(); 
			}
	})
}
$('#myModal').on('shown.bs.modal', function() {
	  $('#firstName').focus();
	});
	
  $('#add_child_record').click(function(){
	});
</script>


@if ($editContact) 
		{!! JsValidator::formRequest('Vanguard\Http\Requests\Contact\UpdateContactRequest','#staff-form') !!}
@else 
		{!! JsValidator::formRequest('Vanguard\Http\Requests\Contact\CreateContactRequest','#staff-form') !!} 
@endif 

@if($editCompany) 
		{!! JsValidator::formRequest('Vanguard\Http\Requests\Company\UpdateCompanyRequest','#company-form') !!} 
@else 
		{!! JsValidator::formRequest('Vanguard\Http\Requests\Company\CreateCompanyRequest','#company-form') !!} 
@endif 
@stop 

@section('scripts') 
		{!! HTML::script('assets/js/moment.min.js') !!} 
		{!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!} 
		{!! HTML::script('assets/js/as/profile.js') !!} 
@stop
