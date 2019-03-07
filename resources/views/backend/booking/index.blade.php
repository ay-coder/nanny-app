@extends ('backend.layouts.app')

@section ('title',  isset($repository->moduleTitle) ? $repository->moduleTitle. ' Management' : 'Management')

@section('after-styles')
    {{ Html::style("css/backend/plugin/datatables/dataTables.bootstrap.min.css") }}
@endsection

@section('page-header')
    <h1>{{ isset($repository->moduleTitle) ? $repository->moduleTitle : '' }} Management</h1>
@endsection

@section('content')

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ isset($repository->moduleTitle) ? str_plural($repository->moduleTitle) : '' }} Listing</h3>

            <div class="box-tools pull-right">
                @include('common.'.strtolower($repository->moduleTitle).'.header-buttons', ['createRoute' => $repository->getActionRoute('createRoute')])
            </div>
        </div>

        <div class="box-body">
            <div class="table-responsive">
                <table id="items-table" class="table table-condensed table-hover">
                    <thead>
                        <tr id="tableHeadersContainer"></tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">History</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            {!! history()->renderType(ucfirst($repository->moduleTitle)) !!}
        </div>
    </div>
@endsection

@section('after-scripts')

    {{ Html::script("js/backend/plugin/datatables/jquery.dataTables.min.js") }}
    {{ Html::script("js/backend/plugin/datatables/dataTables.bootstrap.min.js") }}

    <script>
        var headers      = JSON.parse('{!! $repository->getTableHeaders() !!}'),
            columns      = JSON.parse('{!! $repository->getTableColumns() !!}');
            moduleConfig = {
                getTableDataUrl: '{!! route($repository->getActionRoute("dataRoute")) !!}',
                cancelURL: '{!! route('admin.booking.cancel') !!}'
            };

        jQuery(document).ready(function()
        {
            BaseCommon.Utils.setTableHeaders(document.getElementById("tableHeadersContainer"), headers);
            BaseCommon.Utils.setTableColumns(document.getElementById("items-table"), moduleConfig.getTableDataUrl, 'GET', columns);

            setTimeout(function()
            {
                bindCancelEvent();
            }, 1000);
            
    	});

        function bindCancelEvent()
        {
            var elements = document.querySelectorAll('.cancel-appointment');
            
            if(elements)
            {
                for(var i = 0; i < elements.length; i++)
                {
                    elements[i].onclick = function(e)
                    {
                        var element     = BaseCommon.Utils.getClosestElement(e.target, 'a');
                            bookingId   = element.getAttribute('data-id');

                        cancelBooking(bookingId);
                    }
                }
            }
        }

        function cancelBooking(id)
        {
            jQuery.ajax({
                url: moduleConfig.cancelURL,
                method: "GET",
                dataType: "JSON",
                data: {
                    bookingId: id
                },
                success: function(data)
                {
                    if(data.status == true)
                    {
                        alert("Booking Canceld Successfully!");
                        window.location.reload();
                        return ;
                    }

                    alert("Something went Wrong!");
                }
            })
        }
    </script>
@endsection