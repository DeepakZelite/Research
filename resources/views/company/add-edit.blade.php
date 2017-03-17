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
    <div class="col-lg-3 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')</div>
            <div class="panel-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.company_name')" value="{{ $edit ? $company->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.company_id')</label>
                    <input type="text" class="form-control" id="company_id"
                           name="company_id" placeholder="@lang('app.company_id')" value="">
                </div>              
                <div class="form-group">
                    <label for="vendorCode">@lang('app.parent_company')</label>
                    <input type="text" class="form-control" id="parent_company"
                           name="parent_company" placeholder="@lang('app.parent_company')"  value="">
                </div>
                
                <div class="form-group">
                    <label for="location">@lang('app.Company_name')</label>
                    <input type="text" class="form-control" id="Company_name"
                           name="Company_name" placeholder="@lang('app.Company_name')" value="">
                </div>
                
                <div class="form-group">
                    <label for="contactPerson">@lang('app.address1')</label>
                    <input type="text" class="form-control" id="address1"
                           name="address1" placeholder="@lang('app.address1')" value="">
                </div>
                <div class="form-group">
                    <label for="contactPerson">@lang('app.address2')</label>
                    <input type="text" class="form-control" id="address2"
                           name="address2" placeholder="@lang('app.address2')" value="">
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.city')</label>
                    <input type="text" class="form-control" id="city"
                           name="city" placeholder="@lang('app.city')" value="">
                </div> 
                </div>
              </div>
           </div>
        </div>
 <!-- ------------------------------------------------------------------------------------------------------------ -->
     <div class="col-lg-3 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')</div>
            <div class="panel-body">           
                <div class="col-md-12">
                <div class="form-group">
            		<label for="email">@lang('app.state')</label>
            		<input type="text" class="form-control" id="state"
 	                  name="state" placeholder="@lang('app.state')" value="">
		        </div>
                <div class="form-group">

                    <label for="phone">@lang('app.phone')</label>

                   <!-- <label for="phone">@lang('app.phone')</label>-->

                    <input type="phone" class="form-control" id="phone"
                           name="phone" placeholder="@lang('phone Number')" value="">
                </div>
                <div class="form-group">
                    <label for="mobile">@lang('app.mobile')</label>
                    <input type="mobile" class="form-control" id="mobile"
                           name="mobile" placeholder="@lang('Mobile Number')" value="">
                </div>
                <div class="form-group">
            		<label for="email">@lang('app.email')</label>
            		<input type="email" class="form-control" id="email"
 	                  name="email" placeholder="@lang('app.email')" value="">
		        </div>
                <div class="form-group">

                    <label for="phone">@lang('app.phone')</label>

                   <!-- <label for="phone">@lang('app.phone')</label>-->

                    <input type="phone" class="form-control" id="phone"
                           name="phone" placeholder="@lang('phone Number')" value="">
                </div>
                <div class="form-group">
                    <label for="mobile">@lang('app.mobile')</label>
                    <input type="mobile" class="form-control" id="mobile"
                           name="mobile" placeholder="@lang('Mobile Number')" value="">
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.vendor_name')" value="">
                </div> 
                </div>
              </div>
           </div>
        </div>
   <!-- ------------------------------------------------------------------------------------------------------------ -->              
     <div class="col-lg-3 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')</div>
            <div class="panel-body">
                <div class="col-md-12">
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.company_name')" value="{{ $edit ? $company->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.vendor_name')" value="">
                </div>              
                <div class="form-group">
                    <label for="vendorCode">@lang('app.vendor_code')</label>
                    <input type="text" class="form-control" id="vendor_code"
                           name="vendor_code" placeholder="@lang('app.vendor_code')"  value="">
                </div>
                
                <div class="form-group">
                    <label for="location">@lang('app.location')</label>
                    <input type="text" class="form-control" id="location"
                           name="location" placeholder="@lang('Location of Vendor')" value="">
                </div>
                
                <div class="form-group">
                    <label for="contactPerson">@lang('app.contact_person')</label>
                    <input type="text" class="form-control" id="contactPerson"
                           name="contactPerson" placeholder="@lang('Contact Person Name')" value="">
                </div>
                <div class="form-group">
                    <label for="contactPerson">@lang('app.contact_person')</label>
                    <input type="text" class="form-control" id="contactPerson"
                           name="contactPerson" placeholder="@lang('Contact Person Name')" value="">
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.vendor_name')" value="">
                </div> 
                </div>
             </div>
           </div>
        </div>
 <!-- ------------------------------------------------------------------------------------------------------------ -->
      <div class="col-lg-3 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')</div>
            <div class="panel-body">
               <div class="col-md-12">
                <div class="form-group">
            		<label for="email">@lang('app.email')</label>
            		<input type="email" class="form-control" id="email"
 	                  name="email" placeholder="@lang('app.email')" value="">
		        </div>
                <div class="form-group">

                    <label for="phone">@lang('app.phone')</label>

                   <!-- <label for="phone">@lang('app.phone')</label>-->

                    <input type="phone" class="form-control" id="phone"
                           name="phone" placeholder="@lang('phone Number')" value="">
                </div>
                <div class="form-group">
                    <label for="mobile">@lang('app.mobile')</label>
                    <input type="mobile" class="form-control" id="mobile"
                           name="mobile" placeholder="@lang('Mobile Number')" value="">
                </div>
                <div class="form-group">
            		<label for="email">@lang('app.email')</label>
            		<input type="email" class="form-control" id="email"
 	                  name="email" placeholder="@lang('app.email')" value="">
		        </div>
                <div class="form-group">

                    <label for="phone">@lang('app.phone')</label>

                   <!-- <label for="phone">@lang('app.phone')</label>-->

                    <input type="phone" class="form-control" id="phone"
                           name="phone" placeholder="@lang('phone Number')" value="">
                </div>
                <div class="form-group">
                    <label for="mobile">@lang('app.mobile')</label>
                    <input type="mobile" class="form-control" id="mobile"
                           name="mobile" placeholder="@lang('Mobile Number')" value="">
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.vendor_name')" value="">
                </div> 
                </div>
             </div>
           </div>
        </div>
 <!-- ------------------------------------------------------------------------------------------------------------                            
                <div class="col-md-2">
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.company_name')" value="{{ $edit ? $company->name : old('name') }}">
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.vendor_name')" value="">
                </div>              
                <div class="form-group">
                    <label for="vendorCode">@lang('app.vendor_code')</label>
                    <input type="text" class="form-control" id="vendor_code"
                           name="vendor_code" placeholder="@lang('app.vendor_code')"  value="">
                </div>
                
                <div class="form-group">
                    <label for="location">@lang('app.location')</label>
                    <input type="text" class="form-control" id="location"
                           name="location" placeholder="@lang('Location of Vendor')" value="">
                </div>
                
                <div class="form-group">
                    <label for="contactPerson">@lang('app.contact_person')</label>
                    <input type="text" class="form-control" id="contactPerson"
                           name="contactPerson" placeholder="@lang('Contact Person Name')" value="">
                </div>
                <div class="form-group">
                    <label for="contactPerson">@lang('app.contact_person')</label>
                    <input type="text" class="form-control" id="contactPerson"
                           name="contactPerson" placeholder="@lang('Contact Person Name')" value="">
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.vendor_name')" value="">
                </div> 
                </div>
 <!-- ------------------------------------------------------------------------------------------------------------                
                <div class="col-md-2">
                <div class="form-group">
            		<label for="email">@lang('app.email')</label>
            		<input type="email" class="form-control" id="email"
 	                  name="email" placeholder="@lang('app.email')" value="">
		        </div>
                <div class="form-group">

                    <label for="phone">@lang('app.phone')</label>

                   <!-- <label for="phone">@lang('app.phone')</label>

                    <input type="phone" class="form-control" id="phone"
                           name="phone" placeholder="@lang('phone Number')" value="">
                </div>
                <div class="form-group">
                    <label for="mobile">@lang('app.mobile')</label>
                    <input type="mobile" class="form-control" id="mobile"
                           name="mobile" placeholder="@lang('Mobile Number')" value="">
                </div>
                <div class="form-group">
            		<label for="email">@lang('app.email')</label>
            		<input type="email" class="form-control" id="email"
 	                  name="email" placeholder="@lang('app.email')" value="">
		        </div>
                <div class="form-group">

                    <label for="phone">@lang('app.phone')</label>

                   <!-- <label for="phone">@lang('app.phone')</label>

                    <input type="phone" class="form-control" id="phone"
                           name="phone" placeholder="@lang('phone Number')" value="">
                </div>
                <div class="form-group">
                    <label for="mobile">@lang('app.mobile')</label>
                    <input type="mobile" class="form-control" id="mobile"
                           name="mobile" placeholder="@lang('Mobile Number')" value="">
                </div>
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.vendor_name')" value="">
                </div> 
                </div>
                
                
              </div>
            </div>
        </div>-->
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


