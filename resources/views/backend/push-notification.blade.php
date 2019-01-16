@extends('backend.layouts.app')

@section('page-header')
    <h1>
        {{ app_name() }}
        <small>Send Push Notifications</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('strings.backend.dashboard.welcome') }} {{ $logged_in_user->name }}!</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            <h3 class="box-title">Push Notifications</h3>

            {{ Form::open([
                'route'     => 'admin.push-notifications',
                'class'     => 'form-horizontal',
                'role'      => 'form',
                'method'    => 'post'
            ])}}
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('notification_text', 'Notification Text :', ['step' => 0.1, 'min' => 0, 'class' => 'col-lg-2 control-label']) }}
                        <div class="col-lg-10">
                            {{ Form::textarea('notification_text', null, ['class' => 'form-control', 'required' => 'required']) }}
                        </div>
                    </div>
                </div>

                <div class="box box-info">
                    <div class="box-body">
                        <div class="pull-right">
                            {{ Form::submit('Send', ['class' => 'btn btn-success btn-lg']) }}
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            {{ Form::close() }}
        </div><!-- /.box-body -->
    </div><!--box box-success-->

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            {!! history()->render() !!}
        </div><!-- /.box-body -->
    </div><!--box box-success-->
@endsection