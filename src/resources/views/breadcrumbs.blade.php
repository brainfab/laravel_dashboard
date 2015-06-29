<section class="content-header">
    <h1>
        {{ $dashboard->getName() }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> {{ trans($dashboard->getEntity()->getName()) }}</a></li>
    </ol>
</section>