@extends('frontend.layouts.authlayout')

@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<h3>Reset Password</h3>
{{ Form::open(['route' => 'frontend.auth.password.reset']) }}
<input type="hidden" name="token" value="{{ $token }}">
    <div class="input-group mb-3 email-wrap">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="icon-envelope"></i></span>
        </div>
        <label for="parent_email" class="sr-only">Enter email</label>
        {{ Form::input('email', 'readonly_email', $email, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.email'), 'disabled' => 'disabled']) }}
        {{ Form::input('hidden', 'email', $email, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.email')]) }}
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
    <div class="btn-grpup">
        <button type="submit" class="btn btn-default">Submit</button>
    </div>
{{ Form::close() }}
@endsection
