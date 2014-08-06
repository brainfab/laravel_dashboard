<div class="editable_field_block{if $field_error} has_errors{/if}">
    {if $field_value && count($field_value)}
        <object width="480" height="360">
            <param name="movie" value="http://www.youtube.com/v/{$field_value.code}&hl={$field_value.lang}&fs=1&cc_load_policy=1"></param>
            <param name="allowFullScreen" value="true"></param>
            <param name="allowscriptaccess" value="always"></param>
            <embed src="http://www.youtube.com/v/{$field_value.code}&hl={$field_value.lang}&fs=1&cc_load_policy=1" type="application/x-shockwave-flash"
            allowscriptaccess="always" allowfullscreen="true" width="480" height="360"></embed>
        </object>
    {/if}
</div>