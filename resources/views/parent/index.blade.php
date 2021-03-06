@extends('parent.layouts.app')

@section('content')
<div class="search-box">
    {{ Form::open(['route' => 'frontend.user.parent.search', 'id' => 'search-form']) }}
        <!-- Select Date, Time start -->
        <div class="form-row">
            <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="date">Start Date</label>
                <input type="text" value="<?php echo date('m/d/Y');?>" name="booking_date" class="form-control futuredate" required="required">
            </div>
            {{-- <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="date">End Date</label>
                <input type="text" name="end_booking_date" class="form-control futuredate" required="required" placeholder="dd/mm/yyyy">
            </div> --}}
        </div>
        <div class="form-row">
            <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="start-time">Start Time</label>
                <input type="text" value="<?php echo date("H:m");?>" name="start_time" class="form-control startTimeB" required="required" placeholder="Start Time">
            </div>
            <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="end-time">End Time</label>
                <input type="text" value="<?php echo date("H:m", strtotime('+3 hours'));?>" name="end_time" class="form-control endTimeB" required="required" placeholder="End Time">
            </div>
        </div>
        <!-- Select Date, Time End -->

        <!-- Select Location start -->
        <div class="form-group select-location">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="choosetype-local" value="0" name="booking_type" required="required" checked="checked" class="custom-control-input">
                <label class="custom-control-label" for="choosetype-local">Local</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="choosetype-tourist" value="1" name="booking_type" required="required" class="custom-control-input">
                <label class="custom-control-label" for="choosetype-tourist">Tourist</label>
            </div>
        </div>

        <!-- Select Location start -->
        <div class="form-group select-location">
        <hr>
            <label class="control-label" for="date">Pets</label>
            <br>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="is_pet_yes" value="1" name="is_pet" required="required" checked="checked" class="custom-control-input">
                <label class="custom-control-label" for="is_pet_yes">Yes</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="is_pet_no" value="0" name="is_pet" required="required" class="custom-control-input">
                <label class="custom-control-label" for="is_pet_no">No</label>
            </div>
        </div>
        <!-- Select Location End -->

        <div class="form-row">
            <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="date">Parking Fees</label>
                <input type="number" value="0" step="0.1" name="parking_fees" class="form-control" required="required" placeholder="Parking Fees">
            </div>
            {{-- <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="date">End Date</label>
                <input type="text" name="end_booking_date" class="form-control futuredate" required="required" placeholder="dd/mm/yyyy">
            </div> --}}
        </div>

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

@section('after-scripts')
<script type="text/javascript">
    
            $('.startTimeB').datetimepicker({
                format: 'HH:mm'
            });

            $(".startTimeB").on("dp.change",function (e) 
            {
                validateBookingTime();
            });
            $('.endTimeB').datetimepicker({
                format: 'HH:mm'
            }).on("dp.change",function (e) 
            {
                validateBookingTime();
                console.log('Change Ebnd Time');
            });

            $('.futuredate').datetimepicker({
                viewMode: 'days',
                format: 'MM/DD/YYYY',
                minDate: new Date(),
                defaultDate:new Date()
            });

            $('.futuredate').val(moment().format('MM/DD/YYYY));

            function validateBookingTime()
            {
                var startTime   = moment($('.endTimeB').val(), 'HH:mm:ss');
                    diff        = startTime.diff(moment($('.startTimeB').val(), 'HH:mm:ss'));

                if(diff >= 10800000)
                {
                    console.log("ALL WELL");
                }
                else
                {
                    var minEndTime = moment($('.startTimeB').val(), 'HH:mm:ss').add(3, 'hours').format('HH:mm');
                    
                    $('.endTimeB').val(minEndTime);
                    console.log("Reset Date Time");
                    alert("Minimum 3 Hours Require for Booking !");
                }
            }

</script>
@endsection