<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{!! route('admin.home') !!}">{!! trans('admin.logo') !!}</a>
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="{!! route('admin.logout') !!}">
                        <i class="fa fa-sign-out fa-fw"></i>
                        {!! trans('general.logout') !!}
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="{!! route('admin.home') !!}">
                        <i class="fa fa-dashboard fa-fw"></i>&nbsp;
                        {!! trans('admin.dashboard') !!}</a>
                </li>
                <li>
                    <a href="{!! route('admin.category.index') !!}">
                        <i class="fa fa-briefcase" aria-hidden="true"></i>&nbsp;
                        {!! trans('admin.category') !!}</a>
                </li>
                <li>
                    <a href="{!! route('admin.place.index') !!}">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;
                        {!! trans('admin.place') !!}</a>
                </li>
                <li>
                    <a href="{!! route('admin.revenue.index') !!}">
                        <i class="fa fa-rocket" aria-hidden="true"></i>&nbsp;
                        {!! trans('admin.revenue') !!}</a>
                </li>
                <li>
                    <a href="{!! route('admin.tour.index') !!}">
                        <i class="fa fa-bus" aria-hidden="true"></i>&nbsp;
                        {!! trans('admin.tour') !!}
                    </a>
                </li>
                <li>
                    <a href="{!! route('admin.review.index') !!}">
                        <i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;
                        {!! trans('admin.review') !!}
                    </a>
                </li>
                <li>
                    <a href="{!! route('admin.tourSchedule.index') !!}">
                        <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;
                        {!! trans('admin.tour_schedule') !!}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
