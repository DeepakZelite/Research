@extends('layouts.app') 

@section('page-title', trans('app.companys'))

@section('content') 

@include('partials.messages') 

<br />

<!-- ----------------Company-edit-details start-------------- -->
@if ($editCompany) 
	{!! Form::open(['route' => ['dataCapture.updateCompany', $company->id], 'method' => 'PUT', 'id' => 'company-form']) !!} 
@else 
	{!! Form::open(['route' => ['dataCapture.storeCompany', $company->id], 'id' => 'company-form']) !!} 
@endif
<div class="row">
	<!--First Section-->
	<div class="col-lg-12 col-md-12 col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading" id='pan_head'>@lang('app.company_details_big')
			<div class="pull-right" style="margin-top: -7px;">
				<!-- <button type="button" class="btn btn-default">
      			<span class="glyphicon glyphicon-download"></span> Task Brief
    			</button> -->
    			<a href="{{ URL::to('project/download',$projects->brief_file) }}" class="btn btn-default" id="task_brief"> <i
				class="glyphicon glyphicon-download"></i> @lang('app.task_brief')
				</a>
			</div>
			<div class="pull-right" style="margin-top: -7px; margin-right:2px;">
				<button type="button" class="btn btn-default" id="add_child_record" data-toggle="modal"
				data-target="#newCompanyModal">
      			<span class="glyphicon glyphicon-plus"></span> @lang('app.add_child_company')
    			</button>
			</div>
			<div class="pull-right" style="margin-top: -7px;margin-right:2px;">
				<button type="button" class="btn btn-default">
      			<span class="glyphicon glyphicon-search"></span> Check
    			</button>
			</div>
			</div>
			 
			<div class="panel-body">
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.company_instructions')</label> <input
						type="text" class="form-control" id="company_instructions" readonly="readonly"
						name="company_instructions"	placeholder="@lang('app.company_instructions')"
						value="{{ $editCompany ? $company->company_instructions : old('company_instructions') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.parent_company')</label> <input
						type="text" class="form-control" id="parent_company"
						name="parent_company" placeholder="" readonly						
						value="{{ $editCompany ? $company->parent_company : old('parent_company') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="company_name">@lang('app.company_name')</label> 
					<input type="text" class="form-control" id="company_name" name="company_name"
						placeholder="@lang('app.company_name')" readonly="readonly"
						value="{{ $editCompany ? $company->company_name : old('company_name') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="updated_company_name">@lang('app.updated_company_name')<i
						style="color: red;">*</i></label> <input type="text"
						class="form-control" id="updated_company_name" name="updated_company_name"
						placeholder="@lang('app.company_name')"
						value="{{ $editCompany ? $company->updated_company_name : old('updated_company_name') }}">
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
						placeholder="@lang('app.city')" maxlength="20" required
						value="{{ $editCompany ? $company->city : old('city') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="state">@lang('app.state')<i style="color: red;">*</i></label>
					<input type="text" class="form-control" id="state" name="state"
						placeholder="@lang('app.state')" required
						value="{{ $editCompany ? $company->state : old('state') }}">
				</div>
				
				<div class="form-group col-lg-2">
					<label for="zipcode">@lang('app.zipcode')<i style="color: red;">*</i></label>
					<input type="text" class="form-control" id="zipcode" name="zipcode" required
						placeholder="@lang('app.zipcode')"  onkeypress="return isNumberKey(event)" maxlength="6"
						value="{{ $editCompany ? $company->zipcode : old('zipcode') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="address">@lang('app.country')<i style="color: red;">*</i></label>
					{!! Form::select('country', $countries,'840', ['class' =>
					'form-control','id'=>'country']) !!}
				</div>
				<div class="form-group col-lg-2">
					<label for="name">@lang('app.switchboardnumber')</label>
					<div class="row">
						<div class="col-md-5">
							<input type="text" id="isdcode" class="form-control" value="1">
						</div>
						<!-- <div class="col-md-6">{!! Form::select('international_code',
							$countriesISDCodes,'', ['class' =>
							'form-control','calling_code'=>'international_code']) !!}</div> -->
						<div class="col-md-7">
							<input type="text" class="form-control" id="switchboardnumber" 
								name="switchboardnumber" maxlength="10" onkeypress="return isNumberKey(event)"
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
						type="text" class="form-control" id="branchNumber" maxlength="5"
						name="branchNumber" placeholder="@lang('app.branchNumber')" onkeypress="return isNumberKey(event)"
						value="{{ $editCompany ? $company->branchNumber : old('branchNumber') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="addresscode">@lang('app.addresscode')</label> <input
						type="text" class="form-control" id="addresscode" 
						name="addresscode" placeholder="@lang('app.addresscode')" maxlength="20"
						value="{{ $editCompany ? $company->addresscode : old('addresscode') }}">
				</div>
				<div class="form-group col-lg-2">
					<label for="employee_size">@lang('app.employee_size')</label>
					{!! Form::select('employee_size', $codes,'', ['class' =>'form-control','id'=>'employee_size']) !!}
					<!--  <input type="text" class="form-control" id="employee_size" name="employee_size" placeholder="@lang('app.employee_size')"
						value="{{ $editCompany ? $company->employee_size : old('employee_size') }}">  -->
				</div>
				<div class="form-group col-lg-2">
					<label for="industry_classfication">@lang('app.industry_classfication')</label>
					 {!! Form::select('industry_classfication', $codes1,'', ['class' =>'form-control','id'=>'industry_classfication']) !!}
					<!-- <input type="text" class="form-control" id="industry_classfication" name="industry_classfication"
						placeholder="@lang('app.industry_classfication')" value="{{ $editCompany ? $company->industry_classfication : old('industry_classfication') }}"> -->
				</div>
				<div class="form-group col-lg-2">
					<label for="physician_size">@lang('app.physician_size')</label> <input
						type="text" class="form-control" id="physician_size" onkeypress="return isNumberKey(event)"
						name="physician_size" placeholder="@lang('app.physician_size')" maxlength="5"
						value="{{ $editCompany ? $company->physician_size : old('physician_size') }}">
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<!-- <div class="col-md-9"></div> -->
	<div class=" pull-right">
		<button type="button" id="add_contact" class="btn btn-primary" data-toggle="modal"
			data-target="#myModal" onclick="addContact({{ $company->id }})">
			<i class="glyphicon glyphicon-plus"></i> {{
			trans('app.add_contact') }}
		</button>
		<button type="button" id="additionalinfo" class="btn btn-primary" data-toggle="modal"
			data-target="#myModal1">
			<i class="glyphicon glyphicon-minus"></i> {{
			trans('app.additional-info') }}
		</button>
		<button type="submit" id="btnSave" class="btn btn-primary" >
			<i class="fa fa-save"></i> {{ $editCompany ? trans('app.save') :
			trans('app.save') }}
		</button>
	</div>
	
