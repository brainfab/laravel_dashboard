<div>
    @if($form['label'] !== null)
        @include('dashboard::form.label', $form['label'])
    @endif
    @include('dashboard::form.filter.'.$form['type'], $form)
</div>