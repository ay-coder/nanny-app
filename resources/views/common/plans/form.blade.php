<div class="box-body">
    <div class="form-group">
        {{ Form::label('title', 'Title :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('amount', 'Amount :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::number('amount', null, ['min' => 0, 'step' => 1, 'class' => 'form-control', 'placeholder' => 'Amount', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('description', 'Description :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Description', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('sub_title', 'Sub Title :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('sub_title', null, ['class' => 'form-control', 'placeholder' => 'Sub Title', 'required' => 'required']) }}
        </div>
    </div>
</div><div class="box-body">
    <div class="form-group">
        {{ Form::label('plan_type', 'Plan Type :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::select('plan_type', [
                'A'=> 'A',
                'B'=> 'B',
                'C'=> 'C'
                ], null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
</div>

<div class="box-body">
    <div class="form-group">
        {{ Form::label('subscription_count', 'Booking Allowed :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::number('subscription_count', null, ['class' => 'form-control', 'min' => 1, 
            'step' => 1, 'required' => 'required']) }}
        </div>
    </div>
</div>