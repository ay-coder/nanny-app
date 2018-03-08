<div class="box-body">
    <div class="form-group">
        {{ Form::label('name', 'Event Name :', ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Event Name', 'required' => 'required']) }}
        </div>
    </div>
</div>

<div class="box-body">
    <div class="form-group">
        {{ Form::label('Title', 'Event Title :', ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Event Name' , 'required' => 'required']) }}
        </div>
    </div>
</div>

<div class="box-body">
    <div class="form-group">
        {{ Form::label('StartDate', 'Event Start Date :', ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            {{ Form::text('start_date', null, ['class' => 'form-control datepicker', 'placeholder' => 'Start Date' , 'required' => 'required']) }}
        </div>
    </div>
</div>

<div class="box-body">
    <div class="form-group">
        {{ Form::label('EndDate', 'Event End Date :', ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            {{ Form::text('end_date', null, ['class' => 'form-control datepicker', 'placeholder' => 'End Date' , 'required' => 'required']) }}
        </div>
    </div>
</div>