</div>



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
									<label for="company_remark">@lang('app.company_remark')</label>
									<input type="text" class="form-control" id="company_remark"
										name="company_remark"
										placeholder="@lang('app.company_remark')"
										value="{{ $editCompany ? $company->company_remark : old('company_remark') }}">
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
						<div class="col-md-10"></div>
						<div class="col-md-2">
							<button type="button" class="btn btn-default"
								data-dismiss="modal">
								<i class=""></i> {{ $editCompany ? trans('app.close') :
								trans('app.close') }}
							</button>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>





{{ Form::close() }}

<!-- ----------------Company-edit-details end-------------- -->

<hr style="width: 100%; color: black; height: 1px; background-color: black;" />

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
					<td>{{ $contact->staff_email}}</td>
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
			<!-- --------------contact-edit-start----------------- -->
			<!-- --------------contact-edit-start----------------- -->
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
			{!! Form::open(['route' => ['dataCapture.addCompany', $company->id], 'method' => 'PUT', 'id' => 'add-company-form']) !!} 
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
						<button type="submit" class="btn btn-primary">
							<i class="fa fa-save"></i> {{ trans('app.save') }}
						</button>
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-default" data-dismiss="modal">
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

<!-- --------------------------------------------------------------------------------------------------------------- -->

@stop 

