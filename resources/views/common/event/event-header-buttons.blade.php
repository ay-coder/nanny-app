<div class="pull-right mb-10 hidden-sm hidden-xs">

	@if(isset($listRoute))
		{{ link_to_route($listRoute, 'List', [], ['class' => 'btn btn-primary btn-xs']) }}
	@endif

	@if(isset($createRoute))
    	{{ link_to_route($createRoute, 'Create New', [], ['class' => 'btn btn-success btn-xs']) }}
    @endif
</div><!--pull right-->

<div class="pull-right mb-10 hidden-lg hidden-md">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Menu <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu">
            <li>
            	@if(isset($listRoute))
            		{{ link_to_route($listRoute, 'List', [], ['class' => 'btn btn-primary btn-xs']) }}
            	@endif
            </li>
            <li>
            	{{ link_to_route($createRoute, 'Create New', [], ['class' => 'btn btn-success btn-xs']) }}
            </li>
        </ul>
    </div><!--btn group-->
</div><!--pull right-->

<div class="clearfix"></div>