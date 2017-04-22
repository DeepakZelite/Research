@extends('layouts.app')

@section('page-title', trans('app.my_productivity_report'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @lang('app.my_productivity')
            <!-- <small>@lang('app.list_of_batches')</small> -->
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.report')</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
</div>

<div class="table-responsive top-border-table" id="users-table-wrapper1">
    <table class="table" id="example">
        <thead>
            <th>@lang('app.user_name')</th>
            <th>@lang('app.hour_spend')</th>
            <th>@lang('app.number_of_companies_processed')</th>
            <th>@lang('app.no_of_record_processed')</th>
            <th class="text-center">@lang('app.record_per_hour')</th>
        </thead>
        <tbody>
				<tr>
                    <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                </tr>
        </tbody>
    </table>
</div>

@stop

@section('scripts')
<script>
</script>
@stop