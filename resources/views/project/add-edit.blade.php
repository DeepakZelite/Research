@extends('layouts.app')

@section('page-title', trans('app.projects'))

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            {{ $edit ? $project->name : trans('app.create_new_project') }}
            <small>{{ $edit ? trans('app.edit_project_details') : trans('app.project_details') }}</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('project.list') }}">@lang('app.projects')</a></li>
                    <li class="active">{{ $edit ? trans('app.edit') : trans('app.create') }}</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['project.update', $project->id], 'method' => 'PUT', 'id' => 'project-form']) !!}
@else
    {!! Form::open(['route' => 'project.store', 'id' => 'project-form']) !!}
@endif

<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.project_details_big')</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.project_name')" value="{{ $edit ? $project->name : old('name') }}">
                </div>
                 <div class="form-group">
                    <label for="description">@lang('app.description')</label>
                    <input type="text" class="form-control" id="description"
                           name="description" placeholder="@lang('app.description')" value="{{ $edit ? $project->description : old('description') }}">
                </div>
                <!-- <div class="form-group">
                    <label for="description">@lang('app.description')</label>
                    <textarea name="description" id="description" class="form-control">{{ $edit ? $project->description : old('description') }}</textarea>
                </div>
                 -->
                </div>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.update_project') : trans('app.create_project') }}
        </button>
    </div>
</div>

@stop

@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Project\UpdateProjectRequest', '#project-form') !!}
    @else
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Project\CreateProjectRequest', '#project-form') !!}
    @endif
@stop