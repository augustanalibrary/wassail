<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-24 11:23:08 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
  if ($this->_vars['confirmation']): ?>
	<?php echo $this->_vars['confirmation']; ?>

<?php else: ?>
    <h3 style = "text-align:center;">
Finished...thank you!</h3>
<?php endif; ?>
<h3 style = "text-align:center;">
  Please close the browser window to log out.
</h3>
<hr />
<h3>
	Your responses
</h3>
<?php if (count((array)$this->_vars['answers'])): foreach ((array)$this->_vars['answers'] as $this->_vars['question']): ?>
	<p>
		<strong>#<?php echo $this->_vars['question']['position']; ?>
: <?php echo $this->_vars['question']['question_text']; ?>
</strong><br />
		<?php echo $this->_vars['question']['answer_text']; ?>

	</p><br />
<?php endforeach; endif; ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>