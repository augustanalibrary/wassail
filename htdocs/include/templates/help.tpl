{include file="head.popup.tpl"}

{* If the user can write, output the JS & page to allow that *}
{if $can_write}

{* Similar JS code is available in head.popup.tpl.  However, the editor which is necessary to be loaded here has different capabilities than common users get, so this needs a special init *}
	<script type = "text/javascript" src = "include/tinyMCE/tiny_mce.js"></script>
	<script type = "text/javascript">
	{literal}
tinyMCE.init({
      mode : "none",
      theme : "advanced",
      file_browser_callback : 'myFileBrowser',
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left"
,
      theme_advanced_buttons1 : "cut,copy,paste,pasteword,|,undo,redo,|,indent,outdent,|,justifyleft,justifycenter,justifyright,bullist,numlist,fullscreen,code,removeformat,link,anchor",
      theme_advanced_buttons2 : "bold,italic,underline,strikethrough,sub,sup,|,forecolor,fontselect,fontsizeselect,image",
      theme_advanced_buttons3 : "",
      theme_advanced_fonts : "Arial=arial,helvetica,sans-serif;Courier=courier new,courier,monospace;Times=times new roman,times,serif;Verdana(default)=verdana,tahoma,sans-serif"
,
      content_css : "/include/templates/editor.css",
      apply_source_formatting : true,
      convert_fonts_to_spans : true,
      plugins : "fullscreen,nbspfix,paste"
});
{/literal}
</script>

{* Display the link to show/hide the form *}
<div style = "text-align:right;">
<img src = "include/templates/images/printer.png" alt = "Print" title = "Click to print this page" onclick = "window.print();" class = "clickable"/>
{if $can_write}
<img src = "include/templates/images/pencil.png" alt = "Edit help" title = "Click to edit the help for this page" id = "help-edit" class = "clickable"/>
{/if}
</div>
{* Display the form *}
{* Note that tinyMCE is loaded by Javascript at the same time this form becomes visible *}
    <div id = "form" style = "display:none;">
      <form method = "post" action = "{$templatelite.SERVER.REQUEST_URI}">
      <div>
	<textarea name = "help-content" id = "help-content" rows = "50" cols = "60" style = "width:100%;">{$content}</textarea>
	<input type = "submit" name = "submit" class = "submit" value = "Save" />
      </div>
    </form>
    </div>

<script type = "text/javascript">
{literal}
$("#help-edit").click(function(){
			if(tinyMCE.getInstanceById('help-content') == null)
			  tinyMCE.execCommand('mceAddControl',false,'help-content');
			else
			  tinyMCE.execCommand('mceRemoveControl',false,'help-content');

			$("#form").toggle();
			$("#plain-content").toggle();
		      });


function myFileBrowser(field_name,url,type,win)
{
  tinyMCE.openWindow({
    file : "/include/imageManager.php",
	title : "File Browser",
	width : 750,
	height : 550,
	close_previous : "no"
	},{
    window : win,
    input : field_name,
    resizable : "yes",
			 scrollbars : "yes",
    editor_id : tinyMCE.selectedInstance.editorId
			 });
  return false;
}

{/literal}
</script>
{/if}



{* For all users, display the content plainly at first *}
<div id = "plain-content">
{$content}
</div>

{include file="foot.popup.tpl"}
