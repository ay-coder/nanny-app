{{-- Print Messages --}}
<?php $message = Session::get('message'); ?>

@if(isset($message))
    <div class="alert alert-success alert-fadeout margin-top-10 margin-bottom-5">{!! $message !!}</div>
@endif

@if(isset($customError))
    <div class="alert alert-danger alert-fadeout margin-top-10 margin-bottom-5">{!! $customError !!}</div>
@else
    {{-- Print standard errors --}}
    @if($errors && ! $errors->isEmpty() )
        @foreach($errors->all() as $error)
            <div class="alert alert-danger alert-fadeout margin-top-10 margin-bottom-5">{!! $error !!}</div>
        @endforeach
    @endif
@endif