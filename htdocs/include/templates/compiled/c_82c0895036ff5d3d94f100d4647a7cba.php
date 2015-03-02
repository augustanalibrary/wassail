<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-24 11:44:18 MDT */ ?>

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
echo $this->_fetch_compile_include("report.parameters.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<br />
<?php if (isset ( $this->_vars['single_template'] )): ?>
	<p class = "notice">
		<?php if ($this->_vars['single_template']): ?>
			Questions are sorted in the order they appear in the template chosen.
		<?php else: ?>
			Questions are sorted by question id because multiple templates were used to generate the data.
		<?php endif; ?>
	</p>
<?php endif; ?>

<?php if (isset ( $this->_vars['questions'] )): ?>
      <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("report.questions.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
  elseif (isset ( $this->_vars['data'] )): ?>
      <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("report.data.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
  elseif (isset ( $this->_vars['qualitative_data'] )): ?>
      <?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("report.qualitative.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>

<?php elseif (isset ( $this->_vars['qualitative_exists'] )): ?>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("report.qualitative_button.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
  endif;  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>	    