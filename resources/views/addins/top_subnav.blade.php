<?php $message = Session::get('message'); ?>

<div class="category-navigation">
@if(isset($top_items) && $top_items)
   <div id="top-sub-nav" class="clearfix toptab-nav owl-carousel owl-theme" role="tablist">

    @foreach($top_items as $name => $item)

        @if(!isset($item['customCondition']) || $item['customCondition'])

        @if(isset($item['permissions']) && !empty($item['permissions']))
            @needspermissions($item['permissions'])
            <div role="presentation" class="nav-item {!! ($subNavHelper->isSubNavRouteActive($item) ? 'active' : '') !!}">
                <a href="{!! $item['url'] !!}"   title="{!! $name !!}">{!! $item['icon'] !!}  <span class="subnav-title">{!! $name !!}</span></a>
            </div>
            @endauth
        @else
           <div role="presentation" class="nav-item {!! ($subNavHelper->isSubNavRouteActive($item) ? 'active' : '') !!}">
               <a href="{!! $item['url'] !!}" title="{!! $name !!}">{!! $item['icon'] !!}  <span class="subnav-title">{!! $name !!}</span></a>
           </div>
        @endif

        @endif

    @endforeach

    </div>
@elseif(!Session::get('flash_success') && !Session::get('flash_warning') && !Session::get('flash_danger') && !Session::get('flash_message'))
    <div class="h15"></div>
@endif
</div>