{var select_value=(isset($field_info.local_field) && isset($object[$field_info.local_field]) ? $object[$field_info.local_field] : $field_value)}
{if isset($field_info.items[$select_value])}
{$field_info.items[$select_value]}
{else}
неопределено
{/if}