<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@section('title'){{ app('dashboard')->getName() }}@show</title>
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
    @section('header')
        @include('dashboard::header')
    @show

    @section('sidebar')
        @include('dashboard::sidebar')
    @show

    <div class="content-wrapper">
        @section('breadcrumbs')
            @include('dashboard::breadcrumbs')
        @show

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