@extends('layouts.app')

@section('page-title', trans('app.projects'))

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            @lang('app.projects')
            <small>@lang('app.list_of_projects')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li class="active">@lang('app.projects')</li>
                </ol>
            </div>

        </h1>
    </div>
</div>

@include('partials.messages')

<div class="row tab-search">
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <a href="{{ route('project.create') }}" class="btn btn-success" id="add-project">
            <i class="glyphicon glyphicon-plus"></i>
            @lang('app.add_project')
        </a>
    </div>
    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7"></div>
    <form method="GET" action="" accept-charset="UTF-8" id="projects-form">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="@lang('app.search_for_projects')">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search-users-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    @if (Input::has('search') && Input::get('search') != '')
                        <a href="{{ route('project.list') }}" class="btn btn-danger" type="button" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    @endif
                </span>
            </div>
        </div>
    </form>
</div>

<div class="table-responsive top-border-table" id="users-table-wrapper">
    <table class="table" id="project_table">
        <thead>
        	<th>@sortablelink('code',trans('app.code'))</th>
            <th>@sortablelink('No_Companies',trans('app.no_of_companies'))</th>
            <th>@sortablelink('Expected_Staff',trans('app.expected_staff'))</th>
            <th class="text-center text-primary">@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($projects))
                @foreach ($projects as $project)
                    <tr>
                    	<td>{{ $project->code }}</td>
                     <!--    <td>{{ $project->name }}</td> -->
                        <td>{{ $project->No_Companies }}</td>
                        <td>{{ $project->Expected_Staff }}</td>                   
                         <td class="text-center">
                            <a href="{{ route('project.edit', $project->id) }}" class="btn btn-primary btn-circle"
                               title="@lang('app.edit_project')" data-toggle="tooltip" data-placement="top">
                                <i class="glyphicon glyphicon-edit"></i>
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

    {!! $projects->render() !!}
</div>

@stop

@section('scripts')
    <script>
        $("#status").change(function () {
            $("#users-form").submit();
        });
    </script>
@stop
