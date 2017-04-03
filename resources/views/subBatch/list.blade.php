@extends('layouts.app')

@section('page-title', trans('app.subBatches'))

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            @lang('app.subBatches')
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
    <div class="col-md-12">
    <!-- <form method="GET" action="" accept-charset="UTF-8" id="assign-form"> -->
    	{!! Form::open(['route' => 'subBatch.store', 'id' => 'assign-form']) !!}
       
         <div class="col-md-3">
            {!! Form::select('batch_id', $batches, Input::get('batch'), ['class' => 'form-control', 'id' => 'batch_id']) !!}
        </div>
        <div class="col-md-3">
             	{!! Form::select('user_id', $users, Input::get('user'), ['class' => 'form-control', 'id' => 'user_id']) !!}
        </div>
        <div class="col-md-3">
        <input type="text" class="form-control" id="company_count"
                           name="company_count" placeholder="@lang('app.no_of_records')" value="">
        </div>
        <div class="col-md-1">
        	<!-- <a href="{{ route('subBatch.store') }}" class="btn btn-success" id="add-subbatch">
            	<i class="glyphicon glyphicon-plus"></i>
            	@lang('app.assign')
        	</a> -->
        	<button type="submit" class="btn btn-success">
            <i class="fa fa-save"></i>
            @lang('app.assign')
        </button>
    	</div>
        
    <!-- </form> -->
    </div>
</div><!-- First Assign Row  -->
<div class="row tab-search">
    <div class="col-md-12">
    <form method="GET" action="" accept-charset="UTF-8" id="assign-form">
         <div class="col-md-3">
        <input type="text" disabled class="form-control" id="totalCompanies"
                           name="totalCompanies" placeholder="@lang('app.no_of_companies')" value="">
        </div>
        <div class="col-md-3">
        <input type="text" disabled class="form-control" id="unAssignedCompanies"
                           name="unAssignedCompanies" placeholder="@lang('app.unassigned_companies')" value="">
        </div>
    </form>
    </div>
</div><!-- Second Assign Row  -->
<div class="row tab-search">
    <div class="col-md-7"></div>
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
            <th>@lang('app.sub_batch_name')</th>
            <th>@lang('app.assigned_user')</th>
            <th>@lang('app.companies')</th>
            <th class="text-center">@lang('app.task_brief')</th>
            <th>@lang('app.status')</th>
            <th class="text-center">&nbsp;@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($subBatches))
                @foreach ($subBatches as $subBatch)
                    <tr>
                        <td>{{ $subBatch->batch_name }}</td>
                        <!-- <td>{{ $subBatch->sub_batch_name }}</td>-->
                         <td>{{ $subBatch->batch_name }}-{{ $subBatch->sub_batch_name }}</td>
                         <td>{{ $subBatch->username }}</td>
                         <td>{{ $subBatch->company_count }}</td>
                         <td class="text-center"><a href="{{ URL::to('project/download',$subBatch->brief_file) }}" class="btn btn-primary btn-circle"
                               title="@lang('app.download')" data-toggle="tooltip" data-placement="top">
                                <i class="fa fa-info-circle"></i>
                            </a></td>
                         <td>{{ $subBatch->status }}</td>
                         <td class="text-center">
                            @if($subBatch->status =="Assigned")
                           <a href="{{ route('subBatch.delete', $subBatch->id) }}" class="btn btn-danger btn-circle" title="@lang('app.delete_subBatch')"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-method="DELETE"
                                    data-confirm-title="@lang('app.please_confirm')"
                                    data-confirm-text="@lang('app.are_you_sure_delete_batch')"
                                    data-confirm-delete="@lang('app.yes')">
                                <i class="glyphicon glyphicon-trash"></i></a>
                          @endif
                          <!--  <a href="{{ route('batch.edit', $subBatch->id) }}" class="btn btn-primary btn-circle"
                               title="@lang('app.edit_batch')" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-edit"></i>
                            </a>-->
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
  <!--   {!! HTML::script('assets/js/jquery-2.1.4.min.js') !!}
    {!! HTML::script('assets/js/bootstrap.min.js') !!}
    {!! HTML::script('assets/js/metisMenu.min.js') !!}
    {!! HTML::script('assets/js/sweetalert.min.js') !!}
    {!! HTML::script('assets/js/delete.handler.js') !!}
    {!! HTML::script('assets/plugins/js-cookie/js.cookie.js') !!}
    {!! HTML::script('assets/js/count.js') !!}
    <script type="text/javascript">-->
    <script>
        $("#status").change(function () {
            //alert("status changes");
            $("#sub-batches-form").submit();
        });
        $("#batch_id").change(function() {
			//alert("OnChanged");
             var batchId = $( this ).val();
             //alert(" "+batchId)
             var userId = $("#user_id").val();
			//alert(" "+userId);           
            $.ajax({
                method: "GET",
                url: "{{ route('subBatch.getCompanyCount') }}",
                //url: "http://192.168.1.108:88/Research/public/subBatch/getCompanyCount",
                data: {batchId:batchId, userId:userId}
            })
            .done(function(data) {
				var array = data.split(",");
				$("#totalCompanies").val(" No of Companies = " + array[0]);
				$("#unAssignedCompanies").val("Unassigned companies = " + array[1]);
            });
        });

    </script>
        {!! JsValidator::formRequest('Vanguard\Http\Requests\SubBatch\CreateSubBatchRequest', '#sub_batches-form') !!}
@stop

