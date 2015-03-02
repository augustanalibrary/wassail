<?php require_once('/var/www/htdocs/include/template_lite/plugins/modifier.date.php'); $this->register_modifier("date", "tpl_modifier_date");  require_once('/var/www/htdocs/include/template_lite/plugins/function.counter.php'); $this->register_function("counter", "tpl_function_counter");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-22 16:55:12 MDT */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
  if (count ( $this->_vars['list'] ) > 0): ?>
      <table class = "list" style = "margin:0;">
	<tr class = "plain-header">
	  <th>
	    ID
	  </th>
	  <th>
	    Question
	  </th>
	  <th>
	    Date Added
	  </th>
	  <th>
	    Categories
	  </th>
	  <th>
	    Tags
	  </th>
	  <th>
	    Answers
	  </th>
	</tr>
	<?php echo tpl_function_counter(array('print' => false,'assign' => "counter"), $this);?>
	<?php if (count((array)$this->_vars['list'])): foreach ((array)$this->_vars['list'] as $this->_vars['row']): ?>
	<?php echo tpl_function_counter(array(), $this);?>
	<tr class = "<?php if ((1 & $this->_vars['counter'])): ?>odd<?php else: ?>even<?php endif; ?>" style = "vertical-align:top;">
	  <td>
	    <?php echo $this->_vars['row']['id']; ?>

	  </td>
	  <td style = "text-align:left;vertical-align:top">
	    <?php echo $this->_vars['row']['text']; ?>

	  </td>
	  <td>
	    <?php echo $this->_run_modifier($this->_vars['row']['date_added'], 'date', 'plugin', 1, $this->_vars['date_format_short']); ?>

	  </td>
	  <td>
	    <?php if (isset ( $this->_vars['row']['categories'] )): ?>
	    <?php if (count((array)$this->_vars['row']['categories'])): foreach ((array)$this->_vars['row']['categories'] as $this->_vars['category_text']): ?>
	    <?php echo $this->_vars['category_text']; ?>
<br />
	    <?php endforeach; endif; ?>
	    <?php endif; ?>
	  </td>
	  <td>
	    <?php if (count ( $this->_vars['row']['tags'] ) > 0): ?>
	    <?php if (count((array)$this->_vars['row']['tags'])): foreach ((array)$this->_vars['row']['tags'] as $this->_vars['tag_text']): ?>
	    <?php echo $this->_vars['tag_text']; ?>
<br />
	    <?php endforeach; endif; ?>
	    <?php endif; ?>
	  </td>
	  <td style = "text-align:left;">
	    <?php if (( isset ( $this->_vars['row']['answers'] ) )): ?>
	    <?php if (count((array)$this->_vars['row']['answers'])): foreach ((array)$this->_vars['row']['answers'] as $this->_vars['text']): ?>
	    <?php echo $this->_vars['text']; ?>
<br />
	    <?php endforeach; endif; ?>
	    <?php endif; ?>
	  </td>
	</tr>
	<?php endforeach; endif; ?>
      </table>
<?php else: ?>
      No questions exist
<?php endif; ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>