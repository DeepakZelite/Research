@extends('layouts.app')

@section('page-title', trans('app.companys'))

@section('content')

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['dataCapture.storeCompany', $company->id], 'method' => 'PUT', 'id' => 'company-form']) !!}
@else
    {!! Form::open(['route' => 'dataCapture.storeCompany', 'id' => 'company-form']) !!}
@endif

<br/>
<div class="row">
    <!--First Section-->
    <div class="col-lg-12 col-md-8 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')
            </div>
            
            <div class="panel-body">
                <div class="form-group col-lg-2">
                    <label for="company_name">@lang('app.company_name')<i style="color:red;">*</i></label>
                    <input type="text" class="form-control" id="company_name"
                           name="company_name" placeholder="@lang('app.company_name')" value="{{ $edit ? $company->company_name : old('company_name') }}">
                </div>
                <div class="form-group col-lg-2">
                   <label for="name">@lang('app.child_company')</label>
                   <input type="text" class="form-control" id="parent_company" 
                            name="parent_company" placeholder="@lang('app.child_company')" value="{{ $edit ? $company->parent_company : old('parent_company') }}"> 
                </div>
                <div class="form-group col-lg-2">
                   <label for="name">@lang('app.company_instructions')</label>
                   <input type="text" class="form-control" id="company_instructions" 
                            name="company_instructions" placeholder="@lang('app.company_instructions')" value="{{ $edit ? $company->company_instructions : old('company_instructions') }}"> 
                </div> 
                 
                <div class="form-group col-lg-2"> 
                    <label for="address1">@lang('app.address1')<i style="color:red;">*</i></label> 
                    <input type="text" class="form-control" id="address1" 
                           name="address1" placeholder="@lang('app.address1')" value="{{ $edit ? $company->address1 : old('address1') }}"> 
                 </div> 
                 <div class="form-group col-lg-2"> 
                     <label for="name">@lang('app.address2')</label> 
                     <input type="text" class="form-control" id="address2" 
                            name="address2" placeholder="@lang('app.address2')" value="{{ $edit ? $company->address2 : old('address2') }}"> 
                 </div> 
                 <div class="form-group col-lg-2"> 
                     <label for="city">@lang('app.city')<i style="color:red;">*</i></label> 
                     <input type="text" class="form-control" id="city" 
                           name="city" placeholder="@lang('app.city')" value="{{ $edit ? $company->city : old('city') }}"> 
                 </div> 
                 <div class="form-group col-lg-2"> 
                     <label for="state">@lang('app.state')<i style="color:red;">*</i></label> 
                     <input type="text" class="form-control" id="state" 
                            name="state" placeholder="@lang('app.state')" value="{{ $edit ? $company->state : old('state') }}"> 
                </div> 
                <div class="form-group col-lg-2"> 
                     <label for="zipcode">@lang('app.zipcode')<i style="color:red;">*</i></label> 
                     <input type="text" class="form-control" id="zipcode" 
                           name="zipcode" placeholder="@lang('app.zipcode')" value="{{ $edit ? $company->zipcode : old('zipcode') }}"> 
               </div> 
               <div class="form-group col-lg-2">
                    <label for="address">@lang('app.country')<i style="color:red;">*</i></label>
                    {!! Form::select('country', $countries,'', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-lg-2">
                    <label for="name">@lang('app.switchboardnumber')</label>
                    <div class="row">
                    <div class="col-md-5">
                	{!! Form::select('country', $countries1,'', ['class' => 'form-control']) !!}</div>
                	<div class="col-md-7">
                     <input type="text" class="form-control" id="switchboardnumber" 
                            name="switchboardnumber" placeholder="@lang('app.switchboardnumber')" value="{{ $edit ? $company->switchboardnumber : old('switchboardnumber') }}"></div>
                 	</div>
                 </div>
                  <div class="form-group col-lg-2">
                    <label for="name">@lang('app.website')</label>
                    <input type="text" class="form-control" id="website"
                           name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('website') }}">
                </div>
                <div class="form-group col-lg-2"> 
                    <label for="name">@lang('app.company_email')</label>
                    <input type="text" class="form-control" id="company_email" 
                          name="company_email" placeholder="@lang('app.company_email')" value="{{ $edit ? $company->company_email : old('company_email') }}">
               </div>
                 <div class="form-group col-lg-2"> 
                     <label for="branchNumber">@lang('app.branchNumber')</label> 
                     <input type="text" class="form-control" id="branchNumber"
                            name="branchNumber" placeholder="@lang('app.branchNumber')" value="{{ $edit ? $company->branchNumber : old('branchNumber') }}"> 
                 </div> 
                 <div class="form-group col-lg-2"> 
                     <label for="addresscode">@lang('app.addresscode')</label> 
                     <input type="text" class="form-control" id="addresscode"
                            name="addresscode" placeholder="@lang('app.addresscode')" value="{{ $edit ? $company->addresscode : old('addresscode') }}">
                 </div>
			     <div class="form-group col-lg-2">
                     <label for="employee_size">@lang('app.employee_size')</label> 
                     <input type="text" class="form-control" id="employee_size" 
                            name="employee_size" placeholder="@lang('app.employee_size')" value="{{ $edit ? $company->employee_size : old('employee_size') }}">
                 </div>
                 <div class="form-group col-lg-2">
                     <label for="industry_classfication">@lang('app.industry_classfication')</label>
                     <input type="text" class="form-control" id="industry_classfication"
                            name="industry_classfication" placeholder="@lang('app.industry_classfication')" value="{{ $edit ? $company->industry_classfication : old('industry_classfication') }}">
                 </div>
                 <div class="form-group col-lg-2">
                     <label for="physician_size">@lang('app.physician_size')</label> 
                     <input type="text" class="form-control" id="physician_size"
                            name="physician_size" placeholder="@lang('app.physician_size')" value="{{ $edit ? $company->physician_size : old('physician_size') }}"> 
                 </div>
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
               
              </div>
            </div>
        </div>
    </div>

