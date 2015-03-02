<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-24 11:46:48 MDT */ ?>



<form method = 'post' action = 'reports/'>


<div>
<?php if (count((array)$this->_vars['chosen_templates'])): foreach ((array)$this->_vars['chosen_templates'] as $this->_vars['template_id']): ?>
      <input type = "hidden" name = "param_template[]" value = "<?php echo $this->_vars['template_id']; ?>
" />
<?php endforeach; endif;  if (count((array)$this->_vars['chosen_courses'])): foreach ((array)$this->_vars['chosen_courses'] as $this->_vars['course_id']): ?>
      <input type = "hidden" name = "param_course[]" value = "<?php echo $this->_vars['course_id']; ?>
" />
<?php endforeach; endif;  if (count((array)$this->_vars['chosen_years'])): foreach ((array)$this->_vars['chosen_years'] as $this->_vars['year']): ?>
      <input type = "hidden" name = "param_year[]" value = "<?php echo $this->_vars['year']; ?>
" />
<?php endforeach; endif;  if (count((array)$this->_vars['chosen_terms'])): foreach ((array)$this->_vars['chosen_terms'] as $this->_vars['term_id']): ?>
      <input type = "hidden" name = "param_term[]" value = "<?php echo $this->_vars['term_id']; ?>
" />
<?php endforeach; endif;  if (count((array)$this->_vars['chosen_types'])): foreach ((array)$this->_vars['chosen_types'] as $this->_vars['type_id']): ?>
      <input type = "hidden" name = "param_type[]" value = "<?php echo $this->_vars['type_id']; ?>
" />
<?php endforeach; endif; ?>
</div>
<table class = "small list">
	<tr class = "plain-header">
		<th colspan = "5">
			<input type = "submit" name = "generate-qualitative" value = "View qualitative report" class = "submit" />
		</th>
	</tr>
</table>
</form>