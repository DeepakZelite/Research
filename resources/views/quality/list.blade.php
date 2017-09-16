@extends('layouts.app')

@section('page-title', trans('app.quality-analysis'))

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            @lang('app.main_database')
            <!-- <small>@lang('app.list_of_batches')</small> -->
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.quality')</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')



<div class="row">
   <br><br>
</div>
<div class="row tab-search">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="text-align:center;">
        <a href="{{ route('quality.create') }}" class="btn btn-success" id="upload-qc">
            <i class="glyphicon glyphicon-plus"></i>
            @lang('app.upload_mdb')
        </a>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="text-align:center;">
        <a href="{{ route('quality.optionlist') }}" class="btn btn-success" id="download-qc">
            <i class="glyphicon glyphicon-download"></i>
            @lang('app.download_mdb')
        </a>
    </div>
</div>
@stop

