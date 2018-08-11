@extends('parent.layouts.app')

@section('content')
<div class="search-box">
    <form action="search.html">
        <!-- Select Date, Time start -->
        <div class="form-row">
            <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="date">Date</label>
                <input type="text" class="form-control date" placeholder="09 April 2017">
            </div>
            <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="start-time">Start Time</label>
                <input type="text" class="form-control startTime" placeholder="2:00 AM">
            </div>
            <div class="form-group col-md-4 dropdown">
                <label class="control-label" for="end-time">End Time</label>
                <input type="text" class="form-control endTime" placeholder="10:00 PM">
            </div>
        </div>
        <!-- Select Date, Time End -->

        <!-- Select Location start -->
        <div class="form-group select-location">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="choosetype-local" name="choosetype" class="custom-control-input">
                <label class="custom-control-label" for="choosetype-local">Local</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="choosetype-tourist" name="choosetype" class="custom-control-input">
                <label class="custom-control-label" for="choosetype-tourist">Tourist</label>
            </div>
        </div>
        <!-- Select Location End -->

        <!-- Select Baby List start -->
        <div class="form-group baby-list">
            <div class="row">
                <div class="col-sm-12">
                    <h3>Select Baby</h3>
                </div>
                <div class="col-sm-4">
                    <div class=" custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="baby1">
                        <label class="custom-control-label" for="baby1"><img src="../assets/images/baby1.png" alt=""> Mabel Wilson</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class=" custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="baby2">
                        <label class="custom-control-label" for="baby2"><img src="../assets/images/baby2.png" alt=""> Allie Moss</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class=" custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="baby3">
                        <label class="custom-control-label" for="baby3"><img src="../assets/images/baby3.png" alt=""> Max Bryant</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class=" custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="baby4">
                        <label class="custom-control-label" for="baby4"><img src="../assets/images/baby4.png" alt=""> Lilly Goodwin</label>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class=" custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="baby5">
                        <label class="custom-control-label" for="baby5"><img src="../assets/images/baby5.png" alt=""> Max Bryant</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- Select Baby List End -->

        <div class="form-group text-center">
            <button type="submit" class="btn btn-default">Find Sitter</button>
        </div>
    </form>
</div>
<!-- Search form End -->
@endsection