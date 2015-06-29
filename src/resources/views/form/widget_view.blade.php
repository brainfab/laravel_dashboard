<div>
    @if($form['label'] !== null)
        @include('dashboard::form.label', $form['label'])
    @endif
    @include('dashboard::form.view.'.$form['type'], $form)
</div>