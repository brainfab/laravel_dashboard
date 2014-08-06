<?php
$pages_count = $pager['pages_count'];
$post_link = isset($post_link) ? $post_link : '';
?>
<ul class="pagination pagination-xs no-margin pull-right">
    @if ($pager['pages_count'] > 1)
    @if ($pager['current_page'] > 1)
    <?php $cp2 = $pager['current_page']-1; ?>
    <li><a class="item_link arrow" href="/{{$link}}{{$pre_page_link}}{{$cp2}}{{$post_link}}"><span class="item_inner">&laquo;</span></a></li>
    @else
    <li class="item_link">&nbsp;</li>
    @endif
	@if ($pager['pages_count']>1)
		@if ($pager['current_page']<9)
		    @for ($i=1; $i<min($pages_count+1, 10); $i++)
		        @if ($i != $pager['current_page'])
                    <li>
                        <a class="item_link" href="/{{$link}}{{$pre_page_link}}{{$i}}{{$post_link}}"><span class="item_inner">{{$i}}</span></a>
		            </li>
                @else
                    <li class="active"><span class="item_link item_active">{{$i}}</span></li>
		        @endif
            @endfor
            @if ($pager['pages_count'] > 9)
            <li><span class="item_link">...</span></li>
		    <li><a class="item_link" href="/{{$link}}{{$pre_page_link}}{{$pager['pages_count']}}{{$post_link}}"><span class="item_inner">{{$pager['pages_count']}}</span></a></li>
		    @endif

		@elseif ($pager['current_page'] < ($pager['pages_count']-5))
		    @if (1 == $pager['current_page'])
                <li class="active"><span class="item_link item_active">1</span></li>
		    @else
		        <li><a class="item_link" href="/{{$link}}{{$pre_page_link}}1{{$post_link}}"><span class="item_inner">1</span></a></li>
		    @endif
            <li><span class="item_link">...</span></li>
		    @for ($i=$pager['current_page']-4; $i < ($pager['current_page']+5); $i++)
		        @if ($i != $pager['current_page'])
                    <li><a class="item_link" href="/{{$link}}{{$pre_page_link}}{{$i}}{{$post_link}}"><span class="item_inner">{{$i}}</span></a></li>
		        @else
                    <li class="active"><span class="item_link item_active">{{$i}}</span></li>
		        @endif
		    @endfor

		    @if ($pager['pages_count'] > 9)
            <li><span class="item_link">...</span></li>
            <li><a class="item_link" href="/{{$link}}{{$pre_page_link}}{{$pager['pages_count']}}{{$post_link}}"><span class="item_inner">{{$pager['pages_count']}}</span></a></li>
		    @endif
		@else
		    @if ( 1 == $pager['current_page'])
		        <li class="active"><span class="item_link item_active">1</span></li>
            @else
                <li><a class="item_link" href="/{{$link}}{{$pre_page_link}}1{{$post_link}}"><span class="item_inner">1</span></a></li>
            @endif
            <li><span class="item_link">...</span></li>
            <?php $start = ($pager['pages_count'] - 9); ?>
            @for ($i=$start; $i < ($pager['pages_count']+1); $i++)
		        @if ($i != $pager['current_page'])
                    <li><a class="item_link" href="/{{$link}}{{$pre_page_link}}{{$i}}{{$post_link}}"><span class="item_inner">{{$i}}</span></a></li>
		        @else
                    <li class="active"><span class="item_link item_active">{{$i}}</span></li>
		        @endif
		    @endfor
		@endif
	@endif
	@if ($pager['current_page'] < $pager['pages_count'])
	<?php $cp1 = ($pager['current_page']+1); ?>
	<li><a class="item_link arrow" href="/{{$link}}{{$pre_page_link}}{{$cp1}}{{$post_link}}"><span class="item_inner">»</span></a></li>
	@endif
    @endif
</ul>