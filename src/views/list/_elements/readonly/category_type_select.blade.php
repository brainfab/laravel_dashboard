{var select_value=(isset($field_info.local_field) && isset($object[$field_info.local_field]) ? $object[$field_info.local_field] : $field_value)}
{if $field_value == 1}
	<span class="readonly_text_field">Книги</span>
{else}
	<span class="readonly_text_field">Категории</span>
{/if}
