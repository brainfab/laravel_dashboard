<script type="text/javascript">
    {literal}
    mAttachEvents = function(){
        tinyMCE.execCommand("mceAddControl", false, "static-page-text");
    }
    {/literal}
</script>
<div style="width: 600px;">
<label class="input_label">Текст <img src="images/admin/flag_{$current_lang}.gif" alt=""/>:</label>
<div class="clear"></div>
<div style="padding-top: 5px;">
    <textarea id="static-page-text" class="editable_field input_text rich_field" style="height:600px" name="data[html_content]">{if $object}{html $object.html_content}{/if}</textarea>
</div>
</div>