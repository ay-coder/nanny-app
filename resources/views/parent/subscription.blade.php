@extends('parent.layouts.app')

@section('content')
<!-- Main Content Start -->
<section class="subscription main-content">
    <div class="container">
        <div class="row">

            @foreach($plans as $plan)
                @php
                    $class = ($plan->plan_type == 'A') ? 'green-box' : (($plan->plan_type == 'B') ? 'blue-box' : 'yellow-box');
                @endphp
                <!-- Subscription plan box start -->
                <div class="col-md-6 col-lg-3">
                    <div class="{{ $class }}">
                        <h3>{{ $plan->title }}</h3>
                        <a href="#" class="subscription-btn">{{ $plan->sub_title }}</a>
                        <span class="price">${{ $plan->amount }}</span>
                        @if($plan->plan_type == 'C')
                            <span class="per-month">per month</span>
                        @endif
                    </div>
                </div>
                <!-- Subscription plan box End -->
            @endforeach

            <!-- Contact box 4 Start -->
            <div class="col-md-6 col-lg-3">
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
                                <a  href="JavaScript:void(0)" data-toggle="modal" data-target="#generalDiscussion" class="chat-btn">Chat</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Contact box 4 End -->

        </div><!-- .row End -->
    </div><!-- .container End -->
</section><!-- .subscription End -->
<!-- Main Content End -->
@endsection