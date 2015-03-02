<?php require_once('/var/www/htdocs/include/template_lite/plugins/function.counter.php'); $this->register_function("counter", "tpl_function_counter");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-08-15 11:13:30 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<h2 style = "text-align:center;">
      <?php echo $this->_vars['header']; ?>

</h2>
<?php if (isset ( $this->_vars['questions'] )): ?>
      <table class = "list">
	<?php echo tpl_function_counter(array('print' => false,'assign' => "counter"), $this);?>
	<?php if (count((array)$this->_vars['questions'])): foreach ((array)$this->_vars['questions'] as $this->_vars['question']): ?>
	<tr class = "<?php if ((1 & $this->_vars['counter'])): ?>odd<?php else: ?>even<?php endif; ?>">
	  <td style = "text-align:left;vertical-align:top;width:20px;"">
	    <?php echo $this->_vars['counter']; ?>
)
	  </td>
	  <td style = "text-align:left;vertical-align:top;width:66%;">
	    <?php echo $this->_vars['question']['text']; ?>

	  </td>
	  <td style = "text-align:left;vertical-align:top;">
	    <?php if (isset ( $this->_vars['question']['answers'] )): ?>
			<?php if ($this->_vars['question']['answers']): ?>
				<?php if (count((array)$this->_vars['question']['answers'])): foreach ((array)$this->_vars['question']['answers'] as $this->_vars['answer']): ?>
					[      ]   <?php echo $this->_vars['answer']; ?>
<br />
				<?php endforeach; endif; ?>
			<?php else: ?>
				<div style = "border:1px solid #ccc;width:250px;height:100px;"></div>
				<?php if (strlen ( $this->_vars['question']['opt_out'] )): ?>
					<br />
					<br />
				
					[      ]   <?php echo $this->_vars['question']['opt_out']; ?>

				<?php endif; ?>
			<?php endif; ?>
	      
	    <?php endif; ?>
	  </td>
	</tr>
	<?php echo tpl_function_counter(array(), $this);?>
	<?php endforeach; endif; ?>
      </table>
      <?php endif; ?>
<h4 style = "text-align:center;">
      <?php echo $this->_vars['footer']; ?>

</h4>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>