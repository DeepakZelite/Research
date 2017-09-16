@extends('layouts.app')

@section('page-title', trans('app.add_user'))

@section('content')

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h1 class="page-header">
            @lang('app.create_new_user')
            <small>@lang('app.user_details')</small>
            <div class="pull-right">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}">@lang('app.home')</a></li>
                    <li><a href="{{ route('user.list') }}">@lang('app.users')</a></li>
                    <li class="active">@lang('app.create')</li>
                </ol>
            </div>
        </h1>
    </div>
</div>

@include('partials.messages')

{!! Form::open(['route' => 'user.store', 'files' => true, 'id' => 'user-form']) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            @include('user.partials.details', ['edit' => false, 'profile' => false])
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            @include('user.partials.auth', ['edit' => false])
        </div>
    </div>

    <div class="row">
    	<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2"></div>
        <div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
            <button type="submit" id="btnSubmit" class="btn btn-primary btn-block">
                <i class="fa fa-save"></i>
                @lang('app.create_user')
            </button>
        </div>
    	<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2">
        	<a href="{{ route('user.list') }}" class="btn btn-primary btn-block" id="cancel">
            	@lang('app.cancel')
        	</a>
    	</div>        
    </div>
{!! Form::close() !!}

@stop

@section('styles')
    {!! HTML::style('assets/css/bootstrap-datetimepicker.min.css') !!}
@stop

@section('scripts')
<script>
$("#vendor_id").attr('disabled','disabled');
$("#role").change(function() 
{
		var roleid= $( this ).val();
		if(roleid == '1' || roleid == '4' || roleid == '5')
		{
			//alert($("#vendor_id").val());
			//$("#vendor_id option:eq(1)").attr('selected','selected');
			$("#vendor_id").attr('disabled', 'disabled');
		}
		else
		{
			$("#vendor_id").removeAttr('disabled');
		}
});
$(document).ready(function() {
$("#btnSubmit").click(function(event)
{
   if($("#vendor_id").val()==0 && $("#role").val() == 1 || $("#role").val() == 4 || $("#role").val() == 5)
   {
	return true;
   }
   else if($("#vendor_id").val()==0)
   {
	$("#vendor_id").css('border-color', 'red');
	return false;
   }
   else
   {
	return true;
    }
});
});

</script>
    {!! HTML::script('assets/js/moment.min.js') !!}
    {!! HTML::script('assets/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\User\CreateUserRequest', '#user-form') !!}
@stop
