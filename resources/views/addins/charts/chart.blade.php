<div id="{!!$chart->getID()!!}" {!! \HTML::attributes($chart->getAttributesArray()) !!}></div>


<script type="text/javascript">
    jQuery(window).load(function() {
        var {!!$chart->getID()!!} = new CanvasJS.Chart("{!!$chart->getID()!!}",{!! $chart->getChart() !!});
    {!!$chart->getID()!!}.render();
    });
</script>
