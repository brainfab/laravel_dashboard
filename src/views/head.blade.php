<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Панель Управления</title>
    <base href="<?=$_ftl['base']?>" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="/admin/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/admin/css/font-awesome.min.css">

    <!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
    <link rel="stylesheet" type="text/css" media="screen" href="/admin/css/smartadmin-production.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/admin/css/smartadmin-skins.min.css">

    <!-- SmartAdmin RTL Support is under construction
         This RTL CSS will be released in version 1.5
    <link rel="stylesheet" type="text/css" media="screen" href="/admin/css/smartadmin-rtl.min.css"> -->

    <!-- We recommend you use "your_style.css" to override SmartAdmin
         specific styles this will also ensure you retrain your customization with each SmartAdmin update.
    <link rel="stylesheet" type="text/css" media="screen" href="/admin/css/your_style.css"> -->

    <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
    <link rel="stylesheet" type="text/css" media="screen" href="/admin/css/demo.min.css">

    <!-- FAVICONS -->
    <link rel="shortcut icon" href="/admin/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/admin/img/favicon/favicon.ico" type="image/x-icon">

    <!-- GOOGLE FONT -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <!-- Specifying a Webpage Icon for Web Clip
         Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="/admin/img/splash/sptouch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/admin/img/splash/touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/admin/img/splash/touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/admin/img/splash/touch-icon-ipad-retina.png">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="/admin/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="/admin/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="/admin/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

    <script type="text/javascript" src="/admin/ckeditor_moono/ckeditor.js"></script>
    <script type="text/javascript" src="/admin/ckeditor_moono/config.js"></script>
    <script type="text/javascript" src="/admin/ckeditor_moono/styles.js"></script>


    <link rel="stylesheet" href="/admin/css/admin_main.css">
    <link rel="stylesheet" href="/admin/css/general.css">

    <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
    <script data-pace-options='{ "restartOnRequestAfter": true }' src="/admin/js/plugin/pace/pace.min.js"></script>
    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
    <script src="/admin/js/libs/jquery-2.0.2.min.js"></script>

    <script src="/admin/js/libs/jquery-ui-1.10.3.min.js"></script>
    <script>
        var app_name = '<?php if(isset( $app_name )): echo $app_name; endif; ?>';

        <?php if (isset($module['name']) && !empty($module['name'])): ?>
        var module_name = '<?=$module['name']?>';
        <?php else: ?>
        var module_name = '';
        <?php endif; ?>

        <?php if(isset($pager['current_page']) && $pager['current_page'] > 1): ?>
        var pager_page = 'page-<?=$pager['current_page']?>';
        <?php else: ?>
        var pager_page = '';
        <?php endif; ?>

        <?php if(isset($module['model'])): ?>
        var model_name = '<?=$module['model']?>';
        <?php else: ?>
        var model_name = '';
        <?php endif; ?>
    </script>

    <!-- JS TOUCH : include this plugin for mobile drag / drop touch events
    <script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

    <!-- BOOTSTRAP JS -->
    <script src="/admin/js/bootstrap/bootstrap.min.js"></script>

    <!-- CUSTOM NOTIFICATION -->
    <script src="/admin/js/notification/SmartNotification.min.js"></script>

    <!-- JARVIS WIDGETS -->
    <script src="/admin/js/smartwidgets/jarvis.widget.min.js"></script>

    <!-- EASY PIE CHARTS -->
    <script src="/admin/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

    <!-- SPARKLINES -->
    <script src="/admin/js/plugin/sparkline/jquery.sparkline.min.js"></script>

    <!-- JQUERY VALIDATE -->
    <script src="/admin/js/plugin/jquery-validate/jquery.validate.min.js"></script>

    <!-- JQUERY MASKED INPUT -->
    <script src="/admin/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

    <!-- JQUERY SELECT2 INPUT -->
    <script src="/admin/js/plugin/select2/select2.min.js"></script>

    <!-- JQUERY UI + Bootstrap Slider -->
    <script src="/admin/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

    <!-- browser msie issue fix -->
    <script src="/admin/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

    <!-- FastClick: For mobile devices -->
    <script src="/admin/js/plugin/fastclick/fastclick.min.js"></script>

    <!--[if IE 8]>

    <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

    <![endif]-->

    <!-- PAGE RELATED PLUGIN(S) -->

    <!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
    <script src="/admin/js/plugin/flot/jquery.flot.cust.min.js"></script>
    <script src="/admin/js/plugin/flot/jquery.flot.resize.min.js"></script>
    <script src="/admin/js/plugin/flot/jquery.flot.tooltip.min.js"></script>

    <!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
    <script src="/admin/js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/admin/js/plugin/vectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Full Calendar -->
    <script src="/admin/js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>

    <script type="text/javascript" src="/admin/js/main.js"></script>