@extends('frontend.layouts.authlayout')

@section('content')
<h3>Create Account</h3>
{{ Form::open(['route' => 'frontend.auth.register']) }}
    <div class="input-group mb-3 user-wrap">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="icon-user"></i></span>
        </div>
        <label for="parent_name" class="sr-only">Enter your name</label>
        {{ Form::input('name', 'name', null, ['class' => 'form-control', 'placeholder' => 'Enter your name', 'required' => 'required']) }}
    </div>

    <div class="input-group mb-3 email-wrap">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="icon-envelope"></i></span>
        </div>
        <label for="parent_email" class="sr-only">Enter email</label>
        {{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => "Enter email", 'required' => 'required']) }}
    </div>

    <div class="input-group mb-3 password-wrap">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="icon-lock"></i></span>
        </div>
        <label for="parent_password" class="sr-only">Password</label>
        {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => 'Password', 'required' => 'required']) }}
    </div>

    <div class="input-group mb-3 confirm-password-wrap">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="icon-lock"></i></span>
        </div>
        <label for="parent_confirm_password" class="sr-only">Confirm Password</label>
        {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => 'Confirm Password', 'required' => 'required']) }}
    </div>

    {{ Form::hidden('user_type', 1) }}

    <div class="input-group mb-3 confirm-password-wrap">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="icon-screen-smartphone"></i></span>
        </div>
        <label for="parent_mobile" class="sr-only">Mobile Number</label>
        {{ Form::input('mobile', 'mobile', null, ['class' => 'form-control', 'placeholder' => 'Mobile Number', 'required' => 'required']) }}
    </div>

    @if (config('access.captcha.registration'))
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {!! Form::captcha() !!}
                {{ Form::hidden('captcha_status', 'true') }}
            </div><!--col-md-6-->
        </div><!--form-group-->
    @endif
    <div class="btn-grpup">
        <button type="submit" class="btn btn-default">Sign Up</button>
        <span class="separator">or</span>
        <a href="#" class="btn btn-default google-login">Signup with Google</a>
        <a href="#" class="btn btn-default facebook-login">signup with facebook</a>
        <span class="acount-link">Already a member? <a href="{{ route('frontend.auth.login') }}">Log In</a></span>
    </div>
{{ Form::close() }}
<div class="row text-center">
    {!! $socialite_links !!}
</div>
@endsection

@section('after-scripts')
    @if (config('access.captcha.registration'))
        {!! Captcha::script() !!}
    @endif
@endsection