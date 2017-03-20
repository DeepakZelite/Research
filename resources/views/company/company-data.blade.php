@extends('layouts.app')

@section('page-title', trans('app.companys'))

@section('content')

@include('partials.messages')

@if ($edit)
    {!! Form::open(['route' => ['dataCapture.storeCompany', $company->id], 'method' => 'PUT', 'id' => 'company-form']) !!}
@else
    {!! Form::open(['route' => 'dataCapture.storeCompany', 'id' => 'company-form']) !!}
@endif

<br/>
<div class="row">
    <!--First Section-->
    <div class="col-lg-12 col-md-8 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.company_details_big')
            </div>
            
            <div class="panel-body">
                <div class="form-group col-lg-2">
                    <label for="name">@lang('app.name')</label>
                    <input type="text" class="form-control" id="name"
                           name="name" placeholder="@lang('app.company_name')" value="{{ $edit ? $company->name : old('name') }}">
                </div>
                <div class="form-group col-lg-2">
                    <label for="name">@lang('app.website')</label>
                    <input type="text" class="form-control" id="website"
                           name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('website') }}">
                </div>
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.name')</label> -->
<!--                     <input type="text" class="form-control" id="name" -->
<!--                            name="name" placeholder="@lang('app.company_name')" value="{{ $edit ? $company->name : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.name')</label> -->
<!--                     <input type="text" class="form-control" id="name" -->
<!--                            name="name" placeholder="@lang('app.company_name')" value="{{ $edit ? $company->name : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.name')</label> -->
<!--                     <input type="text" class="form-control" id="name" -->
<!--                            name="name" placeholder="@lang('app.company_name')" value="{{ $edit ? $company->name : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
<!--      <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.name')</label> -->
<!--                     <input type="text" class="form-control" id="name" -->
<!--                            name="name" placeholder="@lang('app.company_name')" value="{{ $edit ? $company->name : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-4"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
<!--                 <div class="form-group col-lg-2"> -->
<!--                     <label for="name">@lang('app.website')</label> -->
<!--                     <input type="text" class="form-control" id="website" -->
<!--                            name="website" placeholder="@lang('app.website')" value="{{ $edit ? $company->website : old('name') }}"> -->
<!--                 </div> -->
               
              </div>
            </div>
        </div>
    </div>

<div class="row">
<div class="col-md-10">
</div>
    <div class="col-md-1">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.save') : trans('app.save') }}
        </button>
    </div>
    @if ($edit)
    <div class="col-md-1">
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">
            <i class="fa fa-save"></i>
            {{ trans('app.add_contact') }}
        </button>
    </div>
    @endif
</div>
{{ Form::close() }}
<br/>
<div class="row">
<div class="table-responsive top-border-table" id="users-table-wrapper">
    <table class="table">
        <thead>
        	<th>@lang('app.first_name')</th>
            <th>@lang('app.last_name')</th>
            <th>@lang('app.email')</th>
            <th>@lang('app.designation')</th>
            <th>@lang('app.action')</th>
        </thead>
        <tbody>
            @if (count($contacts))
                @foreach ($contacts as $contact)
                    <tr>
                         <td>{{ $contact->first_name }}</td>
                         <td>{{ $contact->last_name }}</td>
                         <td>{{ $contact->email }}</td>
                         <td>{{ $contact->designation }}</td>
                         <td class="text-left">
<!--                             <a href="{{ route('batch.edit', $contact->id) }}" class="btn btn-primary btn-circle" -->
<!--                                title="@lang('app.edit_batch')" data-toggle="tooltip" data-placement="top"> -->
<!--                                 <i class="glyphicon glyphicon-edit"></i> -->
<!--                             </a> -->
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

     {!! $contacts->render() !!} 
</div>


</div>


<div class="row">
<div class="col-md-11">
</div>

    <div class="col-md-1">
    <a href="{{ route('dataCapture.submitCompany', $company->id) }}" class="btn btn-primary btn-block pull-right">Submit</a>
    </div>
</div>


