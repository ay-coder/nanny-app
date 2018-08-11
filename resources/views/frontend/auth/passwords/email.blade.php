@extends('frontend.layouts.authlayout')

@section('content')
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<h3>Forgot Password</h3>
{{ Form::open(['route' => 'frontend.auth.password.email']) }}
    <div class="input-group mb-3 email-wrap">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="icon-envelope"></i></span>
        </div>
        <label for="parent_email" class="sr-only">Enter email</label>
        {{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => "Enter email", 'required' => 'required']) }}
    </div>
    <div class="btn-grpup">
        <button type="submit" class="btn btn-default">Submit</button>
    </div>
{{ Form::close() }}
@endsection