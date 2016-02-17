<section class="content-header">
    <h1>
        {{ app('dashboard')->getName() }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ trans(app('dashboard')->getEntity()->getName()) }}</a></li>
    </ol>
</section>