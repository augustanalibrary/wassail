<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-29 14:50:33 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<form method = 'post' action = 'popup.create_template_printout.php?id=<?php echo $this->_vars['template_id']; ?>
'>
Header: <input type = "text" size = "80" name = "header" style = "position:relative;left:0px;" class = "input-field" /><br />
Footer: <input type = "text" size = "80" name = "footer" style = "position:relative;left:3px;" class = "input-field" /><br /><br />
<input type = "submit" class = "submit" name = "generate-code" value = "Generate printout as XHTML code" />
<input type = "submit" class = "submit" name = "generate-pdf" value = "Generate printout as PDF" />
</form>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>