<div class="row">
<div class="col-md-9">
</div>
    <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal1">
            <i class="glyphicon glyphicon-plus"></i>
            {{ trans('app.additional-info') }}
        </button>
    </div>
    <div class="col-md-1">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.save') : trans('app.save') }}
        </button>
    </div>
</div>
{{ Form::close() }}
<hr style="width: 100%; color: black; height: 1px; background-color:black;"/>
<div class="row">
<div class="col-md-10">
</div>
    @if ($edit)
    <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">
            <i class="glyphicon glyphicon-plus"></i>
            {{ trans('app.add_contact') }}
        </button>
    </div>
    @endif
</div>
<br/>
<div class="row">
<div class="table-responsive top-border-table" id="users-table-wrapper">
    <table class="table">
        <thead>
        	<th>@lang('app.first_name')</th>
            <th>@lang('app.last_name')</th>
            <th>@lang('app.email')</th>
            <th>@lang('app.designation')</th>
            <th>@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($contacts))
                @foreach ($contacts as $contact)
                    <tr>
                         <td>{{ $contact->first_name }}</td>
                         <td>{{ $contact->last_name }}</td>
                         <td>{{ $contact->email }}</td>
                         <td>{{ $contact->designation }}</td>
                         <td class="text-left">
                             <a href="#" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#myModal"
                                title="@lang('app.edit_batch')" data-toggle="tooltip" data-placement="top"> 
                                 <i class="glyphicon glyphicon-edit"></i>
                            </a>
           				</td>
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


<div class="row">
<div class="col-md-11">
</div>

    <div class="col-md-1">
    <a href="{{ route('dataCapture.submitCompany', $company->id) }}" class="btn btn-primary btn-block pull-right">Submit</a>
    </div>
</div>


<!-- Modal -->
<style>
<!--
 @media screen and (min-width: 768px) { 
	
 	#myModal .modal-dialog  {width:1200px;} 

 } 
-->
</style>

 @if ($edit)
  {!! Form::open(['route' => ['dataCapture.storeStaff', $company->id], 'id' => 'staff-form']) !!} 
<!--          {!! Form::open(['route' => ['dataCapture.storeStaff', $company->id], 'id' => 'staff-form']) !!}  -->
 @else
    
         {!! Form::open(['route' => ['dataCapture.storeStaff', $company->id], 'method' => 'PUT', 'id' => 'staff-form']) !!} -->
    
