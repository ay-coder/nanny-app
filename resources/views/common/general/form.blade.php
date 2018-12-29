@php
    $disabled = '';

if(isset($item) && isset($item->id))
{
    $disabled = 'disabled';
}

@endphp
<div class="box-body">
    <div class="form-group">
        {{ Form::label('data_key', 'Entity :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('data_key', null, ['class' => 'form-control', 'placeholder' => 'Data Key', 'required' => 'required', $disabled]) }}
        </div>
    </div>
</div>

<div class="box-body">
    <div class="form-group">
        {{ Form::label('data_value', 'Data Value :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('data_value', null, ['class' => 'form-control', 'placeholder' => 'Data Value', 'required' => 'required']) }}
        </div>
    </div>
</div>
