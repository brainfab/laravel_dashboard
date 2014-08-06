<!doctype html>
<html lang="ru">
<head>
    @include('admin::head')
</head>
<body class="animated fadeInDown  desktop-detected pace-done">
<header id="header">

    <div id="logo-group">
        <span id="logo"> <img alt="SmallTeam" title="SmallTeam" src="/admin/img/logo.png"> </span>
    </div>
</header>
<div role="main">

    <!-- MAIN CONTENT -->
    <div class="container" id="content">

        @yield('content')

    </div>
    <!-- END MAIN CONTENT -->

</div>
</body>
</html>