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
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.vendor_name')" value="{{ $edit ? $vendor->name : old('name') }}">
                </div>
                 <div class="form-group">
                    <label for="description">@lang('app.description')</label>
                    <input type="text" class="form-control" id="description"
                           name="description" placeholder="@lang('app.description')" value="{{ $edit ? $vendor->description : old('description') }}">
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
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.update_vendor') : trans('app.create_vendor') }}
        </button>
    </div>
</div>

@stop

@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Vendor\UpdateVendorRequest', '#vendor-form') !!}
    @else
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Vendor\CreateVendorRequest', '#vendor-form') !!}
    @endif
@stop