@extends('sitter.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.sitter.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Earnings</li>
    </ol>
</div>
<!-- Breadcrumb End -->

<!-- My Earning Content Start -->
<div class="my-job_and_appt my-jobs 2olumn-right">
    <div class="row">
        <!-- Inner Main Column Start -->
        <div class="col-sm-12 col-lg-8 main-column">
            <div class="white-box">
                <div class="white-box-title">
                    <h3>History</h3>
                </div>
                <div class="white-box-content">
                    <!-- Upcoming Appointment list Start -->
                    <table class="table table-borderless">
                        <tbody>
                            @if(count($sitterBookings) > 0)
                                @foreach($sitterBookings as $sitterBooking)
                                    <tr>
                                        <td><a href="{{ route('frontend.user.sitter.booking', ['booking_id' => $sitterBooking->id]) }}"><span class="date"> {{ Carbon\Carbon::createFromFormat('Y-m-d', $sitterBooking->booking_date)->format('d F Y') }}</span></a></td>
                                        <td><span class="time"><span class="start-time">{{ Carbon\Carbon::parse($sitterBooking->start_time)->format('h:i A') }}</span><span>{{ Carbon\Carbon::parse($sitterBooking->end_time)->format('h:i A') }}</span></span></td>
                                        <td>
                                            <div class="user small">
                                                <div class="img-wrap">
                                                    <img src="{{ url('/uploads/user/'. $sitterBooking['user']->profile_pic) }}" alt="Profile Pic">
                                                </div>
                                                <div class="content-wrap">
                                                    <div class="content-inner">
                                                        <h5>{{ $sitterBooking['user']->name }}</h5>
                                                        <address>{{ $sitterBooking['user']->address }}
                                                            @if(!empty($sitterBooking['user']->city)),{{ $sitterBooking['user']->city }} @endif
                                                            @if(!empty($sitterBooking['user']->state)),{{ $sitterBooking['user']->state }} @endif
                                                            @if(!empty($sitterBooking['user']->zip)),{{ $sitterBooking['user']->zip }} @endif
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <span class="price">${{ isset($sitterBooking['payment']) ? $sitterBooking['payment']->per_hour * $sitterBooking['payment']->total_hour + $sitterBooking['payment']->tip : '0' }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                No History Found
                            </tr>
                            @endif
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
                    <h3>Total Earnings</h3>
                </div>
                <div class="white-box-content">
                    <span class="total-earn">${{ totalEarning(access()->user()->id) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- My Earning Content End -->
<!-- Notification Content Start -->
@endsection