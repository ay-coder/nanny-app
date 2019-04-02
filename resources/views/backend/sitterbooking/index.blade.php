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
            <div class="box-tools">
                <div class="col-md-12">
                    <div class="col-md-3">
                    {{ Form::select('user_id', ['' => 'Please Select User'] + $allUsers, session('sitterBookingFilter') ? session('sitterBookingFilter') : '', ['id' => 'user_id', 'class' => 'form-control']) }}
                    </div>
                    <div class="col-md-3">
                    <input type="text" class="form-control" id="startDate" value="{!! session('startDate') ? session('startDate') : date('m/d/Y', strtotime('-2 months')) !!}" name="startDate">
                    </div>
                    <div class="col-md-3">
                    <input type="text" id="endDate"  value="{!! session('endDate') ? session('endDate') : date('m/d/Y') !!}" class="form-control" name="endDate">
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary" id="filterBtn">Filter</button>
                    </div>
                </div> 
            </div>

            <div class="clearfix"></div>
            <div><br><br></div>

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
                filterMessageUrl: '{!! route('admin.sitterbooking.filter') !!}'
            };

        jQuery(document).ready(function()
        {
            BaseCommon.Utils.setTableHeaders(document.getElementById("tableHeadersContainer"), headers);
            BaseCommon.Utils.setTableColumns(document.getElementById("items-table"), moduleConfig.getTableDataUrl, 'GET', columns);

            jQuery(document.getElementById('startDate')).datepicker()
            jQuery(document.getElementById('endDate')).datepicker()

            
            setTimeout(function()
            {
                bindFilterEvent();
            }, 1000);
    	});

        function bindFilterEvent()
        {
            var element = document.getElementById('filterBtn');
            if(element)
            {
                element.onclick = function(e)
                {
                    filterMessages(document.getElementById('user_id').value);
                }
            }
        }

        function filterMessages(id)
        {
            jQuery.ajax({
                url: moduleConfig.filterMessageUrl,
                method: "GET",
                dataType: "JSON",
                data: {
                    userId: id,
                    startDate: document.getElementById('startDate').value,
                    endDate: document.getElementById('endDate').value
                },
                success: function(data)
                {
                    if(data.status == true)
                    {
                        window.location.reload();
                        return ;
                    }

                    alert("Something went Wrong!");
                }
            })
        }
    </script>
@endsection