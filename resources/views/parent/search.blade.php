@extends('parent.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.parent.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Notification</li>
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
                            @foreach($notifications as $notification)
                                <tr>
                                    <td>
                                        <div class="notification-list">
                                            <div class="notification-icon">
                                                <span><img src="{!! asset('frontend/images/bell.png') !!}" alt=""></span>
                                            </div>
                                            <div class="notification-content">
                                                <h3>{{ $notification['sitter']->name }} <span>{{ $notification->description }}</span></h3>
                                                <span class="time">{{ Carbon\Carbon::parse($notification->created_at)->format('h:i A') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        @if($notification->is_read == 0)
                                            <a href="#" class="btn btn-new btn-sm">New</a>
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
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Notification List End -->
        </div>
        <!-- Inner Main Column End -->

        <!-- Inner Right Column Start -->
        <div class="col-sm-4 right-column">
            <!-- Contact and Chat section start -->
            <div class="white-box">
                <div class="white-box-content">
                    <ul class="contact-detail">
                        <li class="contact">
                            <h3>Contact Us</h3>
                            <span>779-450-7040</span>
                            <a href="#" class="contact-btn">Contact</a>
                        </li>
                        <li class="chat">
                            <h3>Genral Discussion</h3>
                            <span>Chat with us</span>
                            <a href="#" class="chat-btn">Chat</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Contact and Chat section End -->
        </div>
        <!-- Inner Right Column End -->
    </div>
</div><!-- .notification end -->
<!-- Notification Content Start -->
@endsection