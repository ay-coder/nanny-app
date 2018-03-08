<div class="paginateSelect">
    {!! Form::open(array('method' => 'get')) !!}
        <div class="w50 pull-right">
            {!! Form::select('perPage',
                array(
                    '5' => '5',
                    '10' => '10',
                    '20' => '20',
                    '30' => '30',
                    '50' => '50',
                ),
                (!is_null(InputRequest::paginateSelectValue()) ? InputRequest::paginateSelectValue() : '20'),
                array('class' => 'form-control input-sm pagination', 'onchange' => 'this.form.submit()')
            )!!}
        </div>
    {!! Form::close() !!}
</div>

<script type="text/javascript">
    jQuery("select.pagination").select2({
        minimumResultsForSearch: Infinity
    });
</script>