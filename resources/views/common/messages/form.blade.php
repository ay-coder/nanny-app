
<div class="box-body">

    
    @if(isset($messages) && count($messages))
        @foreach($messages as $message)

            @if($message->from_user_id == 1)
                <div class="col-md-12">
                    <div class="chat-message">
                        <span class="msg">
                            {!! $message->message !!}                            
                        </span><span class="time">
                        {!! date('m-d-Y H:i a', strtotime($message->created_at)) !!}
                        Admin
                        </span>
                    </div>
                </div>

                @if($message->is_image)
                    <div class="col-md-12">
                        <div class="chat-message">
                        <span class="msg image">
                            <img src="{!! URL::to('/').'/uploads/messages/'.$message->image !!}" alt="">
                        </span>
                        <span class="time">
                            {!! date('m-d-Y H:i a', strtotime($message->created_at)) !!}
                        </span></div>
                    </div>
                @endif
            @else
                <div class="chat-message your-msg">
                    <span class="msg">
                        {!! $message->message !!} 
                    </span>
                    <span class="time">
                        {!! date('m-d-Y H:i a', strtotime($message->created_at)) !!}
                    </span></div> 

                    @if($message->is_image)
                        <div class="chat-message your-msg">
                        <span class="msg image">
                            <img src="{!! URL::to('/').'/uploads/messages/'.$message->image !!}" alt="">
                        </span>
                        <span class="time">
                            {!! date('m-d-Y H:i a', strtotime($message->created_at)) !!}
                        </span></div>
                    @endif
            @endif

        @endforeach
    @endif
    

    <div class="form-group">
        {{ Form::label('message', 'Message:', ['class' => 'col-lg-2 control-label']) }}
        <div class="col-lg-10">
            {{ Form::textarea('message', '', ['class' => 'form-control', 'placeholder' => 'Message', 'required' => 'required']) }}
        </div>
    </div>
</div>

{{ Form::hidden('to_user_id', null) }}

