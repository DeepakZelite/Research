@extends('layouts.app')

@section('page-title', trans('app.batches'))

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            @lang('app.batches')
            <small>@lang('app.list_of_batches')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.batches')</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <a href="{{ route('batch.create') }}" class="btn btn-success" id="add-batch">
            <i class="glyphicon glyphicon-plus"></i>
            @lang('app.add_batch')
        </a>
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    <form method="GET" action="" accept-charset="UTF-8" id="batches-form">
    	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                {!! Form::select('code', $projects, Input::get('code'), ['id'=>'code', 'class'=>'form-control'])!!}
        </div>
    	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                {!! Form::select('vendor_code', $vendors, Input::get('vendor_code'), ['id'=>'vendor_code', 'class'=>'form-control'])!!}
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
               {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control']) !!}
        </div> 
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search_for_batches')">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search-users-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    @if (Input::has('search') && Input::get('search') != '')
                        <a href="{{ route('batch.list') }}" class="btn btn-danger" type="button" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    @endif
                </span>
            </div>
        </div>
    </form>
</div>

<div class="table-responsive top-border-table" id="users-table-wrapper">
    <table class="table" id="batch_table">
        <thead>
        	<th>@sortablelink('name',trans('app.batch_name'))</th>
            <th>@sortablelink('code',trans('app.code'))</th>
            <th>@sortablelink('vendor_code',trans('app.vendor_code'))</th>
            <th>@sortablelink('No_Companies',trans('app.number_of_companies'))</th>
            <th class="text-primary">@lang('app.status')</th>
            <th class="text-center text-primary">@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($batches))
                @foreach ($batches as $batch)
                    <tr>
                        <td>{{ $batch->name }}</td>
                         <td>{{ $batch->project_code }}</td>
                         <td>{{ $batch->vendor_code }}</td>
                         <td>{{ $batch->company_count }}</td>
                         <td>{{ $batch->status}}</td>
                         <td class="text-center">
                          @if($batch->status =="Assigned")
                           <a href="{{ route('batch.delete', $batch->id) }}" class="btn btn-danger btn-circle" title="@lang('app.delete_batch')"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-method="DELETE"
                                    data-confirm-title="@lang('app.please_confirm')"
                                    data-confirm-text="@lang('app.are_you_sure_delete_batch')"
                                    data-confirm-delete="@lang('app.yes')">
                                <i class="glyphicon glyphicon-trash"></i></a>
                          @endif
                          @if($batch->status=="Complete")
                          		<a href="{{ route('batch.download',$batch->id) }}" class="btn btn-primary btn-circle"
                               		title="@lang('app.download')" data-toggle="tooltip" data-placement="top">
                                	<i class="glyphicon glyphicon-download"></i>
                            	</a>
                          @endif
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

    {!! $batches->render() !!}
</div>

@stop

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#batches-form").submit();
        });
        $("#vendor_code").change(function (){
            $("#batches-form").submit();
        });
        $("#code").change(function (){
            $("#batches-form").submit();
        });
    </script>
@stop
