<style>
    input#password {
        width: 100%;
        height: 35px;
    }
</style>
@php
    $disabled = '';

    if(isset($item->id))
    {
        $disabled = 'disabled';        
    }

@endphp

<div class="box-body">
    <div class="form-group">
        {{ Form::label('name', 'Name :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('name', isset($item->user) ? $item->user->name : null, ['class' => 'form-control', 'placeholder' => 'User Name', 'required' => 'required']) }}
        </div>
    </div>
</div>

@if(!$disabled)
<div class="box-body">
    <div class="form-group">
        {{ Form::label('password', 'Password :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::password('password', null, ['class' => 'form-control', 'disabled' => $disabled, 'placeholder' => 'Password', 'required' => 'required']) }}
        </div>
    </div>
</div>
@endif

<div class="box-body">
    <div class="form-group">
        {{ Form::label('email', 'Email Id:', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('email', isset($item->user) ? $item->user->email : null, ['class' => 'form-control',   $disabled, 'placeholder' => 'Email', 'required' => 'required']) }}
        </div>
    </div>
</div>

<div class="box-body">
    <div class="form-group">
        {{ Form::label('mobile', 'Mobile:', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('mobile', isset($item->user) ? $item->user->mobile : null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>

</div>


<div class="box-body">
    <div class="form-group">
        {{ Form::label('vacation_mode', 'Vacation Mode :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::select('vacation_mode', [
                '1' => 'Yes',
                '0' => 'No'
            ], null, ['class' => 'form-control', 'required' => 'required']) }}
        </div>
    </div>
</div>

<div class="box-body">
    <div class="form-group">
        {{ Form::label('category', 'Category :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::select('category', [
                '' => 'Please Select Category',
                'Baby Child' => 'Baby Child',
                'Pet'        => 'Pet'
            ], null, ['class' => 'form-control', 'placeholder' => 'Category', 'required' => 'required']) }}
        </div>
    </div>
</div>



<div class="box-body">
    <div class="form-group">
        {{ Form::label('sitter_start_time', 'Start Time :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('sitter_start_time', null, ['class' => 'form-control', 'placeholder' => 'Start Time', 'disabled' => $disabled, 'required' => 'required']) }}
        </div>
    </div>
</div>


<div class="box-body">
    <div class="form-group">
        {{ Form::label('sitter_end_time', 'End Time :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::text('sitter_end_time', null, ['class' => 'form-control', 'placeholder' => 'End Time', 'disabled' => $disabled, 'required' => 'required']) }}
        </div>
    </div>
</div>



<div class="box-body">
    <div class="form-group">
        {{ Form::label('about_me', 'About Me :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::textarea('about_me', null, ['class' => 'form-control', 'placeholder' => 'About Me', 'required' => 'required']) }}
        </div>
    </div>
</div>

<div class="box-body">
    <div class="form-group">
        {{ Form::label('description', 'Description :', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Description']) }}
        </div>
    </div>
</div>