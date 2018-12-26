@extends('sitter.layouts.app')
{!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css') !!}
@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.sitter.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">My Jobs</li>
    </ol>
</div>
<!-- Breadcrumb End -->

<!-- My Jobs Content start -->
<div class="my-job_and_appt my-jobs 2olumn-right">
    <div class="row">
        <div class="col-sm-12 col-lg-8 main-column">

            <div class="white-box">
                <div class="white-box-title">
                    <h3>My Jobs</h3>
                    <div class="btn-group">
                        <a href="javascript:void(0);" id="calender_view_btn" class="btn btn-secondary active">Calendar</a>
                        <a href="javascript:void(0);" id="current_jobs_btn" class="btn btn-secondary">Current</a>
                        <a href="javascript:void(0);" id="previous_jobs_btn" class="btn btn-secondary">Previous</a>
                    </div>
                </div>
                <div class="white-box-content" id="calender_view">
                    <div id="calendar"></div>
                </div>
                <div class="white-box-content" id="current_jobs" style="display: none;">
                    <!-- Upcoming Appointment list Start -->
                    <table class="table table-borderless">
                        <tbody>
                            @if(count($currentJobs) > 0)
                                @foreach($currentJobs as $currentJob)
                                    <tr>
                                        <td>
                                            <span class="date">
                                                <a href="javascript:void(0);" class="show_baby" style="color: #719D78;">

                                                    {{ Carbon\Carbon::createFromFormat('Y-m-d', $currentJob->booking_date)->format('d F Y') }}
                                                </a>
                                            </span>

                                            <br>
                                            
                                            @if(isset($currentJob->is_pet) && $currentJob->is_pet ==1 )
                                                <span><img src="{{ url('/uploads/user/pets.png') }}" alt="Pet" style="width: 25px; height: 25px;" ></span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="time">
                                                <span class="start-time">
                                                    {{ Carbon\Carbon::parse($currentJob->start_time)->format('h:i A') }}
                                                </span>
                                                <span>
                                                    {{ Carbon\Carbon::parse($currentJob->end_time)->format('h:i A') }}
                                                </span>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="user small">
                                                <div class="img-wrap">
                                                    <img src="{{ url('/uploads/user/'. $currentJob['user']->profile_pic) }}" alt="">
                                                </div>
                                                <div class="content-wrap">
                                                    <div class="content-inner">
                                                        <h5>
                                                            {{$currentJob['user']->name}}
                                                        </h5>
                                                        <address>
                                                            {{ $currentJob['user']->address }}
                                                            @if(!empty($currentJob['user']->city)),{{ $currentJob['user']->city }} @endif
                                                            @if(!empty($currentJob['user']->state)),{{ $currentJob['user']->state }} @endif
                                                            @if(!empty($currentJob['user']->zip)),{{ $currentJob['user']->zip }} @endif
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            @if($currentJob->booking_status == 'REQUESTED')
                                                <a href="{{ route('frontend.user.sitter.booking.reject', ['booking_id' => $currentJob->id]) }}" class="btn btn-reject btn-sm">Reject</a>
                                                <a href="{{ route('frontend.user.sitter.booking.accept', ['booking_id' => $currentJob->id]) }}" class="btn btn-accept btn-sm">Accept</a>
                                            @else
                                                @if(empty($currentJob->booking_start_time))
                                                    <a href="{{ route('frontend.user.sitter.job.cancel', ['job_id' => $currentJob->id]) }}" class="btn btn-cancel btn-sm">Cancel
                                                    </a>

                                                    @if($currentJob->booking_date == date('Y-m-d'))
                                                    <a href="{{ route('frontend.user.sitter.job.start', ['job_id' => $currentJob->id]) }}" class="btn btn-start btn-sm active">Start</a>
                                                    @else
                                                        <a href="javascript:void(0);" class="btn btn-start btn-sm disabled">Start</a>
                                                    @endif
                                                @else
                                                    <span class="time-info">{{ Carbon\Carbon::parse($currentJob->booking_start_time)->format('h:i A') }}</span>
                                                    @if(empty($currentJob->booking_end_time))
                                                        <a href="{{ route('frontend.user.sitter.job.stop', ['job_id' => $currentJob->id]) }}" class="btn btn-stop btn-sm">Stop</a>
                                                    @else
                                                        <span class="time-info">
                                                        {{ Carbon\Carbon::parse($currentJob->booking_end_time)->format('h:i A') }}</span>
                                                    @endif

                                                    @if($currentJob->booking_status == "COMPLETED")
                                                        <a href="javascript:void(0);" class="btn btn-start btn-sm disabled">
                                                        Pending Payment
                                                        </a>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @if(!empty($currentJob['baby']))
                                        <tr class="baby-detail" style="display: none;">
                                            <td colspan="4">
                                                <div class="baby">
                                                    <div class="baby-info">
                                                        <div class="img-wrap">
                                                            <img src="{{ url('/uploads/babies/'. $currentJob['baby']->image) }}" alt="">
                                                        </div>
                                                        <div class="content-wrap">
                                                            <h5>{{ $currentJob['baby']->title }}</h5>
                                                            <span class="yrs">{{ $currentJob['baby']->age }} Yrs</span>
                                                        </div>
                                                    </div>
                                                    <div class="special-instruction">
                                                        <h3>Special Instruction</h3>
                                                        <p>{{ $currentJob['baby']->description }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td>
                                        No Jobs Found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <!-- Upcoming Appointment list End -->
                </div>
                <div class="white-box-content" id="previous_jobs" style="display: none;">
                    <!-- Upcoming Appointment list Start -->
                    <table class="table table-borderless">
                        <tbody>
                            @if(count($pastJobs) > 0)
                                @foreach($pastJobs as $pastJob)
                                    <tr>
                                        <td>
                                            <span class="date">
                                                {{ Carbon\Carbon::createFromFormat('Y-m-d', $pastJob->booking_date)->format('d F Y') }}
                                            </span>

                                            <br>
                                            
                                            @if(isset($pastJob->is_pet) && $pre->pastJob ==1 )
                                                <span><img src="{{ url('/uploads/user/pets.png') }}" alt="Pet" style="width: 25px; height: 25px;" ></span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="time">
                                                <span class="start-time">
                                                    {{ Carbon\Carbon::parse($pastJob->booking_start_time)->format('h:i A') }}
                                                </span>
                                                <span>
                                                    {{ Carbon\Carbon::parse($pastJob->booking_end_time)->format('h:i A') }}
                                                </span>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="user small">
                                                <div class="img-wrap">
                                                    <img src="{{ url('/uploads/user/'. $pastJob['user']->profile_pic) }}" alt="">
                                                </div>
                                                <div class="content-wrap">
                                                    <div class="content-inner">
                                                        <h5>
                                                            {{$pastJob['user']->name}}
                                                        </h5>
                                                        <address>
                                                            {{ $pastJob['user']->address }}
                                                            @if(!empty($pastJob['user']->city)),{{ $pastJob['user']->city }} @endif
                                                            @if(!empty($pastJob['user']->state)),{{ $pastJob['user']->state }} @endif
                                                            @if(!empty($pastJob['user']->zip)),{{ $pastJob['user']->zip }} @endif
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right"><a href="javascript:void(0);" class="btn btn-complete btn-sm">{{ $pastJob->booking_status }}</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td>
                                        No Jobs Found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <!-- Upcoming Appointment list End -->
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4 right-column">
            <div class="white-box">
                <div class="white-box-title">
                    <h3>Recent Activity</h3>
                </div>
                <div class="white-box-content">
                    <ul class="recent-activity">
                        @if(count($calenderRecords) > 0)
                            @foreach($calenderRecords as $calenderRecord)
                                <li>
                                    <div class="user small">
                                        <div class="img-wrap">
                                            <img src="{{ url('/uploads/user/'. $calenderRecord['user']->profile_pic) }}" alt="">
                                        </div>
                                        <div class="content-wrap">
                                            <div class="content-inner">
                                                <h5>{{$calenderRecord['user']->name}}</h5>
                                                <address>
                                                    {{ $calenderRecord['user']->address }}
                                                    @if(!empty($calenderRecord['user']->city)),{{ $calenderRecord['user']->city }} @endif
                                                    @if(!empty($calenderRecord['user']->state)),{{ $calenderRecord['user']->state }} @endif
                                                    @if(!empty($calenderRecord['user']->zip)),{{ $calenderRecord['user']->zip }} @endif
                                                </address>
                                            </div>
                                            @if(!empty($calenderRecord['payment']))
                                                <div class="total-amt">
                                                    ${{$calenderRecord['payment']->per_hour * $calenderRecord['payment']->total_hour + $calenderRecord['payment']->tip }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="date-time">
                                        <span class="date">{{ Carbon\Carbon::createFromFormat('Y-m-d', $calenderRecord->booking_date)->format('d F Y') }}</span>
                                        <span class="time"><span class="start-time">{{ Carbon\Carbon::parse($calenderRecord->start_time)->format('h:i A') }}</span><span>{{ Carbon\Carbon::parse($calenderRecord->end_time)->format('h:i A') }}</span></span>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li>
                                No Recent Activity
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- My Jobs Content End -->
<!-- Notification Content Start -->
@endsection
@section('after-scripts')
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js') !!}
{!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js') !!}
<script>
    $(document).ready(function(){
        Nanny.Myjobs();

        $('#calendar').fullCalendar({
            header: {
              left: 'false',
              center: 'prev title next',
              right: ''
            },
            defaultDate: '<?php echo \Carbon\Carbon::now(); ?>',
            allDaySlot: false,
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events : {!! $calenderData !!},
            timeFormat: 'H(:mm)',
            eventColor: '#719d78',

            eventClick: function(calEvent, jsEvent, view) {
                
                if(calEvent.status == 'upcoming')
                {
                    $("#current_jobs_btn").click();
                }
                else
                {
                    $("#previous_jobs_btn").click();
                }
            }
        });

        //console.log({!! $calenderData !!});
    });
</script>
@stop