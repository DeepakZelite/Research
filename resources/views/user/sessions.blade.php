@extends('layouts.app')

@section('page-title', $user->present()->nameOrEmail . ' - ' . trans('app.active_sessions'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            {{ $user->present()->nameOrEmail }}
            <small>@lang('app.active_sessions_sm')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>

                    @if (isset($adminView))
                        <li><a href="{{ route('user.list') }}">@lang('app.users')</a></li>
                        <li><a href="{{ route('user.show', $user->id) }}">{{ $user->present()->name }}</a></li>
                    @endif

                    <li class="active">@lang('app.sessions')</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')

<div class="table-responsive">
    <table class="table">
        <thead>
            <th>@lang('app.ip_address')</th>
            <th>@lang('app.user_agent')</th>
            <th>@lang('app.last_activity')</th>
            <th class="text-center">@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($sessions))
                @foreach ($sessions as $session)
                    <tr>
                        <td>{{ $session->ip_address }}</td>
                        <td>{{ $session->user_agent }}</td>
                        <td>{{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->format('Y-m-d H:i:s') }}</td>
                        <td class="text-center">
                            <a href="{{ isset($profile) ? route('profile.sessions.invalidate', $session->id) : route('user.sessions.invalidate', [$user->id, $session->id]) }}"
                                class="btn btn-danger btn-circle" title="@lang('app.invalidate_session')"
                                data-toggle="tooltip"
                                data-placement="top"
                                data-method="DELETE"
                                data-confirm-title="@lang('app.please_confirm')"
                                data-confirm-text="@lang('app.are_you_sure_invalidate_session')"
                                data-confirm-delete="@lang('app.yes_proceed')">
                                <i class="fa fa-times"></i>
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
</div>

@stop
