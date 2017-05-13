@extends('layouts.app')

@section('page-title', trans('app.users'))

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            @lang('app.users')
            <small>@lang('app.list_of_registered_users')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.users')</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <a href="{{ route('user.create') }}" class="btn btn-success" id="add-user">
            <i class="glyphicon glyphicon-plus"></i>
            @lang('app.add_user')
        </a>
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>
    <form method="GET" action="" accept-charset="UTF-8" id="users-form">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
             {!! Form::select('vendor_code', $vendors, Input::get('vendor_code'), ['id'=>'vendor_code', 'class'=>'form-control'])!!}
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
             {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control']) !!}
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search_for_users')">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search-users-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    @if (Input::has('search') && Input::get('search') != '')
                        <a href="{{ route('user.list') }}" class="btn btn-danger" type="button" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    @endif
                </span>
            </div>
        </div>
    </form>
</div>

<div class="table-responsive top-border-table" id="users-table-wrapper">
    <table class="table" id="usertable">
        <thead>
            <th>@sortablelink('username',trans('app.username'))</th>
            <th>@sortablelink('first_name','Full Name')</th>
            <th>@sortablelink('vendor_code',trans('app.vendor_code'))</th>
            <th class="text-primary">@lang('app.status')</th>
            <th class="text-center text-primary">@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($users))
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username ?: trans('app.n_a') }}</td>
                        <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                        <td>{{$user->vendor_code}}</td>
                        <td>
                            <span class="label label-{{ $user->present()->labelClass }}">{{ trans("app.{$user->status}") }}</span>
                        </td>
                        <td class="text-center">
                           
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-circle edit" title="@lang('app.edit_user')"
                                    data-toggle="tooltip" data-placement="top">
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

    {!! $users->render() !!}
</div>

@stop

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#users-form").submit();
        });
        $("#vendor_code").change(function(){
            $("#users-form").submit();
        });
    </script>
@stop
