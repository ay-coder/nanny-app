@extends('sitter.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.sitter.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Profile</li>
    </ol>
</div>
<!-- Breadcrumb End -->

<!-- My Profile Content start -->
<div class="my-profile">
    <div class="row">

        <!-- Inner Main Column Start -->
        <div class="col-sm-12 main-column">
            <!-- My Profile view/Edit Start -->
            <div class="white-box">
                <div class="white-box-content">
                    <!-- Parent Detail Start -->
                    <div class="parent-profile">
                        <div class="user parent">
                            <div class="img-wrap">
                                @if(!empty($user->profile_pic))
                                    <img src="{{ url('/uploads/user/'. $user->profile_pic) }}" alt="Profile pic" />
                                @else
                                    <img src="{{url('/default.png')}}" alt="Profile pic">
                                @endif
                            </div>
                            <div class="content-wrap">
                                <h5> {{ $user->name }} @if(!empty($user->age)), {{ $user->age }} yrs @endif</h5>
                                @if(!empty($user->address))
                                <span class="address">{{ $user->address }}
                                    @if(!empty($user->city)),{{ $user->city }} @endif
                                    @if(!empty($user->state)),{{ $user->state }} @endif
                                    @if(!empty($user->zip)),{{ $user->zip }} @endif
                                </span>
                                @endif
                                @if(!empty($user->gender))
                                    <span class="gender">{{ $user->gender }}</span>
                                @endif
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-default btn-edit-profile-sitter">Edit Profile</a>
                    </div>
                    <!-- Parent Detail End -->
                </div>
            </div>
            <!-- My Profile view/Edit End -->
            <div class="white-box about-sitter">
                <div class="white-box-title">
                    <h3>About Me</h3>
                </div>
                <div class="white-box-content">
                    <!-- profile Start -->
                    <div class="profile">
                        <h3>About Me</h3>
                        <p>
                            {{ isset($user->sitter->about_me) ? $user->sitter->about_me : '' }}
                        </p>

                        <h3>Description</h3>
                        <p>
                            {{ isset($user->sitter->description) ? $user->sitter->description : '' }}
                        </p>
                    </div>
                    <!-- Profile End -->
                </div>
            </div>

            <!-- Profile Edit start -->
            <div class="white-box about-sitter-edit">
                {{ Form::open(['route' => 'frontend.auth.password.change', 'id' => 'change-password-form', 'method' => 'patch']) }}
                    <!-- Change password start -->
                    <div class="white-box-title">
                        <h3>Change Password</h3>
                        <button type="submit" class="btn btn-default">Save</button>
                    </div>
                    <div class="white-box-content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Old Password</label>
                                    <input type="password" placeholder="Password" required="required" class="form-control" name="old_password">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">New Password</label>
                                    <input type="password" placeholder="New Password" minlength="6" required="required" class="form-control" name="password">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" placeholder="Confirm Password" minlength="6" required="required" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
                <!-- Change password end -->

                <!-- Schedule start -->
                {{ Form::open(['route' => 'frontend.user.sitter.update', 'id' => 'update-profile-form', 'files' => true, 'enctype'=>'multipart/form-data']) }}
                    <div class="white-box-title">
                        <h3>Update Profile</h3>
                        <button type="submit" class="btn btn-default">Save</button>
                    </div>
                    <div class="white-box-content">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="name">Name</label>
                                {{ Form::input('name', 'name', $user->name, ['class' => 'form-control', 'placeholder' => "Enter name", 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                <label for="email">Email</label>
                                {{ Form::input('email', 'email', $user->email, ['class' => 'form-control', 'placeholder' => "Enter email", 'required' => 'required', 'readonly' => 'readonly']) }}
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mobile">Mobile</label>
                                {{ Form::input('mobile', 'mobile', $user->mobile, ['class' => 'form-control', 'placeholder' => 'Mobile Number', 'required' => 'required']) }}
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="dob">Birthday</label>
                                {{ Form::text('birthdate', (!empty($user->birthdate)) ? \Carbon\Carbon::createFromFormat('d/m/Y',$user->birthdate)->format('d/m/Y') : null, ['class' => 'form-control date', 'placeholder' => 'Birthday', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                <label for="location">Address</label>
                                {{ Form::text('address', $user->address, ['class' => 'form-control', 'placeholder' => 'Address', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-4">
                                <label for="gender">Gender</label>
                                {{ Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], $user->gender, ['class' => 'form-control', 'placeholder' => 'Select', 'required' => 'required']) }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Start Time</label>
                                    {{ Form::text('sitter_start_time', !empty($user->sitter->sitter_start_time) ? \Carbon\Carbon::parse($user->sitter->sitter_start_time)->format('H:i:s') : null, ['class' => 'form-control startTime', 'placeholder' => 'Start Time', 'required' => 'required']) }}
                                </div>
                                <div class="form-group">
                                    <label for="">End Time</label>
                                    {{ Form::text('sitter_end_time', !empty($user->sitter->sitter_end_time) ?  \Carbon\Carbon::parse($user->sitter->sitter_end_time)->format('H:i:s') : null, ['class' => 'form-control endTime', 'placeholder' => 'End Time', 'required' => 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">About Me</label>
                                    {{ Form::textarea("about_me", $user->sitter->about_me, ['class' => 'form-control', 'placeholder' => 'About me', 'required' => 'required', 'rows' => 5]) }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group upload-image">
                                    <label for="name" class="inputFilelabel"></label>
                                    {{ Form::file('profile_pic', ['class' => 'inputFile', 'id' => 'parent-image']) }}
                                    @if(!empty($user->profile_pic))
                                        <img class="image_upload_preview" src="{{ url('/uploads/user/'. $user->profile_pic) }}" alt="Profile pic" />
                                    @else
                                        <img class="image_upload_preview" src="{{url('/default.png')}}" alt="Profile pic">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Description</label>
                                    {{ Form::textarea("description", $user->sitter->description, ['class' => 'form-control', 'placeholder' => 'Description', 'required' => 'required', 'rows' => 6]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
                <!-- Schedule end -->
            </div>
            <!-- Profile Edit end -->
        </div>
        <!-- Inner Main Column Start -->
    </div><!-- .row end -->
</div><!-- .my-profile end -->

<!-- My Profile Content start -->
@endsection
@section('after-scripts')
<script>
    $(document).ready(function(){
        Nanny.Account();
    });
</script>
@stop