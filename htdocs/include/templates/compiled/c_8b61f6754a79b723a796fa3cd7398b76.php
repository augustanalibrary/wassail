<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-30 13:39:59 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>


<?php if ($this->_vars['can_write']): ?>


	<script type = "text/javascript" src = "include/tinyMCE/tiny_mce.js"></script>
	<script type = "text/javascript">
	<?php echo '
tinyMCE.init({
      mode : "none",
      theme : "advanced",
      file_browser_callback : \'myFileBrowser\',
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
'; ?>

</script>


<div style = "text-align:right;">
<img src = "include/templates/images/printer.png" alt = "Print" title = "Click to print this page" onclick = "window.print();" class = "clickable"/>
<?php if ($this->_vars['can_write']): ?>
<img src = "include/templates/images/pencil.png" alt = "Edit help" title = "Click to edit the help for this page" id = "help-edit" class = "clickable"/>
<?php endif; ?>
</div>


    <div id = "form" style = "display:none;">
      <form method = "post" action = "<?php echo $_SERVER['REQUEST_URI']; ?>
">
      <div>
	<textarea name = "help-content" id = "help-content" rows = "50" cols = "60" style = "width:100%;"><?php echo $this->_vars['content']; ?>
</textarea>
	<input type = "submit" name = "submit" class = "submit" value = "Save" />
      </div>
    </form>
    </div>

<script type = "text/javascript">
<?php echo '
$("#help-edit").click(function(){
			if(tinyMCE.getInstanceById(\'help-content\') == null)
			  tinyMCE.execCommand(\'mceAddControl\',false,\'help-content\');
			else
			  tinyMCE.execCommand(\'mceRemoveControl\',false,\'help-content\');

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

'; ?>

</script>
<?php endif; ?>




<div id = "plain-content">
<?php echo $this->_vars['content']; ?>

</div>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
