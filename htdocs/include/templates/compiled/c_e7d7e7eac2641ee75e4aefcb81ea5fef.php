<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-22 10:39:43 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>



<div class = "small">
<strong><?php echo $this->_vars['template_name']; ?>
</strong> &bull; <strong><?php echo $this->_vars['course_name']; ?>
</strong> &bull; <strong><?php echo $this->_vars['term']; ?>
</strong> &bull; <strong><?php echo $this->_vars['type']; ?>
</strong> &bull; <strong><?php echo $this->_vars['year']; ?>
</strong>
</div>