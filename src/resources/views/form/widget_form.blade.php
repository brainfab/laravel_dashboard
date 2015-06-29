<div>
    @if($form['label'] !== null)
        @include('dashboard::form.label', $form['label'])
    @endif
    @include('dashboard::form.form.'.$form['type'], $form)
</div>