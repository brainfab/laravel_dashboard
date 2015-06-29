<input
    type="text"
    id="{{ $form['id'] }}"
    name="{{ $form['full_name'] }}"
    value="{{ $form['value'] or '' }}"
    @if(isset($form['options']['attr']) && is_array($form['options']['attr']) && count($form['options']['attr']) )
        @foreach($form['options']['attr'] as $name => $value)
            {{ $name }}="{{ $value }}"
        @endforeach
    @endif
            />