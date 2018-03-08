<div class="col-md-12 paginateSelect">
    @if($tools)
    <div class="w475 pull-left tableTools hidden-xs">
        <button class="btn btn-link btn-xs" id="selectAll">Select All</button>
        <button class="btn btn-link btn-xs" id="unselectAll">Unselect All</button>
        <button class="btn btn-link btn-xs green" onClick="modifyAction('enable');"><span class="fa fa-check-circle-o" aria-hidden="true"></span> Enable Selected</button>
        <button class="btn btn-link btn-xs red" onClick="modifyAction('disable');"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> Disable Selected</button>
    </div>
    @endif

    {!! Form::open(array('method' => 'get')) !!}
    <div class="w75 pull-right">
        @if(Input::get('id'))
            {!! Form::hidden('id', Input::get('id')) !!}
        @endif
        {!! Form::submit('# of Items', ['class' => 'btn btn-primary btn-sm']) !!}
    </div>
    <div class="w75 pull-right">
        {{-- Pagination Select --}}
        {!! Form::select('perPage',
            array(
                '10' => '10',
                '20' => '20',
                '30' => '30',
                '50' => '50',
            ),
            InputRequest::paginateSelectValue(),
            array('class' => 'form-control input-sm')
        )!!}
    </div>
    {!! Form::close() !!}
</div>

<div class="col-md-12
">
    <span class="flagItem glyphicon glyphicon-star glyphicon-medium Important" aria-hidden="true"></span> = Important
</div>