@endif

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.staff_details_big')</div>
            <div class="panel-body">
            
     	<div class="container">
  			<ul class="nav nav-tabs">
    			<li class="active"><a data-toggle="pill" href="#staff_info">@lang('app.staff_info')</a></li>
    			<li><a data-toggle="pill" href="#additional_info">@lang('app.additional-info')</a></li>
  			</ul>
  
  			<div class="tab-content">
    		<div id="staff_info" class="tab-pane fade in active">
                <div class="form-group col-lg-4">
                    <label for="firstName">@lang('app.first_name')<i style="color:red;">*</i></label>
                    <div class="row">
                    <div class="col-md-3" >
						<select class="form-control" id="salutation" name="salutation">
						  <option value="Mr.">Mr.</option>
						  <option value="Mrs.">Mrs.</option>
						  <option value="Miss">Miss</option>
						  <option value="Dr.">Dr.</option>
						  <option value="Ms.">Ms.</option>
						  <option value="Prof.">Prof.</option>
						</select>
                    </div>
                    <div class="col-md-9">
                    <input type="text" class="form-control" id="first_name"
                           name="first_name" placeholder="@lang('app.first_name')" value=""></div>
                	</div>
                </div>
                <div class="form-group col-lg-4">
                    <label for="middleName">@lang('app.middle_name')</label>
                    <input type="text" class="form-control" id="middle_name"
                           name="middle_name" placeholder="@lang('app.middle_name')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="name">@lang('app.last_name')</label>
                    <input type="text" class="form-control" id="last_name"
                           name="last_name" placeholder="@lang('app.last_name')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="job_title">@lang('app.job_title')<i style="color:red;">*</i></label>
                    <input type="text" class="form-control" id="job_title"
                           name="job_title" placeholder="@lang('app.job_title')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="specialization">@lang('app.specialization')</label>
                    <input type="text" class="form-control" id="specialization"
                           name="specialization" placeholder="@lang('app.specialization')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="staff_source">@lang('app.staff_source')</label>
                    <input type="text" class="form-control" id="staff_source"
                           name="staff_source" placeholder="@lang('app.staff_source')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="staff_emaile">@lang('app.staff_email')</label>
                    <input type="text" class="form-control" id="staff_email"
                           name="staff_email" placeholder="@lang('app.staff_email')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="direct_phoneno">@lang('app.direct_phoneno')</label>
                    <input type="text" class="form-control" id="direct_phoneno"
                           name="direct_phoneno" placeholder="@lang('app.direct_phoneno')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="email_source">@lang('app.email_source')</label>
                    <input type="text" class="form-control" id="email_source"
                           name="email_source" placeholder="@lang('app.email_source')" value="">
                </div>
    		</div>
    		<div id="additional_info" class="tab-pane fade">
     			<div class="form-group col-lg-4">
                    <label for="qualification">@lang('app.qualification')</label>
                    <input type="text" class="form-control" id="qualification"
                           name="qualification" placeholder="@lang('app.qualification')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="deparment_number">@lang('app.deparment_number')</label>
                    <input type="text" class="form-control" id="deparment_number"
                           name="deparment_number" placeholder="@lang('app.deparment_number')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="alternate_phone">@lang('app.alternate_phone')</label>
                    <input type="text" class="form-control" id="alternate_phone"
                           name="alternate_phone" placeholder="@lang('app.alternate_phone')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="alternate_email">@lang('app.alternate_email')</label>
                    <input type="text" class="form-control" id="alternate_email"
                           name="alternate_email" placeholder="@lang('app.alternate_email')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="email_type">@lang('app.email_type')</label>
                    <input type="text" class="form-control" id="email_type"
                           name="email_type" placeholder="@lang('app.email_type')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="shift_timing">@lang('app.shift_timing')</label>
                    <input type="text" class="form-control" id="shift_timing"
                           name="shift_timing" placeholder="@lang('app.shift_timing')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="working_tenure">@lang('app.working_tenure')</label>
                    <input type="text" class="form-control" id="working_tenure"
                           name="working_tenure" placeholder="@lang('app.working_tenure')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="paternership">@lang('app.paternership')</label>
                    <input type="text" class="form-control" id="paternership"
                           name="paternership" placeholder="@lang('app.paternership')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="staff_remarks">@lang('app.staff_remarks')</label>
                    <input type="text" class="form-control" id=staff_remarks"
                           name="staff_remarks" placeholder="@lang('app.staff_remarks')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="age">@lang('app.age')</label>
                    <input type="text" class="form-control" id="age"
                           name="age" placeholder="@lang('app.age')" value="">
                </div>
				<div class="form-group col-lg-4">
                    <label for="additional_info1">@lang('app.contact_info1')</label>
                    <input type="text" class="form-control" id="additional_info1"
                           name="additional_info1" placeholder="@lang('app.contact_info1')" value="">
				</div>
				<div class="form-group col-lg-4">
                    <label for="additional_info2">@lang('app.contact_info2')</label>
                    <input type="text" class="form-control" id="additional_info2"
                           name="additional_info2" placeholder="@lang('app.contact_info2')" value="">
                </div>
				<div class="form-group col-lg-4">
                    <label for="additional_info3">@lang('app.contact_info3')</label>
                    <input type="text" class="form-control" id="additional_info3"
                           name="additional_info3" placeholder="@lang('app.contact_info3')" value="">
                </div>
                <div class="form-group col-lg-4">
                    <label for="additional_info4">@lang('app.contact_info4')</label>
                    <input type="text" class="form-control" id="additional_info4"
                           name="additional_info4" placeholder="@lang('app.contact_info4')" value="">
                </div>
    		</div>

  			</div>
		</div>
            
                
              </div>
            </div>
        </div>
    </div>

