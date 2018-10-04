@extends('parent.layouts.app')

@section('content')
<div class="search-box">
    {{ Form::open(['route' => 'frontend.user.parent.search', 'id' => 'search-form']) }}
        <!-- Select Date, Time start -->
        <div class="form-row">
            <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="date">Start Date</label>
                <input type="text" name="start_booking_date" class="form-control futuredate" required="required" placeholder="dd/mm/yyyy">
            </div>
            <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="date">End Date</label>
                <input type="text" name="end_booking_date" class="form-control futuredate" required="required" placeholder="dd/mm/yyyy">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="start-time">Start Time</label>
                <input type="text" name="start_time" class="form-control startTime" required="required" placeholder="Start Time">
            </div>
            <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="end-time">End Time</label>
                <input type="text" name="end_time" class="form-control endTime" required="required" placeholder="End Time">
            </div>
        </div>
        <!-- Select Date, Time End -->

        <!-- Select Location start -->
        <div class="form-group select-location">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="choosetype-local" value="local" name="choosetype" required="required" checked="checked" class="custom-control-input">
                <label class="custom-control-label" for="choosetype-local">Local</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="choosetype-tourist" value="tourist" name="choosetype" required="required" class="custom-control-input">
                <label class="custom-control-label" for="choosetype-tourist">Tourist</label>
            </div>
        </div>
        <!-- Select Location End -->

        <!-- Select Baby List start -->
        <div class="form-group baby-list">
            <div class="row">
                <div class="col-sm-12">
                    <h3>Select Baby</h3>
                </div>
                @foreach($user['babies'] as $baby)
                    <div class="col-sm-4">
                        <div class=" custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="baby_ids[]" value="{{$baby->id}}" id="baby{{$baby->id}}">
                            <label class="custom-control-label" for="baby{{$baby->id}}"><img src="{{ url('/uploads/babies/'. $baby->image) }}" alt="">{{ $baby->title }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Select Baby List End -->

        @if(count($user['babies']) > 0)
            <div class="form-group text-center">
                <button type="submit" class="btn btn-default">Find Sitter</button>
            </div>
        @else
            <div class="form-group text-center">

                You don't have any baby. Please<a href="{{ route('frontend.user.parent.account') }}"> click here</a> to add babies.
            </div>
        @endif
    {{ Form::close() }}
</div>
<!-- Search form End -->
@endsection