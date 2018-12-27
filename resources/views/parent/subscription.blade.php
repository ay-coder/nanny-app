@extends('parent.layouts.app')

@section('content')
<!-- Main Content Start -->
<section class="subscription main-content">
    <div class="container">
        @if(!empty($activationInfo))
            <div class="alert alert-success text-left alert-fadeout mt-25">
                You are already subscribed with {{ $activationInfo['plan']->sub_title }} Plan.
            </div>
        @endif
        <div class="row">
            @foreach($plans as $plan)
                @php
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
                                data-name="Nanny"
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


<!-- Deneral Discussion Popup Start -->
<div class="modal fade" id="generalDiscussion" tabindex="-1" role="dialog" aria-labelledby="generaldiscussionTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data" action="{{ route('frontend.user.parent.send-message') }}" method="post">
                {!! Form::token() !!}
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="generaldiscussionTitle">General Discussion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    @if(isset($messages) && count($messages))
                        @foreach($messages as $message)
                            @if($message->from_user_id == 1)
                                <div class="chat-message">
                                    <span class="msg">
                                        {!! $message->message !!}                            
                                    </span><span class="time">
                                    {!! date('m-d-Y H:i a', strtotime($message->created_at)) !!}
                                    </span></div>

                                @if($message->is_image)
                                    <div class="chat-message">
                                    <span class="msg image">
                                        <img src="{!! URL::to('/').'/uploads/messages/'.$message->image !!}" alt="">
                                    </span>
                                    <span class="time">
                                        {!! date('m-d-Y H:i a', strtotime($message->created_at)) !!}
                                    </span></div>
                                @endif
                            @else
                                <div class="chat-message your-msg">
                                    <span class="msg">
                                        {!! $message->message !!} 
                                    </span>
                                    <span class="time">
                                        {!! date('m-d-Y H:i a', strtotime($message->created_at)) !!}
                                    </span></div> 

                                    @if($message->is_image)
                                        <div class="chat-message your-msg">
                                        <span class="msg image">
                                            <img src="{!! URL::to('/').'/uploads/messages/'.$message->image !!}" alt="">
                                        </span>
                                        <span class="time">
                                            {!! date('m-d-Y H:i a', strtotime($message->created_at)) !!}
                                        </span></div>
                                    @endif
                            @endif

                        @endforeach
                    @endif
                </div>
                <div class="modal-footer text-center">
                    <div class="send-msg">
                        {{-- <button class="attached-btn" type="button">Attached file</button> --}}
                        <input type="file" name="attachment" class="attached-btn" >

                        <input type="text" name="message-text" id="messageTextInput" placeholder="Enter message..." class="form-control">
                        <input type="submit" class="send-btn" id="messageSendBtn">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Deneral Discussion Popup End -->

<!-- Main Content End -->
@endsection