<div class="row">
<div class="col-md-8"></div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.save') : trans('app.save') }}
        </button>
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class=""></i>
            {{ $edit ? trans('app.cancel') : trans('app.cancel') }}
        </button>
    </div>
</div>

{{ Form::close() }}
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
@if ($edit)
    {!! Form::open(['route' => ['dataCapture.storeCompany', $company->id], 'method' => 'PUT', 'id' => 'company-form']) !!}
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
                           name="company_remark" placeholder="@lang('app.company_remark')" value="{{ $edit ? $company->employee_size : old('company_remark') }}">
                </div>
                <div class="form-group col-lg-6">
                    <label for="foundation_year">@lang('app.foundation_year')</label>
                    <input type="text" class="form-control" id="foundation_year"
                           name="foundation_year" placeholder="@lang('app.foundation_year')" value="{{ $edit ? $company->foundation_year : old('foundation_year') }}">
                </div>
                <div class="form-group col-lg-6">
                    <label for="additional_info1">@lang('app.additional_info1')</label>
                    <input type="text" class="form-control" id="additional_info1"
                           name="additional_info1" placeholder="@lang('app.additional_info1')" value="{{ $edit ? $company->additional_info1 : old('additional_info1') }}">
                </div>
                <div class="form-group col-lg-6">
                    <label for="additional_info2">@lang('app.additional_info2')</label>
                    <input type="text" class="form-control" id="additional_info2"
                           name="additional_info2" placeholder="@lang('app.additional_info2')" value="{{ $edit ? $company->additional_info2 : old('additional_info2') }}">
                </div>
                <div class="form-group col-lg-6">
                    <label for="additional_info3">@lang('app.additional_info3')</label>
                    <input type="text" class="form-control" id="additional_info3"
                           name="additional_info3" placeholder="@lang('app.additional_info3')" value="{{ $edit ? $company->additional_info3 : old('additional_info3') }}">
                </div>
                <div class="form-group col-lg-6">
                    <label for="additional_info4">@lang('app.additional_info4')</label>
                    <input type="text" class="form-control" id="additional_info4"
                           name="additional_info4" placeholder="@lang('app.additional_info4')" value="{{ $edit ? $company->additional_info4 : old('additional_info4') }}">
                </div>
                <div class="form-group col-lg-6">
                    <label for="annual_revenue">@lang('app.annual_revenue')</label>
                    <input type="text" class="form-control" id="annual_revenue"
                           name="annual_revenue" placeholder="@lang('app.annual_revenue')" value="{{ $edit ? $company->annual_revenue : old('annual_revenue') }}">
                </div>
                <div class="form-group col-lg-6">
                    <label for="products_services">@lang('app.products_services')</label>
                    <input type="text" class="form-control" id="products_services"
                           name="products_services" placeholder="@lang('app.products_services')" value="{{ $edit ? $company->products_services : old('products_services') }}">
                </div>
                
                <div class="form-group col-lg-6">
                    <label for="number_of_beds">@lang('app.number_of_beds')</label>
                    <input type="text" class="form-control" id="number_of_beds"
                           name="number_of_beds" placeholder="@lang('app.number_of_beds')" value="{{ $edit ? $company->number_of_beds : old('number_of_beds') }}">
                </div>
      		</div>
      		</div>
      		</div>
      		
<div class="row">
<div class="col-md-7"></div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.save') : trans('app.save') }}
        </button>
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">
            <i class=""></i>
            {{ $edit ? trans('app.cancel') : trans('app.cancel') }}
        </button>
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
	})

    </script>
@stop


@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop
@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Company\UpdateCompanyRequest', '#company-form') !!}
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Contact\CreateContactRequest', '#staff-form') !!}
    @else
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Company\CreateCompanyRequest', '#company-form') !!}

    @endif
    
    
    {!! HTML::script('assets/js/moment.min.js') !!}
    {!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
@stop


