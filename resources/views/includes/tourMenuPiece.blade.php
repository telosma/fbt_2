<li {!! $category['id'] == $categoryCurrentId ? 'class="active"' : '' !!}>
    <a href="#">
        {!! $category['name'] !!}
        <span class="badge">{!! $tourCountTree !!}</span>
        @if ($children)
            <i class="fa fa-angle-right fa-pull-right" aria-hidden="true"></i>
        @endif
    </a>
    @if ($children)
        <ul class="nav nav-pills nav-stacked">
            {!! $children !!}
        </ul>
    @endif
</li>
