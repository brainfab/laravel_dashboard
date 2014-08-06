<!doctype html>
<html lang="ru">
<head>
    @include('admin::head')
</head>
<body>

<header id="header">
    <div id="logo-group">

        <!-- PLACE YOUR LOGO HERE -->
        <span id="logo"> <img src="/admin/img/logo.png" alt="SmallTeam"> </span>
        <!-- END LOGO PLACEHOLDER -->
    </div>

    <!-- pulled right: nav area -->
    <div class="pull-right">

        <!-- collapse menu button -->
        <div id="hide-menu" class="btn-header pull-right">
            <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
        </div>
        <!-- end collapse menu -->

        <!-- logout button -->
        <div id="logout" class="btn-header transparent pull-right">
            <span> <a href="/admin/logout/" title="Выйти" data-action="userLogout" data-logout-msg="{*You can improve your security further after logging out by closing this opened browser*}"><i class="fa fa-sign-out"></i></a> </span>
        </div>
        <!-- end logout button -->

        <!-- fullscreen button -->
        <div id="fullscreen" class="btn-header transparent pull-right">
            <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
        </div>
        <!-- end fullscreen button -->

    </div>
    <!-- end pulled right: nav area -->

</header>


<aside id="left-panel">

    <!-- User info -->
    <div class="login-info">
        <span>

            <a href="#" onclick="event.preventDefault();return false;" id="show-shortcut" data-action="toggleShortcut" class="cd">
                <img src="/admin/images/user.png" alt="me" class="online" />
                <span>
                    <?php if(isset($user_info['login'])): echo $user_info['login']; endif; ?>
                </span>
            </a>

        </span>
    </div>

    <nav>

        <ul>
            <li>
                <a href="/admin/" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
            </li>
            <?php if(isset($admin_menu)): echo $admin_menu; endif;?>
        </ul>

    </nav>
			<span class="minifyme" data-action="minifyMenu">
				<i class="fa fa-arrow-circle-left hit"></i>
			</span>
</aside>



<div id="main" role="main">

    <!-- RIBBON -->
    <div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <li><a href="/admin/">Главная</a></li><?php if (isset($module['title']) && !empty($module['title'])): ?><li><?=$module['title']?></li><?php endif; ?>
        </ol>
        <!-- end breadcrumb -->

    </div>
    <!-- END RIBBON -->

    <!-- MAIN CONTENT -->
    <div id="content">
        <!-- widget grid -->
        <section id="widget-grid" class="">

            @yield('content')

            <!-- end row -->

        </section>
        <!-- end widget grid -->

    </div>
    <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<div class="page-footer">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <span class="txt-color-white"><a class="txt-color-white" target="_blank" title="SmallTeam" href="//small-team.com">SmallTeam</a>&nbsp;©</span>
        </div>
    </div>
</div>

@include('admin::popups')

<!-- MAIN APP JS FILE -->
<script src="/admin/js/app.min.js"></script>

<script src="/admin/files_upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/admin/files_upload/js/jquery.iframe-transport.js"></script>
<script src="/admin/files_upload/js/jquery.fileupload.js"></script>

<script type="text/javascript" src="/admin/js/upload_files.js"></script>

<div class="overlay_form_edit"></div>

</body>
</html>