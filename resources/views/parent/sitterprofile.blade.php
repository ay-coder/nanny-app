@extends('parent.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.parent.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Search</a></li>
        <li class="breadcrumb-item active" aria-current="page">Nanny Profile</li>
    </ol>
</div>
<!-- Breadcrumb End -->

<!-- Nanny Profile Start -->
<div class="nanny-profile 2column-right">
    <div class="row">
        <!-- Inner Main Column Start -->
        <div class="col-sm-12 col-lg-8 main-column">
            <!-- Nanny Detail Start -->
            <div class="white-box">
                <div class="white-box-content">
                    <div class="user large">
                        <div class="img-wrap">
                            <img src="{{ url('/uploads/user/'. $sitter['user']->profile_pic) }}" alt="">
                        </div>
                        <div class="content-wrap">
                            <h5>{{ $sitter['user']->name }}, {{ $sitter['user']->age }} yrs</h5>
                            <div class="rating-review">
                                <span class="rating-wrap"><span class="rating" style="width: {{ AvgRating(null, $sitter['user']->id) * 20 }}%;"></span></span>
                                <span class="total-review">({{ $sitter['reviews']->count() }} Reviews)</span>
                            </div>
                        </div>
                        <div class="user-gender"><span class="gender">{{ $sitter['user']->gender }}</span></div>
                    </div>
                </div>
            </div>
            <!-- Nanny Detail end -->

            <!-- Nanny Personal Information Start -->
            <div class="nanny-personal-info white-box">
                <div class="white-box-title">
                    <h3>Personal Info</h3>
                </div>
                <div class="white-box-content">
                    <h3>About Me</h3>
                    <p>{!! $sitter->about_me !!}</p>
                    <h3>Category</h3>
                    <p>{!! $sitter->category !!}</p>
                    <h3>Description</h3>
                    <p>{!! $sitter->description !!}</p>
                </div>
            </div>
            <!-- Nanny Personal Information End -->

            <!-- Review Start -->
            <div class="white-box">
                <div class="white-box-title">
                    <h3>Reviews</h3>
                    {{-- <a href="JavaScript:void(0)" data-toggle="modal" data-target="#reviewnow" class="btn btn-default">Review now</a> --}}
                </div>
                <div class="white-box-content">
                    <ul class="review-list">
                        @foreach($sitter['reviews'] as $review)
                            <li>
                                <div class="user">
                                    <div class="img-wrap">
                                        <img src="{{ url('/uploads/user/'. $review['user']->profile_pic) }}" alt="Profile Pic">
                                    </div>
                                    <div class="content-wrap">
                                        <h5>{{ $review['user']->name }}</h5>
                                        <span class="rating-wrap"><span class="rating" style="width: {{($review->rating * 20)}}%;"></span></span>
                                    </div>
                                </div>
                                <p>{{ $review->description }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- Review End -->

        </div>
        <!-- Inner Main Column End -->

        <!-- Inner Right Column Start -->
        <div class="col-sm-12 col-lg-4 right-column">
            <div class="white-box book-nanny">
                {{ Form::open(['route' => 'frontend.user.parent.booksitter']) }}
                    {{ Form::hidden('sitter_id', $id) }}
                    <input type="submit" name="submit" class="btn btn-default" value="Book Nanny">
                {{ Form::close() }}
                {{-- <a href="myappointment.html" class="btn btn-default">Book Nanny</a> --}}
            </div>
            <div class="white-box upcoming-appointment">
                <div class="white-box-title">
                    <h3>Upcoming Appointments</h3></div>
                <div class="white-box-content">
                    <ul>
                        @foreach($upcoming as $up)
                            <li>
                                <div class="date-time">
                                    <span class="date">{{ date('d F Y', strtotime($up->booking_date)) }}</span>
                                    <span class="time"><span class="start-time">{{ Carbon\Carbon::parse($up->start_time)->format('h:i A') }}</span><span>{{ Carbon\Carbon::parse($up->end_time)->format('h:i A') }}</span>
                                    </span>
                                </div>
                                <div class="user small-right">
                                    <div class="content-wrap">
                                        <span class="rating-wrap small"><span class="rating" style="width: {{(AvgRating(null, $up['sitter']->id) * 20)}}%;"></span></span>
                                        <h5>{{ $up['sitter']->name }}</h5>
                                    </div>
                                    <div class="img-wrap">
                                        <img src="{{ url('/uploads/user/'. $up['sitter']->profile_pic) }}" alt="">
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- Inner Right Column End -->
    </div>
</div>
<!-- Nanny Profile End -->
<!-- Notification Content Start -->
@endsection