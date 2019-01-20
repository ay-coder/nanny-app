<div class="box-body">
    <div class="form-group">
        {{ Form::label('user_id', 'Parent :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::select('user_id', ['' => 'Select Parent'] + $parents, null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
</div>


<div class="box-body">
    <div class="form-group">
        {{ Form::label('plan_id', 'Select Plan :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::select('plan_id', ['' => 'Select Plan'] + $plans, null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('allowed_bookings', 'Allowed Bookings :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::number('allowed_bookings', null, ['min' => 1, 'class' => 'form-control', 'placeholder' => 'Allowed Bookings', 'required' => 'required']) }}
        </div>
    </div>
</div>