@section('scripts')
<script>
hideMenu();
function hideMenu() {
	as.toggleSidebar();
}
$("#country").change(function() {
	 var batchId = $( this ).val();
 $.ajax({
     method: "GET",
     url: "http://localhost:88/Research/public/dataCapture/" + batchId + "/getcountryCode",
     data:{}
 })
 .done(function(data) {
		$("#isdcode").val(data);
 });
});
$(document).ready(function() {
	$('#updated_company_name').focus();
	$("#company-form").click(function(event)
	{
		$('#pan_head').click(function(e) {
		    e.stopPropagation();
		});
		if ($('#updated_company_name').val() == '') {
		    $('#updated_company_name').css('border-color', 'red');
		    //$('#address1').focus();
		    return false;
		}
		else {
		    $('#updated_company_name').css('border-color', 'green');
		}
		if ($('#address1').val() == '') {
		    $('#address1').css('border-color', 'red');
		    //$('#address1').focus();
		    return false;
		}
		else {
		    $('#address1').css('border-color', 'green');
		}
		if ($('#city').val() == '') {
		    $('#city').css('border-color', 'red');
		    //$('#city').focus();
		    return false;
		}
		else {
		    $('#city').css('border-color', 'green');
		}
		if ($('#state').val() == '') {
		    $('#state').css('border-color', 'red');
		   // $('#state').focus();
		    return false;
		}
		else {
		    $('#state').css('border-color', 'green');
		}
		
		if ($('#zipcode').val() == '') {
		    $('#zipcode').css('border-color', 'red');
		   // $('#zipcode').focus();
		    return false;
		}
		else {
		    $('#zipcode').css('border-color', 'green');
		}	

		$('#company_email').on('input', function() 
				{
					var input=$(this);
					var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
					var is_email=re.test(input.val());
					if(is_email){$('#company_email').css('border-color', 'green');}
					else
					{
						$('#company_email').css('border-color', 'red');
					}
				});

		$('#website').on('input', function() {
			var input=$(this);
			var re = /[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/;
			var is_url=re.test(input.val());
			if(is_url){$('#website').css('border-color', 'green');}
			else{$('#website').css('border-color', 'red');}
		});
		return true;
	});

		
});


function isNumberKey(evt)
{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
  			return false;
		return true;
}
$('#myModal').on('shown.bs.modal', function() {
	$('#first_name').focus();

});

function editContact(id) {
    $.ajax({
        method: "GET",
        //url: "{{route('dataCapture.getContact',$company->id)}}",
        url: "http://192.168.1.108:88/Research/public/dataCapture/" + id + "/getContact",
        success: function(data){
            $data = $(data); 
            $('#editContact').fadeOut().html($data).fadeIn();
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

$('#myModal').on('shown.bs.modal', function() {
	  $('#firstName').focus();
	});
	

  $('#add_child_record').click(function(){
  
	});


</script>
    @if ($editContact)
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Contact\UpdateContactRequest', '#staff-form') !!}
    @else
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Contact\CreateContactRequest', '#staff-form') !!}
    @endif

@if ($editCompany) 
	{!! JsValidator::formRequest('Vanguard\Http\Requests\Company\UpdateCompanyRequest', '#company-form') !!} 
@else 
	{!! JsValidator::formRequest('Vanguard\Http\Requests\Company\CreateCompanyRequest', '#company-form') !!} 
@endif
    
@stop

@section('scripts')
{!! HTML::script('assets/js/moment.min.js') !!} 
{!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
{!! HTML::script('assets/js/as/profile.js') !!} 
@stop
