@extends('sitter.layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('frontend.user.sitter.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Vacation Mode</li>
    </ol>
</div>
<!-- Breadcrumb End -->

<!-- Notification Content Start -->
<div class="notification 2olumn-right">
    <div class="row">
        <div class="col-sm-8 main-column">
            <div class="white-box">
                <div class="white-box-title">
                    <h3>Vacation Mode</h3>
                </div>
                <div class="white-box-content">
                    {{ Form::open(['route' => 'frontend.user.sitter.changevacation', 'id' => 'vacation-form']) }}
                        <table class="table table-borderless earning-table payment-info-table">
                            <tbody>
                                <tr>
                                    <td class="v-align-top"><span>Vacation Mode</span></td>
                                    <td class="price-info">
                                        <div class="form-group select-location">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            @php
                                                $onChecked = isset($vacationMode->vacation_mode) ? (($vacationMode->vacation_mode == 1) ? 'checked="checked"' : '') : '';
                                            @endphp
                                            <input type="radio" id="choosetype-local" value="1" name="vacation_mode" required="required" {{ $onChecked }} class="custom-control-input">
                                            <label class="custom-control-label" for="choosetype-local">On</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            @php
                                                $offChecked = isset($vacationMode->vacation_mode) ? (($vacationMode->vacation_mode == 0) ? 'checked="checked"' : '') : 'checked="checked"';
                                            @endphp
                                            <input type="radio" id="choosetype-tourist" value="0" name="vacation_mode" required="required" {{ $offChecked }} class="custom-control-input">
                                            <label class="custom-control-label" for="choosetype-tourist">Off</label>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                <tr align="center">
                                    <td class="price-info" colspan="2">
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-default">Save</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div><!-- .notification end -->
<!-- Notification Content Start -->
@endsection