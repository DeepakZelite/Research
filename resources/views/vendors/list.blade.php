@extends('layouts.app')

@section('page-title', trans('app.vendors'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @lang('app.vendors')
            <small>@lang('app.list_of_vendors')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.vendors')</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
    <div class="col-md-2">
        <a href="{{ route('vendor.create') }}" class="btn btn-success" id="add-vendor">
            <i class="glyphicon glyphicon-plus"></i>
            @lang('app.add_vendor')
        </a>
    </div>
    <div class="col-md-5"></div>
    <form method="GET" action="" accept-charset="UTF-8" id="vendors-form">
 <!--      <div class="col-md-2">
            {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control']) !!}
        </div>
--> 
        <div class="col-md-3">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search_for_vendors')">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search-users-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    @if (Input::has('search') && Input::get('search') != '')
                        <a href="{{ route('vendor.list') }}" class="btn btn-danger" type="button" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    @endif
                </span>
            </div>
        </div>
    </form>
</div>

<div class="table-responsive top-border-table" id="users-table-wrapper">
    <table class="table">
        <thead>
            <th>@lang('app.name')</th>
            <th>@lang('app.location')</th>
        <!--    <th>@lang('app.contact_person')</th>
            <th>@lang('app.email')</th>
            <th>@lang('app.phone')</th>
            <th>@lang('app.mobile')</th>-->
            <th>@lang('app.status')</th>
            <th>&nbsp;</th>
        </thead>
        <tbody>
            @if (count($vendors))
                @foreach ($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->location }}</td>
                     <!--    <td>{{ $vendor->contactPerson }}</td>
                        <td>{{ $vendor->email }}</td>
                        <td>{{ $vendor->phone }}</td>
                        <td>{{ $vendor->mobile }}</td> -->
                        <td>
                            <span class="label label-{{ $vendor->present()->labelClass }}">{{ trans("app.{$vendor->status}") }}</span>
                        </td>
                         <td class="text-center">
                            <a href="{{ route('vendor.edit', $vendor->id) }}" class="btn btn-primary btn-circle"
                               title="@lang('app.edit_vendor')" data-toggle="tooltip" data-placement="top">
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

    {!! $vendors->render() !!}
</div>

@stop

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#users-form").submit();
        });
    </script>
@stop
