@extends('layouts.auth')

@section('page-title', trans('app.login'))

@section('content')

<div class="form-wrap col-xs-5 col-md-5 auth-form" id="login">
    <div style="text-align: center; margin-bottom: 25px;">
        <img src="{{ url('assets/img/vanguard-logo.png') }}" alt="{{ settings('app_name') }}">
    </div>

    {{-- This will simply include partials/messages.blade.php view here --}}
    @include('partials/messages')

    <form role="form" action="<?= url('login') ?>" method="POST" id="login-form" autocomplete="off">
        <input type="hidden" value="<?= csrf_token() ?>" name="_token">

        @if (Input::has('to'))
            <input type="hidden" value="{{ Input::get('to') }}" name="to">
        @endif

        <div class="form-group input-icon">
            <label for="username" class="sr-only">@lang('app.email_or_username')</label>
            <i class="fa fa-user"></i>
            <input type="email" name="username" id="username" class="form-control" placeholder="@lang('app.email_or_username')">
        </div>
        <div class="form-group password-field input-icon">
            <label for="password" class="sr-only">@lang('app.password')</label>
            <i class="fa fa-lock"></i>
            <input type="password" name="password" id="password" class="form-control" placeholder="@lang('app.password')">
<!--             @if (settings('forgot_password')) -->
                <!-- <a href="<?= url('password/remind') ?>" class="forgot">@lang('app.i_forgot_my_password')</a> -->
<!--             @endif -->
        </div>
        <div class="checkbox">

            @if (settings('remember_me'))
                <input type="checkbox" name="remember" id="remember" value="1"/>
                <label for="remember">@lang('app.remember_me')</label>
            @endif

            <!-- @if (settings('reg_enabled'))
                <a href="<?= url("register") ?>" style="float: right;">@lang('app.dont_have_an_account')</a>
            @endif -->
        </div>
        <div class="form-group">
             <button type="submit" class="btn btn-custom btn-lg btn-block" id="btn-login">
                @lang('app.log_in')
            </button>
        </div>
       
    </form>

    <!--  @include('auth.social.buttons')-->

</div>

@stop

@section('scripts')
<script>
window.location.hash="#";
window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
window.onhashchange=function(){window.location.hash="#";}
</script>
    {!! HTML::script('assets/js/as/login.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\Auth\LoginRequest', '#login-form') !!}
@stop