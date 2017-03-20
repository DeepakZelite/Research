@extends('layouts.app')

@section('page-title', trans('app.dataCapture'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @lang('app.dataCapture')
            <small>@lang('app.list_of_subBatches')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.subBatches')</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
    <div class="col-md-9"></div>
    <form method="GET" action="" accept-charset="UTF-8" id="sub-batches-form">
        <div class="col-md-3">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search')">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search-users-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    @if (Input::has('search') && Input::get('search') != '')
                        <a href="{{ route('subBatch.list') }}" class="btn btn-danger" type="button" >
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
        	<th>@lang('app.batch_name')</th>
            <th>@lang('app.companies')</th>
            <th>@lang('app.status')</th>
            <th>@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($subBatches))
                @foreach ($subBatches as $subBatch)
                    <tr>
                        <td>{{ $subBatch->batch_name }}</td>
                         <td>{{ $subBatch->company_count }}</td>
                         <td>{{ $subBatch->status }}</td>
                         <td class="text-left">
                         @if ($subBatch->status != "Submitted")
                            <a href="{{ route('dataCapture.capture', $subBatch->id) }}" target='_blank' class="btn btn-primary btn-circle"
                               title="@lang('app.start')" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-play"></i>
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

    {!! $subBatches->render() !!}
</div>

@stop

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#sub_batches-form").submit();
        });

        $("#batch_id").change(function() {
			//alert("OnChanged");
             var batchId = $( this ).val();
             var userId = $("#user_id").val();
			//alert(selectedValue);           
            $.ajax({
                method: "GET",
                url: "http://localhost:88/vguard/public/subBatch/getCompanyCount",
                data: {batchId:batchId, userId:userId}
            })
            .done(function(data) {
				var array = data.split(",");
				$("#totalCompanies").val(" No of Companies = " + array[0]);
				$("#unAssignedCompanies").val("Unassigned companies = " + array[1]);
            });
        });
        
    </script>
@stop

