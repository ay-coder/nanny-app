<div class="box-body">
    <div class="form-group">
        {{ Form::label('user_id', 'User Id :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('user_id', null, ['class' => 'form-control', 'placeholder' => 'User Id', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('plan_id', 'Plan Id :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('plan_id', null, ['class' => 'form-control', 'placeholder' => 'Plan Id', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('allowed_bookings', 'Allowed Bookings :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('allowed_bookings', null, ['class' => 'form-control', 'placeholder' => 'Allowed Bookings', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('status', 'Status :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('status', null, ['class' => 'form-control', 'placeholder' => 'Status', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('activated_at', 'Activated At :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('activated_at', null, ['class' => 'form-control', 'placeholder' => 'Activated At', 'required' => 'required']) }}
        </div>
    </div>
</div>