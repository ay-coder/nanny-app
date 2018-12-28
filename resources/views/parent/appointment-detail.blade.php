@extends('parent.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.parent.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Appointment</li>
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
                                <td>
                                <span class="time"><span class="start-time">{{ Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}</span><span>{{ Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</span></span>
                                
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
                                {{-- <td class="text-right"><a href="{{ route('frontend.user.parent.appointment.delete', ['id' => $booking->id]) }}" class="btn btn-cancel btn-sm">cancel</a></td> --}}
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
            <div class="white-box">
                <div class="white-box-content">
                    @if($booking->booking_status == 'COMPLETED')
                        <div class="text-center">
                            <span class="time">
                                <span class="start-time">{{ Carbon\Carbon::parse($booking->booking_start_time)->format('h:i A') }}</span> to
                                <span>{{ Carbon\Carbon::parse($booking->booking_end_time)->format('h:i A') }}</span>
                            </span>
                        </div>
                    @else
                        <a href="javascript:void(0)" class="yet-to-start">Yet to start</a>
                    @endif
                </div>
            </div>
            <div class="white-box">
                <div class="white-box-content">
                    <div class="get-payment">
                        <!-- Time Display Start -->
                        <div class="time-display">
                            <span class="hours">{{round((strtotime($booking->booking_end_time) - strtotime($booking->booking_start_time))/3600, 1)}} <span>Hours</span></span>
                            {{-- <span class="time-separator">:</span>
                            <span class="minutes">00 <span>minutes</span></span> --}}
                        </div>
                        <!-- Time Display Start -->
                        @php
                            $subTotal = $booking->parking_fees + (access()->getSitterPerHour()) * (round((strtotime($booking->booking_end_time) - strtotime($booking->booking_start_time))/3600, 1));
                        @endphp
                        <!-- Price Display Start -->
                        <div class="price-display">${{ $subTotal }}</div>
                        <!-- Price Display End -->

                        <!-- Payment Detail Start -->
                        <div class="payment-detail">
                            {{ Form::open(['route' => 'frontend.user.parent.bookingpayment']) }}
                                <table class="table table-borderless payment-table">
                                    <tbody>
                                        <tr>
                                            <td class="tip" colspan="2">
                                                <div class="form-group">
                                                    <label for="">Tip Amount</label>
                                                    <input type="number" id="tip_amount" placeholder="Tip Amount" name="tip" class="form-control">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="price-row">
                                            <td>
                                                Total Amount
                                            </td>
                                            {{ Form::hidden('sub_total', $subTotal, ['id' => 'sub_total']) }}
                                            {{ Form::hidden('booking_id', $booking->id, ['id' => 'booking_id']) }}
                                            {{ Form::hidden('payment_id', isset($booking['payment']->id) ? $booking['payment']->id : 0, ['id' => 'payment_id']) }}
                                            {{ Form::hidden('parking_fees', 0, ['id' => 'parking_fees']) }}
                                            <td class="price">
                                                ${{ $subTotal }}
                                            </td>
                                        </tr>
                                        <tr class="price-row">
                                            <td>
                                                Parking Fees
                                            </td>
                                            <td class="price">
                                                ${{ $booking->parking_fees }}
                                            </td>
                                        </tr>
                                        <tr class="price-row">
                                            <td>
                                                Tip Amount
                                            </td>
                                            <td class="price">
                                                +$<span id="show_tip_amount">0</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr class="grand-total">
                                            <td>
                                                Total
                                            </td>
                                            <td class="price">
                                                $<span id="show_total_amount">{{ $subTotal }}</span>
                                                {{ Form::hidden('total_amount' , $subTotal + $booking->parking_fees, ['id' => 'total_amount']) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                {{ Form::hidden('stripeToken')}}
                                                <script
                                                    src="https://checkout.stripe.com/checkout.js"
                                                    class="stripe-button subscription-button"
                                                    data-key="pk_test_Ky5y4G4B1yGfbfF2wr7CSqqm"
                                                    data-image="{{url('/default.png')}}"
                                                    data-name="Nanny"
                                                    data-email="{{access()->user()->email}}"
                                                    data-description="Appointment Booking"
                                                    data-locale="auto"
                                                    amount="$('total_amount').val()"
                                                    data-amount=false>
                                                </script>
                                                {{-- <button type="submit" class="btn btn-default btn-pay-online">Pay Online</button> --}}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            
                            {{ Form::close() }}
                        </div>
                        <!-- Payment Detail End -->

                    </div>
                </div>
            </div>
        </div>
        <!-- Inner Right Column Start -->
    </div>
</div><!-- .my-appointment end -->
<!-- My Appointment Content start -->
@endsection
@section('end-scripts')
<script>
    $('#tip_amount').keyup(function() {
        var $tipValue = $(this).val();
        if(!isNaN($tipValue))
        {
            $tipValue = parseFloat($tipValue);
            $('#show_tip_amount').html($tipValue);

            var $totalValue = $tipValue + parseFloat($('#sub_total').val())  + parseFloat($('#parking_fees').val());


            $('#show_total_amount').html($totalValue);
            $('#total_amount').val($totalValue);
        } else {
            $('#tip_amount').val(0);
        }
    });
</script>
@stop