@extends('layouts.app')

@section('page-title', trans('app.sql_queries'))

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            @lang('app.sql_queries')
            <small>@lang('app.raw')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.sql')</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

{!! Form::open(['route' => 'record.data', 'id' => 'sqlqueries_form']) !!}
    <div class="row">
    	<div class="col-xs-8 col-sm-8 col-md-6 col-lg-6">
    		<div class="form-group">
				<textarea class="form-control" id="queries" name="queries" placeholder="@lang('app.sql_queries')">@if($edit) {{ $edit }} @endif</textarea>
			</div>
    	</div>
        <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
            <button type="submit" id="btnSubmit" class="btn btn-success">
                <i class="fa fa-bolt"></i>
                @lang('app.run')
            </button>
        </div>        
    </div>
<div class="table-responsive top-border-table" id="users-table-wrapper">
    <table class="table" id="example">
    <thead style="background-color: grey">
    @if(count($data))
    	<tr>{{ count($data) }} row's returned</tr>
    @endif
    </thead>
        <tbody>
        	@if(count($data))
                @foreach ($data as $datas)
                	<tr>
                        <td>{{ html_entity_decode(json_encode($datas),true) }}</td>
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

@section('styles')
<style>
tbody { display: block; height: 500px; overflow: auto;}
</style>
@stop
@section('scripts')
<script>
        $(document).ready(function() {
        	var table = $('#example').dataTable();
        });
</script>
    {!! HTML::script('assets/js/moment.min.js') !!}
    {!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
@stop