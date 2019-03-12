@extends ('backend.layouts.app')

@section ('title', isset($repository->moduleTitle) ? 'Edit - '. $repository->moduleTitle : 'Edit')

@section('page-header')
    <h1>
        {{$repository->moduleTitle}}
        <small>Edit</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($item, ['route' => [$repository->getActionRoute('updateRoute'), $item], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $repository->moduleTitle }}</h3>
                    <div class="box-tools pull-right">
                        @include('common.'.strtolower($repository->moduleTitle).'.header-buttons', [
                            'listRoute' => $repository->getActionRoute('listRoute'),
                            'createRoute' => $repository->getActionRoute('createRoute')
                        ])
                    </div>
            </div>

            @include('common.'.strtolower($repository->moduleTitle).'.form')
        </div>

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route($repository->getActionRoute('listRoute'), 'Cancel', [], ['class' => 'btn btn-danger btn-xs']) }}
                </div>

                <div class="pull-right">
                    {{ Form::submit('Update', ['class' => 'btn btn-success btn-xs']) }}
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    {{ Form::close() }}
@endsection

@section('after-scripts')
<script type="text/javascript">
    
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
