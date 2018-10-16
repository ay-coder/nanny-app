@extends('parent.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.parent.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.parent.myappointment') }}">My Appointment</a></li>
        <li class="breadcrumb-item active" aria-current="page">Previous</li>
    </ol>
</div>
<!-- Breadcrumb End -->

<!-- My Appointment Content start -->
<div class="my-job_and_appt 2olumn-right">
    <div class="row">

        <!-- Inner Main Column Start -->
        <div class="col-sm-12 col-lg-8 main-column">
            <div class="white-box job_and_appt-detail">
                <div class="white-box-content">
                    <table class="table table-borderless">
                        <tbody>
                            <!-- Nanny Detail Start -->
                            <tr>
                                <td><span class="date">{{ Carbon\Carbon::createFromFormat('Y-m-d', $booking->booking_date)->format('d F Y') }}</span></td>
                                <td><span class="time"><span class="start-time">{{ Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}</span><span>{{ Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</span></span>
                                </td>
                                <td>
                                    <div class="user small">
                                        <div class="img-wrap">
                                            <img src="{{ url('/uploads/user/'. $booking['sitter']->profile_pic) }}" alt="Profile Pic">
                                        </div>
                                        <div class="content-wrap">
                                            <span class="rating-wrap small"><span class="rating" style="width: {{(AvgRating(null, $booking['sitter']->id) * 20)}}%;"></span></span>
                                            <h5>{{ $booking['sitter']->name }}</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right"></td>
                            </tr>
                            <!-- Nanny Detail End -->

                            <!-- Baby Detail Start -->
                            @foreach($babies as $baby)
                                <tr class="baby-detail">
                                    <td colspan="4">
                                        <div class="baby">
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
                                    </td>
                                </tr>
                            @endforeach
                            <!-- Baby Detail End -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Inner Main Column End -->

        <!-- Inner Right Column Start -->
        <div class="col-sm-12 col-lg-4 right-column">
            <!-- Payment Summary Start -->
            <div class="white-box">
                <div class="white-box-title">
                    <h3>Payment Summary</h3>
                </div>
                <div class="white-box-content">
                    <table class="table table-borderless payment-info-table">
                        <tbody>
                            <tr>
                                <td><span>Billing Detail</span>Per Hours</td>
                                <td class="price-info">${{ isset($booking['payment']->per_hour) ?: 0 }}</td>
                            </tr>
                            <tr>
                                <td><span>Total Hours</span>{{ isset($booking['payment']->total_hour) ?: 0 }} hrs</td>
                                <td class="price-info">${{ isset($booking['payment']->sub_total) ?: 0 }}</td>
                            </tr>
                            <tr class="grand-total">
                                <td><span>Payment</span>Cash</td>
                                <td class="price-info">${{ isset($booking['payment']->total) ?: 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Payment Summary End -->
        </div>
        <!-- Inner Right Column End -->
    </div>
</div><!-- .my-appointment end -->
<!-- My Appointment Content start -->
@endsection