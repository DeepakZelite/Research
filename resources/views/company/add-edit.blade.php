@extends('layouts.app')

@section('page-title', trans('app.companys'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            {{ $edit ? $company->name : trans('app.create_new_company') }}
            <small>{{ $edit ? trans('app.edit_company_details') : trans('app.company_details') }}</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('company.list') }}">@lang('app.companys')</a></li>
                    <li class="active">{{ $edit ? trans('app.edit') : trans('app.create') }}</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['company.update', $company->id], 'method' => 'PUT', 'id' => 'company-form']) !!}
@else
    {!! Form::open(['route' => 'company.store', 'id' => 'company-form']) !!}
@endif

<div class="row">
    <!-- <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.company_name')" value="{{ $edit ? $company->name : old('name') }}">
                </div>
              </div>
            </div>
        </div>-->
        
        
        <div class="row">
    <div class="col-lg-4 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')</div>
            <div class="panel-body">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="company_instructions">@lang('app.company_instructions')</label>
                    <input type="text" class="form-control" id="company_instructions"
                           name="company_instructions" placeholder="@lang('app.company_instructions')" value="{{ $edit ? $company->company_instructions : old('company_instructions') }}">
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.company_id')</label>
                    <input type="text" class="form-control" id="company_id"
                           name="company_id" placeholder="@lang('app.company_id')" value="{{ $edit ? $company->company_id : old('company_id') }}">
                </div>              
                <div class="form-group">
                    <label for="vendorCode">@lang('app.parent_company')</label>
                    <input type="text" class="form-control" id="parent_company"
                           name="parent_company" placeholder="@lang('app.parent_company')"  value="{{ $edit ? $company->parent_company : old('parent_company') }}">
                </div>
                
                <div class="form-group">
                    <label for="location">@lang('app.Company_name')</label>
                    <input type="text" class="form-control" id="Company_name"
                           name="Company_name" placeholder="@lang('app.Company_name')" value="{{ $edit ? $company->company_name : old('company_name') }}">
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="contactPerson">@lang('app.address1')</label>
                    <input type="text" class="form-control" id="address1"
                           name="address1" placeholder="@lang('app.address1')" value="{{ $edit ? $company->address1 : old('address1') }}">
                </div>
                <div class="form-group">
                    <label for="contactPerson">@lang('app.address2')</label>
                    <input type="text" class="form-control" id="address2"
                           name="address2" placeholder="@lang('app.address2')" value="{{ $edit ? $company->address2 : old('address2') }}">
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.city')</label>
                    <input type="text" class="form-control" id="city"
                           name="city" placeholder="@lang('app.city')" value="{{ $edit ? $company->city : old('city') }}">
                </div> 
                </div>
              </div>
           </div>
        </div>
 <!-- ------------------------------------------------------------------------------------------------------------ -->
     <div class="col-lg-4 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')</div>
            <div class="panel-body">           
                <div class="col-md-6">
                <div class="form-group">
            		<label for="email">@lang('app.state')</label>
            		<input type="text" class="form-control" id="state"
 	                  name="state" placeholder="@lang('app.state')" value="{{ $edit ? $company->state : old('state') }}">
		        </div>
                <div class="form-group">

                    <label for="phone">@lang('app.phone')</label>

                   <!-- <label for="phone">@lang('app.phone')</label>-->

                    <input type="text" class="form-control" id="zipcode"
                           name="zipcode" placeholder="@lang('app.zipcode')" value="{{ $edit ? $company->zipcode : old('zipcode') }}">
                </div>
                <div class="form-group">
                    <label for="country">@lang('app.country')</label>
                    <input type="text" class="form-control" id="country"
                           name="country" placeholder="@lang('app.country')" value="{{ $edit ? $company->country : old('country') }}">
                </div>
                <div class="form-group">
            		<label for="international_code">@lang('app.international_code')</label>
            		<input type="text" class="form-control" id="international_code"
 	                  name="international_code" placeholder="@lang('app.international_code')" value="{{ $edit ? $company->international_code : old('international_code') }}">
		        </div>
		        </div>
		        
		        <div class="col-md-6">
                <div class="form-group">

                    <label for="phone">@lang('app.switchboardnumber')</label>

                   <!-- <label for="phone">@lang('app.phone')</label>-->

                    <input type="text" class="form-control" id="switchboardnumber"
                           name="switchboardnumber" placeholder="@lang('app.switchboardnumber')" value="{{ $edit ? $company->switchboardnumber : old('switchboardnumber') }}">
                </div>
                <div class="form-group">
                    <label for="branchNumber">@lang('app.branchNumber')</label>
                    <input type="text" class="form-control" id="branchNumber"
                           name="branchNumber" placeholder="@lang('branchNumber')" value="{{ $edit ? $company->branchNumber : old('branchNumber') }}">
                </div>
                <div class="form-group">
                    <label for="addresscode">@lang('app.addresscode')</label>
                    <input type="text" class="form-control" id="addresscode"
                           name="addresscode" placeholder="@lang('app.addresscode')" value="{{ $edit ? $company->addresscode : old('addresscode') }}">
                </div> 
                </div>
              </div>
           </div>
        </div>
   <!-- ------------------------------------------------------------------------------------------------------------ -->              
     <div class="col-lg-4 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')</div>
            <div class="panel-body">
                <div class="col-md-6">
                <div class="form-group">
                    <label for="website">@lang('app.website')</label>
                    <input type="text" class="form-control" id="website"
                           name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('website') }}">
                </div>
                <div class="form-group">
                    <label for="comapny_email">@lang('app.comapny_email')</label>
                    <input type="text" class="form-control" id="comapny_email"
                           name="comapny_email" placeholder="@lang('app.comapny_email')" value="{{ $edit ? $company->comapny_email : old('comapny_email') }}">
                </div>              
                <div class="form-group">
                    <label for="products_services">@lang('app.products_services')</label>
                    <input type="text" class="form-control" id="products_services"
                           name="products_services" placeholder="@lang('app.products_services')"  value="{{ $edit ? $company->products_services : old('products_services') }}">
                </div>
                
                <div class="form-group">
                    <label for="industry_classfication">@lang('app.industry_classfication')</label>
                    <input type="text" class="form-control" id="industry_classfication"
                           name="industry_classfication" placeholder="@lang('app.industry_classfication')" value="{{ $edit ? $company->industry_classfication : old('industry_classfication') }}">
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label for="employee_size">@lang('app.employee_size')</label>
                    <input type="text" class="form-control" id="employee_size"
                           name="employee_size" placeholder="@lang('app.employee_size')" value="{{ $edit ? $company->employee_size : old('employee_size') }}">
                </div>
                <div class="form-group">
                    <label for="physician_size">@lang('app.physician_size')</label>
                    <input type="text" class="form-control" id="physician_size"
                           name="physician_size" placeholder="@lang('app.physician_size')" value="{{ $edit ? $company->physician_size : old('physician_size') }}">
                </div>
                <div class="form-group">
                    <label for="annual_revenue">@lang('app.annual_revenue')</label>
                    <input type="text" class="form-control" id="annual_revenue"
                           name="annual_revenue" placeholder="@lang('app.annual_revenue')" value="{{ $edit ? $company->annual_revenue : old('annual_revenue') }}">
                </div> 
                </div>
             </div>
           </div>
        </div>
 <!-- ------------------------------------------------------------------------------------------------------------ -->
      <div class="col-lg-4 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')</div>
            <div class="panel-body">
               <div class="col-md-6">
                <div class="form-group">
            		<label for="number_of_beds">@lang('app.number_of_beds')</label>
            		<input type="text" class="form-control" id="number_of_beds"
 	                  name="number_of_beds" placeholder="@lang('app.number_of_beds')" value="{{ $edit ? $company->number_of_beds : old('number_of_beds') }}">
		        </div>
                <div class="form-group">
                    <label for="foundation_year">@lang('app.foundation_year')</label>
                    <input type="text" class="form-control" id="foundation_year"
                           name="foundation_year" placeholder="@lang('app.foundation_year')" value="{{ $edit ? $company->foundation_year : old('foundation_year') }}">
                </div>
                <div class="form-group">
                    <label for="company_remark">@lang('app.company_remark')</label>
                    <input type="text" class="form-control" id="company_remark"
                           name="company_remark" placeholder="@lang('app.company_remark')" value="{{ $edit ? $company->company_remark : old('company_remark') }}">
                </div>
                <div class="form-group">
            		<label for="additional_info1">@lang('app.additional_info1')</label>
            		<input type="text" class="form-control" id="additional_info1"
 	                  name="additional_info1" placeholder="@lang('app.additional_info1')" value="{{ $edit ? $company->additional_info1 : old('additional_info1') }}">
		        </div>
		        </div>
		        <div class="col-md-6">
                <div class="form-group">

                    <label for="additional_info2">@lang('app.additional_info2')</label>
                    <input type="text" class="form-control" id="additional_info2"
                           name="additional_info2" placeholder="@lang('app.additional_info2')" value="{{ $edit ? $company->additional_info2 : old('additional_info2') }}">
                </div>
                <div class="form-group">
                    <label for="additional_info3">@lang('app.additional_info3')</label>
                    <input type="text" class="form-control" id="additional_info3"
                           name="additional_info3" placeholder="@lang('app.additional_info3')" value="{{ $edit ? $company->additional_info3 : old('additional_info3') }}">
                </div>
                <div class="form-group">
                    <label for="additional_info4">@lang('app.additional_info4')</label>
                    <input type="text" class="form-control" id="additional_info4"
                           name="additional_info4" placeholder="@lang('app.additional_info4')" value="{{ $edit ? $company->additional_info4 : old('additional_info4') }}">
                </div> 
                </div>
             </div>
           </div>
        </div>
 <!-- ------------------------------------------------------------------------------------------------------------ -->                            
      <div class="col-lg-4 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')</div>
            <div class="panel-body">
               <div class="col-md-6">
                <div class="form-group">
            		<label for="staff_id">@lang('app.staff_id')</label>
            		<input type="email" class="form-control" id="staff_id"
 	                  name="text" placeholder="@lang('app.staff_id')" value="{{ $edit ? $company->staff_id : old('staff_id') }}">
		        </div>
                <div class="form-group">

                    <label for="salutation">@lang('app.salutation')</label>
                    <input type="text" class="form-control" id="salutation"
                           name="salutation" placeholder="@lang('app.salutation')" value="{{ $edit ? $company->salutation : old('salutation') }}">
                </div>
                <div class="form-group">
                    <label for="firstname">@lang('app.firstname')</label>
                    <input type="text" class="form-control" id="firstname"
                           name="firstname" placeholder="@lang('app.firstname')" value="{{ $edit ? $company->firstname : old('firstname') }}">
                </div>
                <div class="form-group">
            		<label for="middlename">@lang('app.middlename')</label>
            		<input type="text" class="form-control" id="middlename"
 	                  name="middlename" placeholder="@lang('app.middlename')" value="{{ $edit ? $company->middlename : old('middlename') }}">
		        </div>
		        </div>
		        <div class="col-md-6">
                <div class="form-group">
                    <label for="lastname">@lang('app.lastname')</label>
                    <input type="text" class="form-control" id="lastname"
                           name="lastname" placeholder="@lang('app.lastname')" value="{{ $edit ? $company->lastname : old('lastname') }}">
                </div>
                <div class="form-group">
                    <label for="job_title">@lang('app.job_title')</label>
                    <input type="text" class="form-control" id="job_title"
                           name="job_title" placeholder="@lang('app.job_title')" value="{{ $edit ? $company->job_title : old('job_title') }}">
                </div>
                <div class="form-group">
                    <label for="specification">@lang('app.specification')</label>
                    <input type="text" class="form-control" id="specification"
                           name="specification" placeholder="@lang('app.specification')" value="{{ $edit ? $company->specification : old('specification') }}">
                </div>
                <div class="form-group">
                    <label for="qualification">@lang('app.qualification')</label>
                    <input type="text" class="form-control" id="qualification"
                           name="qualification" placeholder="@lang('app.qualification')" value="{{ $edit ? $company->qualification : old('qualification') }}">
                </div> 
                </div>
             </div>
           </div>
        </div>
 <!-- ------------------------------------------------------------------------------------------------------------ -->                
      <div class="col-lg-4 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')</div>
            <div class="panel-body">
               <div class="col-md-6">
                <div class="form-group">
            		<label for="staff_source">@lang('app.staff_source')</label>
            		<input type="text" class="form-control" id="staff_source"
 	                  name="staff_source" placeholder="@lang('app.staff_source')" value="{{ $edit ? $company->staff_source : old('staff_source') }}">
		        </div>
                <div class="form-group">
                    <label for="staff_email1">@lang('app.staff_email1')</label>
                    <input type="text" class="form-control" id="staff_email1"
                           name="staff_email1" placeholder="@lang('app.staff_email1')" value="{{ $edit ? $company->staff_email1 : old('staff_email1') }}">
                </div>
                <div class="form-group">
                    <label for="staff_email2">@lang('app.staff_email2')</label>
                    <input type="text" class="form-control" id="staff_email2"
                           name="staff_email2" placeholder="@lang('app.staff_email2')" value="{{ $edit ? $company->staff_email2 : old('staff_email2') }}">
                </div>
                <div class="form-group">
            		<label for="direct_emailsource">@lang('app.direct_emailsource')</label>
            		<input type="email" class="form-control" id="direct_emailsource"
 	                  name="direct_emailsource" placeholder="@lang('app.direct_emailsource')" value="{{ $edit ? $company->direct_emailsource : old('direct_emailsource') }}">
		        </div>
		        </div>
		        <div class="col-md-6">
                <div class="form-group">
                    <label for="direct_phoneno">@lang('app.direct_phoneno')</label>
                    <input type="text" class="form-control" id="direct_phoneno"
                           name="direct_phoneno" placeholder="@lang('app.direct_phoneno')" value="{{ $edit ? $company->direct_phoneno : old('direct_phoneno') }}">
                </div>
                <div class="form-group">
                    <label for="deparment_number">@lang('app.deparment_number')</label>
                    <input type="text" class="form-control" id="deparment_number"
                           name="deparment_number" placeholder="@lang('app.deparment_number')" value="{{ $edit ? $company->deparment_number : old('deparment_number') }}">
                </div>
                <div class="form-group">
                    <label for="shift_timing">@lang('app.shift_timing')</label>
                    <input type="text" class="form-control" id="shift_timing"
                           name="shift_timing" placeholder="@lang('app.shift_timing')" value="{{ $edit ? $company->shift_timing : old('shift_timing') }}">
                </div>
                <div class="form-group">
                    <label for="paternership">@lang('app.paternership')</label>
                    <input type="text" class="form-control" id="paternership"
                           name="paternership" placeholder="@lang('app.paternership')" value="{{ $edit ? $company->paternership : old('paternership') }}">
                </div>
                </div>
             </div>
           </div>
        </div>
        
    </div> 
    </div>

<div class="row">
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.update_company') : trans('app.create_company') }}
        </button>
    </div>
    @if ($edit)
    <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">
            <i class="fa fa-save"></i>
            {{ trans('app.add_contact') }}
        </button>
    </div>
    @endif
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.contact_details_big')</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.company_name')" value="{{ $edit ? $company->name : old('name') }}">
                </div>
              </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-3">
        <button type="button" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.save') : trans('app.save') }}
        </button>
    </div>
</div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


@stop
@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop
@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Company\UpdateCompanyRequest', '#company-form') !!}
    @else
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Company\CreateCompanyRequest', '#company-form') !!}
    @endif
    {!! HTML::script('assets/js/moment.min.js') !!}
    {!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
@stop


