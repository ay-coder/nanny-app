
<!-- Deneral Discussion Popup Start -->
<div class="modal fade" id="generalDiscussion" tabindex="-1" role="dialog" aria-labelledby="generaldiscussionTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form enctype="multipart/form-data" action="{{ route('frontend.user.parent.send-message') }}" method="post">
                {!! Form::token() !!}
                <div class="modal-header text-center">
                    <h5 class="modal-title" id="generaldiscussionTitle">General Discussion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                        $messages = access()->getMyChat();
                    @endphp
                    
                    @if(isset($messages) && count($messages))
                        @foreach($messages as $message)
                            @if($message->from_user_id == 1)
                                <div class="chat-message">
                                    <span class="msg">
                                        {!! $message->message !!}                            
                                    </span><span class="time">
                                    {!! date('m-d-Y H:i a', strtotime($message->created_at)) !!}
                                    </span></div>

                                @if($message->is_image)
                                    <div class="chat-message">
                                    <span class="msg image">
                                        <img src="{!! URL::to('/').'/uploads/messages/'.$message->image !!}" alt="">
                                    </span>
                                    <span class="time">
                                        {!! date('m-d-Y H:i a', strtotime($message->created_at)) !!}
                                    </span></div>
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
                </div>
                <div class="modal-footer text-center">
                    <div class="send-msg">
                        {{-- <button class="attached-btn" type="button">Attached file</button> --}}
                        <input type="file" name="attachment" class="attached-btn" >

                        <input type="text" name="message-text" id="messageTextInput" placeholder="Enter message..." class="form-control">
                        <input type="submit" class="send-btn" id="messageSendBtn">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>