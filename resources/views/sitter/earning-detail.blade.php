@extends('sitter.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.sitter.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.sitter.earning') }}">My Earning</a></li>
        <li class="breadcrumb-item active" aria-current="page">Earning Detail</li>
    </ol>
</div>
<!-- Breadcrumb End -->

<!-- My Earning Content Start -->
<div class="my-earning my-job_and_appt my-jobs 2olumn-right">
    <div class="row">
        <!-- Inner Main Column Start -->
        <div class="col-sm-12 col-lg-8 main-column">
            <div class="white-box py-0">
                <div class="white-box-content">
                    <!-- Upcoming Appointment list Start -->
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><span class="date"> {{ Carbon\Carbon::createFromFormat('Y-m-d', $booking->booking_date)->format('d F Y') }}</span></td>
                                <td><span class="time"><span class="start-time">{{ Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}</span><span>{{ Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</span></span></td>
                                <td>
                                    <div class="user small">
                                        <div class="img-wrap">
                                            <img src="{{ url('/uploads/user/'. $booking['user']->profile_pic) }}" alt="Profile Pic">
                                        </div>
                                        <div class="content-wrap">
                                            <div class="content-inner">
                                                <h5>{{ $booking['user']->name }}</h5>
                                                <address>{{ $booking['user']->address }}
                                                    @if(!empty($booking['user']->city)),{{ $booking['user']->city }} @endif
                                                    @if(!empty($booking['user']->state)),{{ $booking['user']->state }} @endif
                                                    @if(!empty($booking['user']->zip)),{{ $booking['user']->zip }} @endif
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <span class="price">${{ isset($booking['payment']) ? $booking['payment']->per_hour * $booking['payment']->total_hour + $booking['payment']->tip  : '0' }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Upcoming Appointment list End -->
                </div>
            </div>
        </div>
        <!-- Inner Main Column End -->
        <div class="col-sm-12 col-lg-4 right-column">
            <div class="white-box">
                <div class="white-box-title">
                    <h3>Earning</h3>
                </div>
                <div class="white-box-content">
                    <table class="table table-borderless earning-table payment-info-table">
                        <tbody>
                            <tr>
                                <td><span>Billing Detail</span>Per Hours</td>
                                <td class="price-info">${{ isset($booking['payment']) ? $booking['payment']->per_hour : 0 }}</td>
                            </tr>
                            <tr>
                                <td><span>Total Hours</span>{{ isset($booking['payment']) ? $booking['payment']->total_hour : 0 }} hrs</td>
                                <td class="price-info">${{ isset($booking['payment']) ? $booking['payment']->total_hour * $booking['payment']->per_hour : 0 }}</td>
                            </tr>
                            
                            <tr class="grand-total">
                                <td><span>Tip</span>Amount</td>
                                <td class="price-info">${{ isset($booking['payment']) ? $booking['payment']->tip : 0 }}</td>
                            </tr>

                            <tr class="grand-total">
                                <td><span>Total</span>Amount</td>
                                <td class="price-info">${{ isset($booking['payment']) ?  $booking['payment']->total + $booking['payment']->tip  : 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- My Earning Content End -->
<!-- Notification Content Start -->
@endsection