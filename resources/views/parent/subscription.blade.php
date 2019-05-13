@extends('parent.layouts.app')

@section('content')
<!-- Main Content Start -->
<section class="subscription main-content">
    <div class="container">
        @if(!empty($activationInfo))
            <div class="alert alert-success text-left alert-fadeout mt-25">
                You are already subscribed with {{ $activationInfo['plan']->sub_title }} Plan.
                <br>
                Booking Left : {!! access()->getMyAvailabeBooknigs(access()->user()->id) !!}
            </div>
        @endif
        <div class="row">
            @foreach($plans as $plan)
                @php
                    $planStripeTitle = $plan->subscription_count > 1 ? 'Subscriptions' : 'Subscription';
                    $class = ($plan->plan_type == 'A') ? 'green-box' : (($plan->plan_type == 'B') ? 'blue-box' : 'yellow-box');
                @endphp
                <!-- Subscription plan box start -->
                <div class="col-md-6 col-lg-3">
                {{ Form::open(['route' => 'frontend.user.parent.plansubscription']) }}
                {{ Form::hidden('plan_id', $plan->id) }}
                    <div class="{{ $class }}">
                        <h3>{{ $plan->title }}</h3>
                        <a href="javascript:void(0);" class="subscription-btn">{{ $plan->sub_title }}</a>
                        <span class="price">${{ $plan->amount }}</span>
                        @if($plan->plan_type == 'C')
                            <span class="per-month">per month</span>
                        @endif
                        @if(empty($activationInfo))
                            {{ Form::hidden('stripeToken')}}
                            <script
                                src="https://checkout.stripe.com/checkout.js"
                                class="stripe-button subscription-button"
                                data-key="pk_test_Ky5y4G4B1yGfbfF2wr7CSqqm"
                                data-image={{url('/default.png')}}
                                data-name="{{ $planStripeTitle }}"
                                data-email="{{access()->user()->email}}"
                                data-description={{$plan->sub_title}}
                                data-locale="auto"
                                amount={{ $plan->amount }}
                                data-amount=false>
                            </script>
                        @endif
                    </div>
                {{ Form::close() }}
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
                                <h3></h3>
                                <span>Help</span>
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

@include('parent.message-popupbox')

@endsection