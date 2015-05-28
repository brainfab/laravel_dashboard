<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $dashboard->getName() }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href="{{ asset('vendor/dashboard/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/dashboard/dist/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/dashboard/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo">
            <span class="logo-mini">{{ $dashboard->getShortName() }}</span>
            <span class="logo-lg">{{ $dashboard->getName() }}</span>
        </a>

        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav"></ul>
            </div>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="{{ trans('dashboard::phrases.Search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
                </div>
            </form>
            <ul class="sidebar-menu"></ul>
        </section>
    </aside>

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                {{ $dashboard->getName() }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ trans($dashboard->getEntity()->getName()) }}</a></li>
            </ol>
        </section>

        <section class="content">
            @yield('content')
        </section>
    </div>
</div>

<script src="{{ asset('vendor/dashboard/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<script src="{{ asset('vendor/dashboard/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/dashboard/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src='{{ asset('vendor/dashboard/plugins/fastclick/fastclick.min.js') }}'></script>
<script src="{{ asset('vendor/dashboard/dist/js/app.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/dashboard/dist/js/demo.js') }}" type="text/javascript"></script>

</body>
</html>