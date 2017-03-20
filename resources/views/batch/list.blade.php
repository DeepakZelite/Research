@extends('layouts.app')

@section('page-title', trans('app.batches'))

@section('content')

<div class="row">
    <div class="col-lg-12">
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
    <div class="col-md-2">
        <a href="{{ route('batch.create') }}" class="btn btn-success" id="add-batch">
            <i class="glyphicon glyphicon-plus"></i>
            @lang('app.add_batch')
        </a>
    </div>
    <div class="col-md-7"></div>
    <form method="GET" action="" accept-charset="UTF-8" id="batches-form">
 <!--        <div class="col-md-2">
            {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control']) !!}
        </div>
         -->
        <div class="col-md-3">
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
    <table class="table">
        <thead>
        	<th>@lang('app.name')</th>
            <th>@lang('app.code')</th>
            <th>@lang('app.vendor_name')</th>
            <th>@lang('app.number_of_companies')</th>
            <th>@lang('app.status')</th>
            <th class="text-center">@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($batches))
                @foreach ($batches as $batch)
                    <tr>
                        <td>{{ $batch->name }}</td>
                         <td>{{ $batch->project_code }}</td>
                         <td>{{ $batch->vendor_name }}</td>
                         <td>{{ $batch->No_Companies }}</td>
                         <td>{{ $batch->status}}</td>
                         <td class="text-center">
                          @if($batch->status =="Assigned")
                           <a href="{{ route('batch.delete', $batch->id) }}" class="btn btn-danger btn-circle" title="@lang('app.delete_batch')"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-method="DELETE"
                                    data-confirm-title="@lang('app.please_confirm')'"
                                    data-confirm-text="@lang('app.are_you_sure_delete_batch')"
                                    data-confirm-delete="@lang('app.yes_delete_him')'">
                                <i class="glyphicon glyphicon-trash"></i></a>
                           <!-- <a href="{{ route('batch.edit', $batch->id) }}" class="btn btn-primary btn-circle"
                               title="@lang('app.edit_batch')" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a> -->
                          @endif
                          @if($batch->status=="Complete")
                          		<a href="#" class="btn btn-primary btn-circle"
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
            $("#users-form").submit();
        });
    </script>
@stop
