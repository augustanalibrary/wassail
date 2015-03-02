<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-03-19 15:42:27 MDT */ ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>
      WASSAIL: <?php echo $this->_vars['title']; ?>

    </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<base href = "" />
      <link rel = "stylesheet" type = "text/css" href = "include/templates/style.css"/>
      <link rel = "stylesheet" type = "text/css" href = "include/templates/print.css" media = "print"/>

	<script type = "text/javascript">
		var WEB_PATH = '<?php echo constant('WEB_PATH'); ?>
';
	</script>

<?php if ($this->_vars['load_calendar']): ?>
<link rel = "stylesheet" type = "text/css" href = "include/templates/calendar.css" />
<script type = "text/javascript" src = "include/templates/js/calendar.js"></script>
<?php endif; ?>
        <script type = "text/javascript" src = "include/templates/js/jquery-1.2.3.min.js"></script>
	<script type = "text/javascript" src = "include/templates/js/jquery.color.js"></script>
	<script type = "text/javascript" src = "include/templates/js/jquery.dimensions.pack.js"></script>
	<script type = "text/javascript" src = "include/templates/js/jquery.tooltip.pack.js"></script>
	<script type = "text/javascript" src = "include/templates/js/jquery-ui.min.js"></script>
	<script type = "text/javascript" src = "include/templates/js/funclib.js"></script>
	<?php if ($this->_vars['load_editor'] == "TRUE"): ?>
	<script type = "text/javascript" src = "include/tinyMCE/tiny_mce.js"></script>
	<script type = "text/javascript">
	<?php echo '
tinyMCE.init({
      mode : "textareas",
      theme : "advanced",
      plugins : "fullscreen,nbspfix,preview,paste",
	  preformatted: true,
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left"
,
      theme_advanced_buttons1 : "cut,copy,paste,pastetext,pasteword,|,undo,redo,|,indent,outdent,|,image,link,unlink,|,fullscreen,code,preview",
      theme_advanced_buttons2 : "bold,italic,underline,strikethrough,sub,sup,|,justifyleft,justifycenter,justifyright,|,forecolor,fontselect,fontsizeselect",
      theme_advanced_buttons3 : "",
      theme_advanced_fonts : "Arial=arial,helvetica,sans-serif;Courier=courier new,courier,monospace;Times=times new roman,times,serif;Verdana(default)=verdana,tahoma,sans-serif"
,
      convert_fonts_to_spans : true,
      content_css: "/include/templates/editor.css",
      handle_event_callback:"listenForEditorChanges",
      force_br_newlines:true,
      cleanup_on_startup : true,
      gecko_spellcheck:true,
      inline_styles : true
});
function listenForEditorChanges(){}
'; ?>

</script>
	<?php endif; ?>
    <style type = "text/css">
<?php echo '
      body{
      background-color:#fff;
}
'; ?>

      </style>
</head>
<body>
    <?php if ($this->_vars['hide_iconbar'] != TRUE): ?>
    <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("iconbar.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
    <?php endif; ?>
	<div id = "content" style = "padding-top:0px;">
