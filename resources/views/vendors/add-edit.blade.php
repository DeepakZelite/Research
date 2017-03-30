@extends('layouts.app')

@section('page-title', trans('app.vendors'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            {{ $edit ? $vendor->name : trans('app.create_new_vendor') }}
            <small>{{ $edit ? trans('app.edit_vendor_details') : trans('app.vendor_details') }}</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('vendor.list') }}">@lang('app.vendors')</a></li>
                    <li class="active">{{ $edit ? trans('app.edit') : trans('app.create') }}</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['vendor.update', $vendor->id], 'method' => 'PUT', 'id' => 'vendor-form']) !!}
@else
    {!! Form::open(['route' => 'vendor.store', 'id' => 'vendor-form']) !!}
@endif

<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.vendor_details_big')</div>
            <div class="panel-body">
                <div class="col-md-6">
                <div class="form-group">
                    <label for="name">@lang('app.name')<i style="color:red;">*</i></label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.vendor_name')" value="{{ $edit ? $vendor->name : old('name') }}">
                </div>              
                <div class="form-group">
                    <label for="vendorCode">@lang('app.vendor_code')<i style="color:red;">*</i></label>
                    @if($edit)
                    	<input type="text" class="form-control" id="vendor_code" maxlength="15"
                           name="vendor_code" placeholder="@lang('app.vendor_code')" readonly="readonly" value="{{ $edit ? $vendor->vendor_code : old('vendor_code') }}">
                    @else 
                    	<input type="text" class="form-control" id="vendor_code"  maxlength="15"
                           name="vendor_code" placeholder="@lang('app.vendor_code')" value="{{ $edit ? $vendor->vendor_code : old('vendor_code') }}">                      
                    @endif
                </div>
                
                <div class="form-group">
                    <label for="location">@lang('app.location')<i style="color:red;">*</i></label>
                    <input type="text" maxlength="25" class="form-control" id="location"
                           name="location" placeholder="@lang('Location of Vendor')" value="{{ $edit ? $vendor->location : old('location') }}">
                </div>
                
                <div class="form-group">
                    <label for="contactPerson">@lang('app.contact_person')<i style="color:red;">*</i></label>
                    <input type="text" class="form-control" id="contactPerson"
                           name="contactPerson" placeholder="@lang('Contact Person Name')" value="{{ $edit ? $vendor->contactPerson : old('contactPerson') }}">
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
            		<label for="email">@lang('app.email')<i style="color:red;">*</i></label>
            		<input type="email" maxlength="30" class="form-control" id="email"
 	                  name="email" placeholder="@lang('app.email')" value="{{ $edit ? $vendor->email : '' }}">
		        </div>
                <div class="form-group">

                    <label for="phone">@lang('app.phone')<i style="color:red;">*</i></label>

                   <!-- <label for="phone">@lang('app.phone')</label>-->

                    <input type="text" class="form-control" id="phone" maxlength="10" onkeypress="return isNumberKey(event)"
                           name="phone" placeholder="@lang('phone Number')" value="{{ $edit ? $vendor->phone : old('phone') }}">
                </div>
                <div class="form-group">
                    <label for="mobile">@lang('app.mobile')</label>
                    <input type="text" maxlength="10" class="form-control" id="mobile"  onkeypress="return isNumberKey(event)"
                           name="mobile" placeholder="@lang('Mobile Number')" value="{{ $edit ? $vendor->mobile : old('mobile') }}">
                </div>
                <div class="form-group">
                    <label for="status">@lang('app.status')<i style="color:red;">*</i></label>
                    @if($edit)
                    	{!! Form::select('status', $statuses, $edit ? $vendor->status : '',
                        	['class' => 'form-control', 'id' => 'status']) !!}
                     @else
                     	{!! Form::select('status', $statuses, $edit ? $vendor->status : '',
                        	['class' => 'form-control','disabled' => 'disabled' ,'id' => 'status']) !!}                    	
                    @endif
                </div> 
                </div>
                 
                <!-- <div class="form-group">
                    <label for="description">@lang('app.description')</label>
                    <textarea name="description" id="description" class="form-control">{{ $edit ? $vendor->description : old('description') }}</textarea>
                </div>
                 -->
                </div>
            </div>
        </div>
    </div>

<div class="row">
	<div class="col-md-2"></div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.update_vendor') : trans('app.create_vendor') }}
        </button>
    </div>
    <div class="col-md-2">
        <a href="{{ route('vendor.list') }}" class="btn btn-primary btn-block" id="cancel">
            @lang('app.cancel')
        </a>
    </div>
</div>

@stop

@section('scripts')
	<script>
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
         return true;
      }
    </script>
    @if ($edit)
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Vendor\UpdateVendorRequest', '#vendor-form') !!}
    @else
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Vendor\CreateVendorRequest', '#vendor-form') !!}
    @endif
@stop