@extends ('backend.layouts.app')

@section ('title', isset($repository->moduleTitle) ? 'Edit - '. $repository->moduleTitle : 'Edit')

@section('page-header')
    <h1>
        View
        <small>Edit</small>
    </h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">View Parent Details</h3>
        </div>

        <div class="box-body">
           <div class="col-md-4">
                Name : {!! $item->name !!}
           </div>

           <div class="col-md-4">
                Email : {!! $item->name !!}
           </div>

           <div class="col-md-4">
                Mobile : {!! $item->mobile !!}
           </div>

           <div class="col-md-4">
                Address : {!! $item->address. ' '. $item->city  !!}
           </div>

           <div class="col-md-4">
                Zip : {!! $item->zip !!}
           </div>

           <div class="col-md-4">
                State : {!! $item->state !!}
           </div>

           <div class="clearfix"></div>
           <hr>
           <h4>Babies Details</h4>
           
           @if(isset($item->babies) && count($item->babies))
                <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Description</th>
                </tr>
                    @foreach($item->babies as $baby)
                        <tr>
                            <td>{!! $baby->title !!}</td>
                            <td>{!! $baby->age !!}</td>
                            <td>{!! $baby->gender !!}</td>
                            <td>{!! $baby->description !!}</td>
                        </tr>
                    @endforeach
                </table>
           @else
             <span class="label label-warning">No Babies Found</span>
           @endif
        </div>
    </div>

@endsection