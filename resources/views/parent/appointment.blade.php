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
            <div class="white-box">
                <div class="white-box-title">
                    <h3>My Appointments</h3>
                    <div class="btn-group">
                        <a href="javascript:void(0);" id="upcoming_appointment_btn" class="btn btn-secondary active">Upcoming</a>
                        <a href="javascript:void(0);" id="previous_appointment_btn" class="btn btn-secondary">Previous</a>
                    </div>
                </div>
                <div class="white-box-content" id="upcoming_appointment">
                    <!-- Upcoming Appointment list Start -->
                    <table class="table table-borderless">
                        <tbody>
                            @if(count($upcoming) > 0)
                                @foreach($upcoming as $up)
                                <tr>
                                    <td>
                                        <span class="date">
                                            <a href="javascript:void(0);" class="show_baby" style="color: #719D78;">
                                                    {{ Carbon\Carbon::createFromFormat('Y-d-m', $up->booking_date)->format('d F Y') }}
                                            </a>
                                        </span>
                                    </td>
                                    <td><span class="time"><span class="start-time">{{ Carbon\Carbon::parse($up->start_time)->format('h:i A') }}</span><span>{{ Carbon\Carbon::parse($up->end_time)->format('h:i A') }}</span></span></td>
                                    <td>
                                        <div class="user small">
                                            <div class="img-wrap">
                                                <img src="{{ url('/uploads/user/'. $up['sitter']->profile_pic) }}" alt="Profile Pic">
                                            </div>
                                            <div class="content-wrap">
                                                <span class="rating-wrap small"><span class="rating" style="width: {{(AvgRating(null, $up['sitter']->id) * 20)}}%;"></span></span>
                                                <h5>{{ $up['sitter']->name }}</h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        @if($up->booking_status == 'REQUESTED')
                                        <a href="javascript:void(0);" class="btn btn-pending btn-sm">Pending</a>
                                        @elseif($up->booking_status !== 'REJECTED' && $up->booking_status !== 'CANCELED' && $up->booking_status !== 'COMPLETED' && is_null($up->booking_start_time))
                                            <a href="{{ route('frontend.user.parent.appointment.delete', ['id' => $up->id]) }}" class="btn btn-cancel btn-sm">cancel</a>
                                        @else
                                            @if(!is_null($up->booking_start_time) && is_null($up->booking_end_time))
                                                <a href="javascript:void(0);" class="btn btn-pending btn-sm">Job Started</a>
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-pending btn-sm">{{ ucfirst($up->booking_status) }}</a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @if(!empty($up['baby']))
                                        <tr class="baby-detail" style="display: none;">
                                            <td colspan="4">
                                                <div class="baby">
                                                    <div class="baby-info">
                                                        <div class="img-wrap">
                                                            <img src="{{ url('/uploads/babies/'. $up['baby']->image) }}" alt="">
                                                        </div>
                                                        <div class="content-wrap">
                                                            <h5>{{ $up['baby']->title }}</h5>
                                                            <span class="yrs">{{ $up['baby']->age }} Yrs</span>
                                                        </div>
                                                    </div>
                                                    <div class="special-instruction">
                                                        <h3>Special Instruction</h3>
                                                        <p>{{ $up['baby']->description }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                            <tr>
                                <td colspan="4">
                                    No Upcoming Appointment Found
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <!-- Upcoming Appointment list End -->
                </div>
                <div class="white-box-content" id="previous_appointment" style="display: none;">
                    <!-- My Appointment previous list Start -->
                    <table class="table table-borderless">
                        <tbody>
                            @if(count($previous) > 0)
                                @foreach($previous as $pre)
                                    <tr>
                                        <td>
                                            @if($pre->booking_status == 'CANCELED')
                                                <span class="date">
                                                    {{ Carbon\Carbon::createFromFormat('Y-d-m', $pre->booking_date)->format('d F Y') }}
                                                </span>
                                            @else
                                                @if(!empty($pre['payment']))
                                                    <span class="date">
                                                        <a href="{{ route('frontend.user.parent.previousbooking', ['booking_id' => $pre->id]) }}">
                                                                {{ Carbon\Carbon::createFromFormat('Y-d-m', $pre->booking_date)->format('d F Y') }}
                                                        </a>
                                                    </span>
                                                @else
                                                    <span class="date">
                                                        <a href="{{ route('frontend.user.parent.bookingdetails', ['booking_id' => $pre->id]) }}">
                                                                {{ Carbon\Carbon::createFromFormat('Y-d-m', $pre->booking_date)->format('d F Y') }}
                                                        </a>
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                        <td><span class="time"><span class="start-time">{{ Carbon\Carbon::parse($pre->start_time)->format('h:i A') }}</span><span>{{ Carbon\Carbon::parse($pre->end_time)->format('h:i A') }}</span></span>
                                        </td>
                                        <td>
                                            <div class="user small">
                                                <div class="img-wrap">
                                                    <img src="{{ url('/uploads/user/'. $pre['sitter']->profile_pic) }}" alt="Profile Pic">
                                                </div>
                                                <div class="content-wrap">
                                                    <span class="rating-wrap small"><span class="rating" style="width: {{(AvgRating(null, $pre['sitter']->id) * 20)}}%;"></span></span>
                                                    <h5>{{ $pre['sitter']->name }}</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            @if($pre->booking_status == 'CANCELED')
                                                <a href="javascript:void(0);" class="btn btn-pending btn-sm">Canceled</a>
                                            @endif
                                            <span class="price">${{ isset($pre['payment']->total) ?: 0 }}</span></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">
                                        No previous Appointment Found
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <!-- My Appointment previous list End -->
                </div>
            </div>
        </div>
        <!-- Inner Main Column End -->

        <!-- Inner Right Column Start -->
        <div class="col-sm-12 col-lg-4 right-column">
            <div class="white-box">
                <div class="white-box-title">
                    <h3>Review</h3>
                </div>
                <div class="white-box-content">
                    <!-- Review List Start -->
                    <ul class="review-list">
                        <li>
                            No Reviews
                        </li>
                        {{-- <li>
                            <div class="user small">
                                <div class="img-wrap">
                                    <img src="../assets/images/sitter2.png" alt="">
                                </div>
                                <div class="content-wrap">
                                    <h5>Elsie Burton</h5>
                                    <span class="rating-wrap small"><span class="rating"></span></span>
                                </div>
                            </div>
                            <p>The state of Utah in the United States is home to lots of beautiful National Parks, & Bryce Canyon National Park ranks as three of the most magnificent & awe inspiring.</p>
                        </li>
                        <li>
                            <div class="user small">
                                <div class="img-wrap">
                                    <img src="../assets/images/sitter2.png" alt="">
                                </div>
                                <div class="content-wrap">
                                    <h5>Jeffery Massey</h5>
                                    <span class="rating-wrap small"><span class="rating"></span></span>
                                </div>
                            </div>
                            <p>LASIK, or “laser-assisted in situ keratomileusis,” is the most common refractive surgery procedure.</p>
                        </li> --}}
                    </ul>
                    <!-- Review List End -->
                </div>
            </div>
        </div>
        <!-- Inner Right Column End -->
    </div>
</div><!-- .my-appointment end -->
<!-- My Appointment Content End -->
@endsection
@section('after-scripts')
<script>
    var ModuleConfig = {
        UpdateProfileURL : "{{ route('frontend.user.parent.update') }}"
    };
    $(document).ready(function(){
        Nanny.Appointment();
    });
</script>
@stop