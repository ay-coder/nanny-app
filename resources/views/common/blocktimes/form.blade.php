<div class="box-body">
    <div class="form-group">
        {{ Form::label('sitter_id', 'Select Sitter :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::select('sitter_id', ['Please Select Sitter'] + $users, null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
</div>

<div class="box-body">
    <div class="form-group">
        {{ Form::label('day_name', 'Select Day :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::select('day_name', [
                'Mon' => 'Monday',
                'Tue' => 'Tuesday',
                'Wed' => 'Wednesday',
                'Thu' => 'Thursday',
                'Fri' => 'Monday',
                'Sat' => 'Saturday',
                'Sun' => 'Sunday',
            ], null, ['class' => 'form-control', 'placeholder' => 'Day Name', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('start_time', 'Start Time :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('start_time', null, ['class' => 'form-control', 'placeholder' => 'Start Time', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('end_time', 'End Time :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('end_time', null, ['class' => 'form-control', 'placeholder' => 'End Time', 'required' => 'required']) }}
        </div>
    </div>
</div>