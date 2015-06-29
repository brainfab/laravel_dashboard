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