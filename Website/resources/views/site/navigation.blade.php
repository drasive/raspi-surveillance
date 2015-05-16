<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Raspi Surveillance</a>
    </div>

    <span class="nav navbar-top-links navbar-right" style="padding: 15px; float: right;">
        {{{ $g_hostIpAddress }}}, {{{ $g_hostTime }}}
    </span>

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="."><i class="fa fa-video-camera" style="margin-left: 3px;"></i> Livestream</a>
                </li>
                <li>
                    <a href="video-archive"><i class="fa fa-archive fa-fw"></i> Video Archive</a>
                </li>
                <!--<li>
                    <a href="#"><i class="fa fa-gear fa-fw"></i> Management<span class="fa arrow" style="margin-top: 3px;"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="events">Events</a>
                        </li>
                        <li>
                            <a href="price-groups">Price Groups</a>
                        </li>
                        <li>
                            <a href="genres">Genres</a>
                        </li>
                    </ul>
                </li>-->
                <li>
                    <a href="about"><i class="fa fa-info-circle fa-fw"></i> About</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
