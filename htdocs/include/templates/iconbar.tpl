<div id = "iconbar">
{if !isset($hide_legend)}
  <div id = "legend">
    {if $icons.add}
    <img src = "include/templates/images/add.png" alt = "Add"/> = {$icons.add}
    {/if}

    {if $icons.save}
    <img src = "include/templates/images/disk.png" alt = "Save"/> = {$icons.save}
    {/if}

    {if $icons.edit}
    <img src = "include/templates/images/pencil.png" alt = "Edit"/> = {$icons.edit}
    {/if}

    {if $icons.delete}
    <img src = "include/templates/images/bin.png" alt = "Delete" /> = {$icons.delete}
    {/if}

    {if $icons.show}
    <img src = "include/templates/images/eye.png" alt = "Show" /> = {$icons.show}
    {/if}

    {if $icons.hide}
    <img src = "include/templates/images/eye-closed.png" alt = "Hide" /> = {$icons.hide}
    {/if}

    {if $icons.filter}
    <img src = "include/templates/images/filter.png" alt = "Filter" /> = {$icons.filter}
    {/if}

    {if $icons.stop}
    <img src = "include/templates/images/stop.png" alt = "Stop" /> = {$icons.stop}
    {/if}

    {if $icons.user_add}
    <img src = "include/templates/images/user_add.png" alt = "Add user" /> = {$icons.user_add}
    {/if}

    {if $icons.key}
    <img src = "include/templates/images/password.png" alt = "Password" /> = {$icons.key}
    {/if}

    {if $icons.import_csv}
    <img src = "include/templates/images/page_white_go.png" alt = "Import CSV" /> = {$icons.import_csv}
    {/if}

    {if $icons.export_csv}
    <img src = "include/templates/images/page_excel.png" alt = "Export" /> = {$icons.export_csv}
    {/if}

    {if $icons.print}
    <img src = "include/templates/images/printer.png" alt = "Print" /> = {$icons.print}
    {/if}

    {if $icons.copy}
    <img src = "include/templates/images/page_copy.png" alt = "Copy" /> = {$icons.copy}
    {/if}

    {if $icons.webify}
    <img src = "include/templates/images/application_form_add.png" alt = "Make web form" /> = {$icons.webify}
    {/if}
	{if $icons.webify_edit}
    <img src = "include/templates/images/application_form_edit.png" alt = "Edit web form" /> = {$icons.webify_edit}
    {/if}

    {if $icons.expand}
    <img src = "include/templates/images/arrow_out.png" alt = "Expand" /> = {$icons.expand}
    {/if}

    {if $icons.shrink}
    <img src = "include/templates/images/arrow_in.png" alt = "Shrink" /> = {$icons.shrink}
    {/if}
	
	{if $icons.sort}
    <img src = "include/templates/images/arrow_up.png" alt = "Sort by column" /> = {$icons.sort}
    {/if}
	
	{if $icons.reorder}
    <img src = "include/templates/images/arrow-up-down.png" alt = "Reorder" /> = {$icons.reorder}
    {/if}
	
	{if $icons.correct}
    <img src = "include/templates/images/check-grey.png" alt = "Mark as correct" /> = {$icons.correct}
    {/if}
	
	{if $icons.correct_bar}
	<span style = "background-color:#DDAA33;padding:0 3px;">{$icons.correct_bar}</span>
	{ /if }

    {if $icons.switch}
        <img src = "include/templates/images/arrow-switch.png" alt = "Switch" /> = {$icons.switch}
    {/if}

  </div>
  <img src = "include/templates/images/information.png" alt = "Legend" title = "Click for icon legend" id = "info" />
{/if}
{if isset($show_print_icon)}
  <img src = "include/templates/images/printer.png" alt = "Print" title = "Click to print screen" onclick = "window.print()" />
{ /if }
{ if !isset($hide_help) }
  <img src = "include/templates/images/help.png" alt = "Help" title = "Click for Help" id = "help" />
 { /if }
<script type = "text/javascript">
var page_script_name = '{$templatelite.SERVER.SCRIPT_NAME}'.substring(WEB_PATH.length-1);
{literal}
$('#help').click(function(){
		   window.open(WEB_PATH+'help.php?from='+page_script_name,'helpWindow','width=870,height=600,resizable=yes,scrollbars=yes,toolbars=no,status=no');
		 });
{/literal}
</script>
</div>

