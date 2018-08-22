@extends('sitter.layouts.app')

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
                    <table class="table table-bordered calendar-table">
                        <thead>
                            <tr>
                                <th colspan="7" class="month-text">May 2018</th>
                            </tr>
                            <tr>
                                <th><span class="desktop-view">Sunday</span> <span class="mobile-view">Sun</span></th>
                                <th><span class="desktop-view">Monday</span> <span class="mobile-view">Mon</span></th>
                                <th><span class="desktop-view">Tuesday</span> <span class="mobile-view">Tue</span></th>
                                <th><span class="desktop-view">Wednesday</span> <span class="mobile-view">Wed</span></th>
                                <th><span class="desktop-view">Thursday</span> <span class="mobile-view">Thu</span></th>
                                <th><span class="desktop-view">Friday</span> <span class="mobile-view">Fri</span></th>
                                <th><span class="desktop-view">Saturday</span> <span class="mobile-view">Sat</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td valign="top" align="top" class="past-month">29</td>
                                <td valign="top" align="top" class="past-month">30</td>
                                <td valign="top" align="top"><span class="date">1</span></td>
                                <td valign="top" align="top"><span class="date">2</span></td>
                                <td valign="top" align="top"><span class="date">3</span></td>
                                <td valign="top" align="top"><span class="date">4</span></td>
                                <td valign="top" align="top"><span class="date">5</span></td>
                            </tr>
                            <tr>
                                <td valign="top" align="top"><span class="date">6</span></td>
                                <td valign="top" align="top"><span class="date">7</span></td>
                                <td valign="top" align="top" class="current-date"><span class="date">8</span></td>
                                <td valign="top" align="top"><span class="date">9</span></td>
                                <td valign="top" align="top"><span class="date">10</span></td>
                                <td valign="top" align="top"><span class="date">11</span></td>
                                <td valign="top" align="top"><span class="date">12</span></td>
                            </tr>
                            <tr>
                                <td valign="top" align="top"><span class="date">13</span></td>
                                <td valign="top" align="top" class="events"><span class="date">14</span>
                                <span class="events-list">
                                    <a class="green" href="#">Item 1</a>
                                    <a class="blue" href="#">Item 2</a>
                                    <a class="yellow" href="#">Item 3</a>
                                </span>
                                </td>
                                <td valign="top" align="top"><span class="date">15</span></td>
                                <td valign="top" align="top"><span class="date">16</span></td>
                                <td valign="top" align="top"><span class="date">17</span></td>
                                <td valign="top" align="top"><span class="date">18</span></td>
                                <td valign="top" align="top"  class="events"><span class="date">19</span>
                                <span class="events-list">
                                    <a class="green" href="#">Item 1</a>
                                    <a class="blue" href="#">Item 2</a>
                                    <a class="yellow" href="#">Item 3</a>
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" align="top"><span class="date">20</span></td>
                                <td valign="top" align="top"><span class="date">21</span></td>
                                <td valign="top" align="top"><span class="date">22</span></td>
                                <td valign="top" align="top"><span class="date">23</span></td>
                                <td valign="top" align="top"><span class="date">24</span></td>
                                <td valign="top" align="top"><span class="date">25</span></td>
                                <td valign="top" align="top"><span class="date">26</span></td>
                            </tr>
                            <tr>
                                <td valign="top" align="top"><span class="date">27</span></td>
                                <td valign="top" align="top"><span class="date">28</span></td>
                                <td valign="top" align="top"><span class="date">29</span></td>
                                <td valign="top" align="top"><span class="date">30</span></td>
                                <td valign="top" align="top"><span class="date">31</span></td>
                                <td valign="top" align="top" class="next-month"><span class="date">1</span></td>
                                <td valign="top" align="top" class="next-month"><span class="date">2</span></td>
                            </tr>
                        </tbody>
                    </table>
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
                                                    {{ Carbon\Carbon::parse($currentJob->booking_date)->format('d F Y') }}
                                                </a>
                                            </span>
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
                                            @if(empty($currentJob->booking_start_time))
                                                <a href="{{ route('frontend.user.sitter.job.cancel', ['job_id' => $currentJob->id]) }}" class="btn btn-cancel btn-sm">Cancel
                                                </a>
                                                <a href="{{ route('frontend.user.sitter.job.start', ['job_id' => $currentJob->id]) }}" class="btn btn-start btn-sm active">Start</a>
                                            @else
                                                <span class="time-info">{{ Carbon\Carbon::parse($currentJob->booking_start_time)->format('h:i A') }}</span>
                                                @if(empty($currentJob->booking_end_time))
                                                    <a href="{{ route('frontend.user.sitter.job.stop', ['job_id' => $currentJob->id]) }}" class="btn btn-stop btn-sm">Stop</a>
                                                @else
                                                    <span class="time-info">{{ Carbon\Carbon::parse($currentJob->booking_end_time)->format('h:i A') }}</span>
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
                                                {{ Carbon\Carbon::parse($pastJob->booking_date)->format('d F Y') }}
                                            </span>
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
                        {{-- <li>
                            <div class="user small">
                                <div class="img-wrap">
                                    <img src="../assets/images/sitter1.png" alt="">
                                </div>
                                <div class="content-wrap">
                                    <div class="content-inner">
                                        <h5>Elsie Burton</h5>
                                        <address>4196 Pfeffer Landing</address>
                                    </div>
                                    <div class="total-amt">
                                        $400.00
                                    </div>
                                </div>
                            </div>
                            <div class="date-time">
                                <span class="date">08 Dec 2017</span>
                                <span class="time"><span class="start-time">9:30 AM</span><span>10:30 AM</span></span>
                            </div>
                        </li> --}}
                        <li>
                            No Recent Activity
                        </li>
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
<script>
    $(document).ready(function(){
        Nanny.Myjobs();
    });
</script>
@stop