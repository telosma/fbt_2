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
        @include('includes.adminAlert')
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        {!! trans('general.setting') !!}
                    </a>
                    <a href="">
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
                    <a href="{!! route('admin.home') !!}"><i class="fa fa-dashboard fa-fw"></i> {!! trans('admin.dashboard') !!}</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
