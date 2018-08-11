@extends('parent.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.parent.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Search</li>
    </ol>
</div>
<!-- Breadcrumb End -->

<!-- Search Result Content Start -->
<div class="search-result">
    <!-- Searched items start -->
    <ul class="row">
        @foreach($sitters as $sitter)
            <li class="col-md-4">
                <div class="user vertical white-box">
                    <div class="img-wrap">
                        <img src="{{ url('/uploads/user/'. $sitter['user']->profile_pic) }}" alt="Profile Pic">
                    </div>
                    <div class="content-wrap">
                        <h5>{{ $sitter['user']->name }}</h3>
                        <div class="rating-review">
                            <span class="rating-wrap"><span class="rating" style="width: 100%;"></span></span>
                            <span class="total-review">({{ $sitter['reviews']->count() }} Reviews)</span>
                        </div>
                        <a href="{{ route('frontend.user.parent.findsitter', ['id' => $sitter['user']->id]) }}" class="btn btn-default">Book Nanny</a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <!-- Searched items End -->

    <!-- Searched pagination start -->
    <div class="search-pagination">
        {{ $sitters->links() }}
        {{-- <a href="#" class="btn btn-outline prev-btn">Previous</a>
        <a href="#" class="btn btn-default next-btn">Next</a> --}}
    </div>
    <!-- Searched pagination start -->
</div>
<!-- Search Result Content End -->
<!-- Notification Content Start -->
@endsection