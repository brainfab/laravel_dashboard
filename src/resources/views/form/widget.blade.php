<?php
/** @var string $type */
/** @var array $form */
$type = isset($type) ? $type : 'form';
?>

@include('dashboard::form.widget_'.$type, ['form' => $form])