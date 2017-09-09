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
    <div class="col-md-7">
    	<span id="lblnotify" style="color:Red"></span>
    </div>
    <form method="GET" action="" accept-charset="UTF-8" id="sub-batches-form">
    <div class="col-md-2">
                {!! Form::select('status', $statuses, Input::get('status'), ['id' => 'status', 'class' => 'form-control']) !!}   
        </div> 
        
        <div class="col-md-3">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search')">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search-users-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    @if (Input::has('search') && Input::get('search') != '')
                        <a href="{{ route('dataCapture.list') }}" class="btn btn-danger" type="button" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    @endif
                </span>
            </div>
        </div>
    </form>
</div>

<div class="table-responsive top-border-table" id="users-table-wrapper">
    <table class="table" id="dataCapture_table">
        <thead>
        	<th>@lang('app.batch_name')</th>
        	<th>@lang('app.sub_batch_name')</th>
        	<th>@lang('app.code')</th>
            <th>@lang('app.allocated_companies')</th>
            <th>@lang('app.remaining_companies')</th>
            <th class="nosort">@lang('app.status')</th>
            <th class="nosort">@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($subBatches))
                @foreach ($subBatches as $subBatch)
                    <tr>
                        <td>{{ $subBatch->batch_name }}</td>
                        <td>{{ $subBatch->batch_name }}-{{ $subBatch->sub_batch_name }}</td>
                        <td>{{ $subBatch->project_code}}</td>
                         <td>{{ $subBatch->company_count }}</td>
                         <td>{{ $subBatch->count}}	</td>
                         <td>{{ $subBatch->status }}</td>
                         <td class="text-left" id="status">
                         @if($statuscount!=0)
                         	@if ($subBatch->status != "Submitted" && $subBatch->status != "Assigned")
                            	<a href="{{ route('dataCapture.starttimecapture', $subBatch->id) }}" id="btnStart" target='_blank' class="btn btn-primary btn-circle"
                               			title="@lang('app.start')" data-toggle="tooltip" data-placement="top">
                                		<i class="glyphicon glyphicon-play"></i>
                            	</a>
                            	<a href="#" class="btn btn-danger btn-circle" id="btnClose"
                               			title="@lang('app.stop')" data-toggle="tooltip" data-placement="top">
                                 		<i class="glyphicon glyphicon-stop"></i>
                         		</a> 
                         	@endif
                         @else
                         	@if ($subBatch->status != "Submitted")
                            	<a href="{{ route('dataCapture.starttimecapture', $subBatch->id) }}" id="btnStart" target='_blank' rel="noreferrer" class="btn btn-primary btn-circle"
                               			title="@lang('app.start')" data-toggle="tooltip" data-placement="top">
                                		<i class="glyphicon glyphicon-play"></i>
                            	</a>
                            	<a href="#" class="btn btn-danger btn-circle" id="btnClose"
                               			title="@lang('app.stop')" data-toggle="tooltip" data-placement="top">
                                 		<i class="glyphicon glyphicon-stop"></i>
                         		</a> 
                         	@endif
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
    var count="";
	@foreach ($subBatches as $subBatch)
		@if($subBatch->notify != '')
			count += "{{ $subBatch->batch_name }}-{{ $subBatch->sub_batch_name }},";
		@endif 
	@endforeach
	if(count != "")
	{
		$('#lblnotify').text("High Priority: "+count+" Batch is reallocated! please check");
	}
		
	$("[id=btnStart]").click(function(){
		localStorage.setItem('close', Date.now());
		$("[id=btnStart]").hide();//$('#btnStart').css("visibility","hidden");
		$("[id=btnClose]").show();//$('#btnClose').css("visibility","visible");
	});
	$("[id=btnClose]").click(function(){
		localStorage.removeItem('close');
		$("[id=btnClose]").hide();//$('#btnClose').css("visibility", "hidden");
		$("[id=btnStart]").show();//$('#btnStart').css("visibility","visible");
	});
	if(!localStorage.getItem('close'))
	{
		$("[id=btnClose]").hide();//$('#btnClose').css("visibility", "hidden");
		$("[id=btnStart]").show();//$('#btnStart').css("visibility","visible");
	}else{
		$("[id=btnStart]").hide();//$('#btnStart').css("visibility","hidden");
		$("[id=btnClose]").show();//$('#btnClose').css("visibility","visible");
	}
        $("#status").change(function () {
            $("#sub-batches-form").submit();
        });
        $(document).ready(function() {
        	//$(window).focus(function(){ window.location.reload(); });
            $('#dataCapture_table').dataTable( {
                "bPaginate": false,
                "bFilter": false,
                "bInfo": false,
                "order": [[ 5, "asc" ]],
                aoColumnDefs: [
              	  {
              	     bSortable: false,
              	     aTargets: [ 'nosort' ]
              	  }
              	]
             } );
        } );
    </script>
@stop

