@extends('parent.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.parent.dashboard') }}">Home</a></li>
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
                        <a href="javascript:void(0)" class="btn btn-default btn-edit-profile">Edit Profile</a>
                    </div>
                    <!-- Parent Detail End -->

                    <!-- Parent Detail Edit form Start-->
                    <div class="parent-profile edit">
                        {{ Form::open(['route' => 'frontend.user.parent.update', 'files' => true, 'enctype'=>'multipart/form-data']) }}
                            <div class="form-row">
                                <div class="form-group upload-image">
                                    <label for="name" class="inputFilelabel"></label>
                                    {{ Form::file('profile_pic', ['class' => 'inputFile', 'id' => 'parent-image']) }}
                                    @if(!empty($user->profile_pic))
                                        <img class="image_upload_preview" src="{{ url('/uploads/user/'. $user->profile_pic) }}" alt="Profile pic" />
                                    @else
                                        <img class="image_upload_preview" src="{{url('/default.png')}}" alt="Profile pic">
                                    @endif
                                </div>
                                <div class="profile-progress">
                                    <h5>Profile Completion</h5>
                                    <div class="progress-wrap">
                                        <span class="complete-percentage">{{ profileCompletion(access()->user()) }}%</span>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ profileCompletion(access()->user()) }}%" aria-valuenow="{{ profileCompletion(access()->user()) }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    {{ Form::text('birthdate', (!empty($user->birthdate)) ? \Carbon\Carbon::createFromFormat('d/m/Y',$user->birthdate)->format('d/m/Y') : null, ['class' => 'form-control pastdate', 'placeholder' => 'Birthday', 'required' => 'required']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="location">Address</label>
                                    {{ Form::text('address', $user->address, ['class' => 'form-control', 'placeholder' => 'Address', 'required' => 'required']) }}
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="gender">Gender</label>
                                    {{ Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], $user->gender, ['class' => 'form-control custom-select-gender', 'placeholder' => 'Select', 'required' => 'required']) }}
                                </div>
                            </div>
                            <input type="submit" class="btn btn-default" value="Save">
                        {{ Form::close() }}
                    </div>
                    <!-- Parent Detail Edit form End -->
                </div>
            </div>
            <!-- My Profile view/Edit End -->

            <!-- My Children view/Add/Edit Start -->
            <div class="white-box">
                <div class="white-box-title">
                    <h3>My Children</h3>
                    <div class="title-btn-wrap">
                        <a href="javascript:void(0)" class="btn btn-default btn-add">Add New</a>
                        @if(count($user->babies) > 0)
                            <a href="javascript:void(0)" class="btn btn-default btn-edit">Edit</a>
                        @endif
                    </div>
                </div>
                <div class="white-box-content">
                    <!-- Childred List Start -->
                    <div class="childern-list">
                        <div class="row">
                            @if(isset($user->babies) && count($user->babies) > 0)
                                @foreach($user->babies as $baby)
                                    <div class="col-sm-6">
                                        <div class="baby large">
                                            <div class="baby-info">
                                                <div class="img-wrap">
                                                    <img src="{{ url('/uploads/babies/'. $baby->image) }}" alt="">
                                                </div>
                                                <div class="content-wrap">
                                                    <h5>{{ $baby->title }}</h5>
                                                    <span class="yrs">{{ $baby->age }} Yrs</span>
                                                </div>
                                            </div>
                                            <div class="special-instruction">
                                                <h3>Special Instruction</h3>
                                                <p>{{ $baby->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-sm-12">
                                    No Children found.
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Childred List End -->

                    <!-- Childred List Edit Start -->
                    {{ Form::open(['route' => 'frontend.user.parent.babies.update', 'id' => 'edit-baby-form', 'files' => true, 'enctype'=>'multipart/form-data']) }}
                    <div class="edit-children">
                        <ul>
                            @if(isset($user->babies) && count($user->babies) > 0)
                                @foreach($user->babies as $baby)

                               
                                    <li class="edit-list">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <a href="{{ route('frontend.user.parent.babies.delete', ['id' => $baby->id]) }}" class="remove-children">Remove</a>
                                                <div class="upload-image baby">
                                                    <label for="name" class="inputFilelabel"></label>
                                                    <input type='file' name="data[{{$baby->id}}][image]" class="inputFile" id="baby_1" value="{{$baby->image}}" />
                                                    <img class="image_upload_preview" src="{{ url('/uploads/babies/'. $baby->image) }}" alt="" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    {{ Form::text("data[$baby->id][title]", $baby->title, ['class' => 'form-control', 'placeholder' => 'Enter your name', 'required' => 'required']) }}
                                                </div>
                                                <div class="form-group dropdown">
                                                    <label data-id="{{ $baby->birthdate}}" for="name">Birthday</label>
                                                    {{ Form::text("data[$baby->id][birthdate]",  $baby->birthdate, ['class' => 'form-control datePicker', 'placeholder' => 'Birthdate', 'required' => 'required']) }}
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="special-instruction">Add Special Instruction</label>
                                                    {{ Form::textarea("data[$baby->id][description]", $baby->description, ['class' => 'form-control', 'placeholder' => 'Add Special Instruction', 'required' => 'required']) }}
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                                <div class="text-center">
                                    <input type="submit" class="btn btn-default btn-add" name="submit" value="Save" id="edit-baby-submit-btn" style="display: none;">
                                </div>
                            @endif
                        </ul>
                    </div>
                    {{ Form::close() }}
                    <!-- Childred List Edit End -->

                    <!-- Childred List Add Start -->
                    {{ Form::open(['route' => 'frontend.user.parent.babies.add', 'id' => 'add-baby-form', 'files' => true, 'enctype'=>'multipart/form-data']) }}
                    <div class="add-children">
                        <ul>
                            <li class="add-new">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="upload-image baby">
                                            <label for="name" class="inputFilelabel"></label>
                                            <input type='file' name="image" class="inputFile" id="baby_1" value="" />
                                            <img class="image_upload_preview" src="{{url('/default.png')}}" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            {{ Form::text("title", null, ['class' => 'form-control', 'placeholder' => 'Enter your name', 'required' => 'required']) }}
                                        </div>
                                        <div class="form-group dropdown">
                                            <label for="name">Birthday</label>
                                            {{ Form::text("birthdate", null, ['class' => 'form-control pastdate', 'placeholder' => 'Birthdate', 'required' => 'required']) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label for="special-instruction">Add Special Instruction</label>
                                            {{ Form::textarea("description", null, ['class' => 'form-control', 'placeholder' => 'Add Special Instruction', 'required' => 'required']) }}
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <div class="text-center">
                                <input type="submit" class="btn btn-default btn-add" name="submit" value="Save" id="add-baby-submit-btn" style="display: none;">
                            </div>
                        </ul>
                    </div>
                    {{ Form::close() }}
                    <!-- Childred List Add End -->

                </div>
            </div>
            <!-- My Children view/Add/Edit End -->
        </div>
        <!-- Inner Main Column Start -->

    </div><!-- .row end -->
</div><!-- .my-profile end -->

<!-- My Profile Content start -->
@endsection
@section('after-scripts')
<script>
    $(document).ready(function(){
    var ModuleConfig = {
        UpdateProfileURL : "{{ route('frontend.user.parent.update') }}"
    };
    Nanny.Account();
    });
</script>
@stop