<!-- Modal -->
<style>
<!--
 @media screen and (min-width: 768px) { 
	
 	#myModal .modal-dialog  {width:900px;} 

 } 
-->
</style>

 @if ($edit)
  {!! Form::open(['route' => ['dataCapture.storeStaff', $company->id], 'id' => 'staff-form']) !!} 
<!--          {!! Form::open(['route' => ['dataCapture.storeStaff', $company->id], 'id' => 'staff-form']) !!}  -->
 @else
    
         {!! Form::open(['route' => ['dataCapture.storeStaff', $company->id], 'method' => 'PUT', 'id' => 'staff-form']) !!} -->
    
@endif

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">@lang('app.staff_details_big')</div>
            <div class="panel-body">
                <div class="form-group col-lg-6">
                    <label for="firstName">@lang('app.first_name')</label>
                    <input type="text" class="form-control" id="first_name"
                           name="first_name" placeholder="@lang('app.first_name')" value="">
                </div>
                <div class="form-group col-lg-6">
                    <label for="middleName">@lang('app.middle_name')</label>
                    <input type="text" class="form-control" id="middle_name"
                           name="middle_name" placeholder="@lang('app.middle_name')" value="">
                </div>
                <div class="form-group col-lg-6">
                    <label for="name">@lang('app.last_name')</label>
                    <input type="text" class="form-control" id="last_name"
                           name="last_name" placeholder="@lang('app.last_name')" value="">
                </div>
                <div class="form-group col-lg-6">
                    <label for="email">@lang('app.email')</label>
                    <input type="text" class="form-control" id="email"
                           name="email" placeholder="@lang('app.email')" value="">
                </div>
                <div class="form-group col-lg-6">
                    <label for="isdCode">@lang('app.isd_code')</label>
                    <input type="text" class="form-control" id="isd_code"
                           name="isd_code" placeholder="@lang('app.isd_code')" value="">
                </div>
                <div class="form-group col-lg-6">
                    <label for="areaCode">@lang('app.area_code')</label>
                    <input type="text" class="form-control" id="area_code"
                           name="area_code" placeholder="@lang('app.area_code')" value="">
                </div>
                <div class="form-group col-lg-6">
                    <label for="phone">@lang('app.phone')</label>
                    <input type="text" class="form-control" id="phone"
                           name="phone" placeholder="@lang('app.phone')" value="">
                </div>
                <div class="form-group col-lg-6">
                    <label for="alternatePhone">@lang('app.alternate_phone')</label>
                    <input type="text" class="form-control" id="alternate_phone"
                           name="alternate_phone" placeholder="@lang('app.alternate_phone')" value="">
                </div>
                <div class="form-group col-lg-6">
                    <label for="designation">@lang('app.designation')</label>
                    <input type="text" class="form-control" id="designation"
                           name="designation" placeholder="@lang('app.designation')" value="">
                </div>
                <div class="form-group col-lg-12">
                    
                <label for="staffNote">@lang('app.staff_note')</label>
                    <textarea name="staff_note" id="staff_note" class="form-control"></textarea>
                
                </div>
              </div>
            </div>
        </div>
    </div>

<div class="row">
<div class="col-md-8"></div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.save') : trans('app.save') }}
        </button>
    </div>
    <div class="col-md-2">
        <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="fa fa-save"></i>
            {{ $edit ? trans('app.cancel') : trans('app.cancel') }}
        </button>
    </div>
</div>
      </div>
     
    </div>

  </div>
</div>


@stop


@section('scripts')
    <script>
hideMenu();
function hideMenu() {
	as.toggleSidebar()
}
$('#myModal').on('shown.bs.modal', function() {
	  $('#firstName').focus();
	})

    </script>
@stop


@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop
@section('scripts')
    @if ($edit)
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Company\UpdateCompanyRequest', '#company-form') !!}
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Contact\CreateContactRequest', '#staff-form') !!}
    @else
        {!! JsValidator::formRequest('Vanguard\Http\Requests\Company\CreateCompanyRequest', '#company-form') !!}

    @endif
    
    
    {!! HTML::script('assets/js/moment.min.js') !!}
    {!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
@stop


