@extends ('backend.layouts.app')

@section ('title', isset($repository->moduleTitle) ? 'Create - '. $repository->moduleTitle : 'Create')

@section('page-header')
    <h1>
        {{ isset($repository->moduleTitle) ? $repository->moduleTitle : '' }}
        <small>Create</small>
    </h1>
@endsection

@section('content')
    {{ Form::open([
        'route'     => $repository->getActionRoute('storeRoute'),
        'class'     => 'form-horizontal',
        'role'      => 'form',
        'method'    => 'post'
    ])}}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Create {{ isset($repository->moduleTitle) ? $repository->moduleTitle : '' }}</h3>

                <div class="box-tools pull-right">
                    @include('common.'.strtolower($repository->moduleTitle).'.header-buttons', [
                        'listRoute'     => $repository->getActionRoute('listRoute'),
                        'createRoute'   => $repository->getActionRoute('createRoute')
                    ])
                </div>
            </div>

            {{-- Event Form --}}
            @include('common.'.strtolower($repository->moduleTitle).'.form')

        </div>

        <div class="box box-info">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route($repository->getActionRoute('listRoute'), 'Cancel', [], ['class' => 'btn btn-danger btn-xs']) }}
                </div>

                <div class="pull-right">
                    {{ Form::submit('Create', ['class' => 'btn btn-success btn-xs']) }}
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    {{ Form::close() }}
@endsection


@section('after-scripts')
<script type="text/javascript">
    var moduleConfig = {
            getBabiesUrl: '{!! route('admin.booking.get-babies') !!}'
        };

    jQuery(document).ready(function()
    {
        bindParentChangeEvent();
    });

    function bindParentChangeEvent()
    {
        if(document.getElementById('user_id'))
        {
            document.getElementById('user_id').onchange = function()
            {
                loadParentBabies();
            }   
        }
    }

    function loadParentBabies()
    {
        var parentId = document.getElementById('user_id').value,
            option;

        document.getElementById('baby_ids').innerHTML = ''

        jQuery.ajax({
            url: moduleConfig.getBabiesUrl,
            method: "GET",
            dataType: "JSON",
            data: {
                 parentId:  parentId
            },
            success: function(data)
            {
                if(data.status == true)
                {

                    for(var i = 0; i < data.babies.length; i++)
                    {
                        option = document.createElement("option");
                        option.value = data.babies[i].id;
                        option.innerHTML = data.babies[i].title;
                        
                        document.getElementById('baby_ids').appendChild(option);
                    }

                }
                console.log(data);
            }
        })
    }
            $('.startTimeB').datetimepicker({
                format: 'HH:mm'
            });

            $(".startTimeB").on("dp.change",function (e) 
            {
                validateBookingTime();
            });
            $('.endTimeB').datetimepicker({
                format: 'HH:mm'
            }).on("dp.change",function (e) 
            {
                validateBookingTime();
                console.log('Change Ebnd Time');
            });

            $('.futuredate').datetimepicker({
                viewMode: 'days',
                format: 'DD/MM/YYYY',
                minDate: new Date(),
                defaultDate:new Date()
            });

            $('.futuredate').val(moment().format('DD/MM/YYYY'));

            function validateBookingTime()
            {
                var startTime   = moment($('.endTimeB').val(), 'HH:mm:ss');
                    diff        = startTime.diff(moment($('.startTimeB').val(), 'HH:mm:ss'));

                if(diff >= 10800000)
                {
                    console.log("ALL WELL");
                }
                else
                {
                    var minEndTime = moment($('.startTimeB').val(), 'HH:mm:ss').add(3, 'hours').format('HH:mm');
                    
                    $('.endTimeB').val(minEndTime);
                    console.log("Reset Date Time");
                    alert("Minimum 3 Hours Require for Booking !");
                }
            }

</script>
@endsection
