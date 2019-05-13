@extends('sitter.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.sitter.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Notifications</li>
    </ol>
</div>
<!-- Breadcrumb End -->

<!-- Notification Content Start -->
<div class="notification 2olumn-right">
    <div class="row">
        <!-- Inner Main Column Start -->
        <div class="col-sm-8 main-column">

            <!-- Notification List Start -->
            <div class="white-box">
                <div class="white-box-title">
                    <h3>Notification</h3>
                </div>
                <div class="white-box-content">

                    <table class="table table-borderless">
                        <tbody>
                            @if($notifications->count() > 0)
                                @foreach($notifications as $notification)
                                    <tr>
                                        <td>
                                            <div class="notification-list">
                                                <div class="notification-icon">
                                                    <span><img src="{!! asset('frontend/images/bell.png') !!}" alt=""></span>
                                                </div>
                                                <div class="notification-content">
                                                    <h3>{{ $notification['user']->name }} <span>{{ $notification->description }}</span></h3>
                                                    <span class="time">{{ Carbon\Carbon::parse($notification->created_at)->format('h:i A') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            @if(!empty($notification['booking']) && $notification['booking']->booking_status == 'REQUESTED')
                                                <a href="{{ route('frontend.user.sitter.booking.reject', ['booking_id' => $notification['booking']->id]) }}" class="btn btn-reject btn-sm">Reject</a>
                                                <a href="{{ route('frontend.user.sitter.booking.accept', ['booking_id' => $notification['booking']->id]) }}" class="btn btn-accept btn-sm">Accept</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if($notifications->count() > 10)
                                    <tr>
                                        <td colspan="2" class="pull-right">
                                            {!! $notifications->links() !!}
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td>
                                        No Notifications Found !
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Notification List End -->
        </div>
        <!-- Inner Main Column End -->

        <!-- Inner Right Column Start -->
        <div class="col-sm-4 col-lg-4 right-column">
            <div class="white-box">
                <div class="white-box-title">
                    <h3>Total Earnings</h3>
                </div>
                <div class="white-box-content">
                    <span class="total-earn">${{ totalEarning(access()->user()->id) }}</span>
                </div>
            </div>
        </div>
        <!-- Inner Right Column End -->
    </div>
</div><!-- .notification end -->
<!-- Notification Content Start -->
@endsection