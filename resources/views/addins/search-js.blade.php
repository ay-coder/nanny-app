<script type="text/javascript">
    jQuery("select.searchBy").select2({
        minimumResultsForSearch: Infinity
    });

    jQuery('#searchForm').submit(function(event) {

        event.preventDefault();

        var string      = jQuery(this).find('[name=string]').val();
        var type        = jQuery(this).find('[name=searchBy]').val();
        var queryString = type + '=' + string + '&q=' + string;

        if(string !== '')
        {
            window.location.search = queryString;
        }
    });
</script>

@if(isset($flags) && $flags == false)
@else
<div class="col-md-12 flagLegend">
    <span class="flaglegendItem glyphicon glyphicon-pushpin glyphicon-medium None" aria-hidden="true"></span> No Flag
    <span class="flaglegendItem glyphicon glyphicon-pushpin glyphicon-medium Important" aria-hidden="true"></span> Important
    <span class="flaglegendItem glyphicon glyphicon-pushpin glyphicon-medium Review" aria-hidden="true"></span> Needs Review
</div>
@endif