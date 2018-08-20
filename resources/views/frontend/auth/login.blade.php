@extends('frontend.layouts.authlayout')

@section('content')
<h3>Login</h3>
<ul class="nav nav-pills mb-3" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="parents-tab" data-toggle="tab" href="#parents" role="tab" aria-controls="parents" aria-selected="true">Parents</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="sitter-tab" data-toggle="tab" href="#sitter" role="tab" aria-controls="sitter" aria-selected="false">Sitter</a>
    </li>
</ul>

<div class="tab-content" id="tabContent">
    <div class="tab-pane fade show active" id="parents" role="tabpanel" aria-labelledby="parents-tab">
        {{ Form::open(['route' => 'frontend.auth.login']) }}
            <div class="input-group mb-3 email-wrap">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="icon-envelope"></i></span>
                </div>
                <label for="parent_email" class="sr-only">Enter email</label>
                {{ Form::input('email', 'email', null, ['class' => 'form-control', 'required' => 'required','placeholder' => 'Enter email']) }}
            </div>

            {{ Form::hidden('user_type', '1') }}

            <div class="input-group mb-3 password-wrap">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="icon-lock"></i></span>
                </div>
                <label for="parent_password" class="sr-only">Password</label>
                {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => 'Password']) }}
            </div>
            <div class="form-group forgot-password-wrap">
                <a href="{{ route('frontend.auth.password.reset') }}" class="forgot-password">Forgot Password?</a>
            </div>
            <div class="btn-grpup">
                <button type="submit" class="btn btn-default">Log In</button>
                <span class="separator">or</span>

                {{-- {!! $socialite_links !!} --}}

                <a href="{{ route('frontend.auth.social.login', ['provider' => 'google']) }}" class="btn btn-default google-login">Login with Google</a>
                <a href="{{ route('frontend.auth.social.login', ['provider' => 'facebook']) }}" class="btn btn-default facebook-login">Login with facebook</a>

                <span class="acount-link">Don’t have an account? <a href="{{ route('frontend.auth.register') }}">Sign Up</a></span>
            </div>
        {{ Form::close() }}
    </div>

    <div class="tab-pane fade" id="sitter" role="tabpanel" aria-labelledby="sitter-tab">
        {{ Form::open(['route' => 'frontend.auth.login']) }}
            <div class="input-group mb-3 email-wrap">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="icon-envelope"></i></span>
                </div>
                <label for="sitter_email" class="sr-only">Enter email</label>
                {{ Form::input('email', 'email', null, ['class' => 'form-control', 'required' => 'required','placeholder' => 'Enter email']) }}
            </div>
            <div class="input-group mb-3 password-wrap">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="icon-lock"></i></span>
                </div>

                {{ Form::hidden('user_type', '2') }}

                <label for="sitter_password" class="sr-only">Password</label>
                {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => 'Password']) }}
            </div>
            <div class="form-group forgot-password-wrap">
                <a href="{{ route('frontend.auth.password.reset') }}" class="forgot-password">Forgot Password?</a>
            </div>
            <div class="btn-grpup">
                <button type="submit" class="btn btn-default">Log In</button>
            </div>
        {{ Form::close() }}
    </div>
</div>
@stop

@section('after-scripts')

@stop