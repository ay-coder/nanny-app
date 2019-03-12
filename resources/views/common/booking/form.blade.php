<div class="box-body">
    <div class="form-group">
        @if(isset($item->id))
            <input type="hidden" name="user_id" value="{!!  $item->user_id!!}">
            {{ Form::label('user_id', 'Parent:', ['class' => 'col-lg-2 control-label']) }}
            {!! $item->user->name !!}
        @else
            {{ Form::label('user_id', 'Parent :', ['class' => 'col-lg-2 control-label']) }}
            <div class="col-lg-10">
                {{ Form::select('user_id', ['' => 'Select Parent'] + $parents, null, ['class' => 'form-control', 'required' => 'required', isset($item->id) ? 'disabled' : '']) }}
            </div>
        @endif
    </div>
</div>



<div class="box-body">
    <div class="form-group">
        {{ Form::label('sitter_id', 'Sitter:', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::select('sitter_id', [ '' => 'Please Select Sitter'] + $sitters, null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
</div>


<div class="box-body">
    <div class="form-group">
        {{ Form::label('baby_ids', 'Select Babies:', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::select('baby_ids[]', isset($allBabies) ? $allBabies : ['' => 'Select Baby'], isset($selectedBabies) ? $selectedBabies : null, ['id' => 'baby_ids', 'class' => 'form-control', 'multiple' => 'multiple', 'required' => 'required']) }}
        </div>
    </div>
</div>

<div class="box-body">
    <div class="form-group">
        {{ Form::label('booking_date', 'Booking Date :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('booking_date', null, ['class' => 'form-control futuredate', 'placeholder' => 'Booking Date', 'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="box-body">
    <div class="form-group">
        {{ Form::label('booking_start_time', 'Booking Start Time :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('booking_start_time', isset($item->id) ? $item->start_time : date('h:i'), ['class' => 'form-control startTimeB', 'placeholder' => 'Booking Start Time', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('booking_end_time', 'Booking End Time :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('booking_end_time', isset($item->id) ? $item->end_time : date('h:i', strtotime('+3 hours')), ['class' => 'form-control endTimeB', 'placeholder' => 'Booking End Time', 'required' => 'required']) }}
        </div>
    </div>
</div>