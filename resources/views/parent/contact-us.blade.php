@extends('parent.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
    </ol>
</div>
<!-- Breadcrumb End -->
<div class="row">
	<!-- Contact box 4 Start -->
	<div class="col-md-12 col-lg-12">
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
</div>

@include('parent.message-popupbox')

@endsection