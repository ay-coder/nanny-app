@if(isset($item))
    <?php $actionLog = $item->getActionLogs(); ?>

    @if(count($actionLog) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                     Revision Log
                </h4>
            </div>

            <div class="list-group bg-gray-light">
                @foreach($actionLog as $item)

                    @if($item->user)

                        <div class="list-group-item">
                            <span class="badge mt-sm">{!! $item->getActionTime(); !!}</span>
                             <span class="block text-md text-info">
                                {!! $item->user->getFullName($item->user) !!}
                            </span>
                            <span class="text-sm">Edited by {!! $item->user->email !!}</span>

                        </div>

                    @endif

                @endforeach
              </div>
        </div>
    @endif
@endif