<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-20 15:30:06 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>

<?php if (isset ( $this->_vars['success'] )): ?>
      <div class = "<?php if ($this->_vars['success']): ?>success<?php else: ?>error<?php endif; ?>">
	<?php echo $this->_vars['message']; ?>

      </div>
<?php endif; ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("gains_analysis.parameters.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>

<?php if (isset ( $this->_vars['data'] )): ?>
      <?php if ($this->_vars['data']): ?>
        <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("gains_analysis.data.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
      <?php else: ?>
      <div class = "error">
        Those two parameter sets have no questions in common.
      </div>
      <?php endif;  endif; ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>