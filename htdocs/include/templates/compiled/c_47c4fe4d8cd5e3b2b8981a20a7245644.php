<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-03-19 15:42:06 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<h1 style = "text-align:center;">
You are not authorized to view this page.
</h1>
<br />
<h2 style = "text-align:center;">
Please <a href = "<?php echo constant('WEB_PATH'); ?>
index.php">login</a>.
</h2>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>