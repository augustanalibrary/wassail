<?php require_once('/var/www/htdocs/include/template_lite/plugins/modifier.count_characters.php'); $this->register_modifier("count_characters", "tpl_modifier_count_characters");  require_once('/var/www/htdocs/include/template_lite/plugins/function.cycle.php'); $this->register_function("cycle", "tpl_function_cycle");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-24 11:58:58 MDT */ ?>

<?php if (isset ( $this->_vars['required'] ) && $this->_vars['required'] && count ( $this->_vars['required'] ) > 0): ?>
    <br />
    <table class = "section-table small">
      <caption>
		Required answers
      </caption>
      <?php if (count((array)$this->_vars['required'])): foreach ((array)$this->_vars['required'] as $this->_vars['properties']): ?>
		  <tr class = "<?php echo tpl_function_cycle(array('values' => "odd,even"), $this);?>">
			<td style = "vertical-align:top;">
			  <?php echo $this->_vars['properties']['text']; ?>

			</td>
			<td>
			  <?php if (count((array)$this->_vars['properties']['answers'])): foreach ((array)$this->_vars['properties']['answers'] as $this->_vars['answer_text']): ?>
				<?php echo $this->_vars['answer_text']; ?>
<br />
			  <?php endforeach; endif; ?>
			</td>
		  </tr>
      <?php endforeach; endif; ?>
    </table>
<?php endif;  if (isset ( $this->_vars['qualitative_data'] ) && is_array ( $this->_vars['qualitative_data'] )): ?>
      <br />
      <table class = "report-table small" style = "border-width:0px 1px 1px 1px;">
	<?php if (count((array)$this->_vars['qualitative_data'])): foreach ((array)$this->_vars['qualitative_data'] as $this->_vars['question_id'] => $this->_vars['properties']): ?>
		<tr class = "report-question-row">
		  <th class = "report-id-field">
			(<?php echo $this->_vars['question_id']; ?>
)
		  </th>
		  <th class = "report-text-field">
			<?php echo $this->_vars['properties']['question_text']; ?>

		  </th>
		</tr>
		<?php if (count((array)$this->_vars['properties']['answers'])): foreach ((array)$this->_vars['properties']['answers'] as $this->_vars['response_id'] => $this->_vars['answer_text']): ?>
			<tr class = "<?php echo tpl_function_cycle(array('values' => "even,odd"), $this);?>" style = "padding-left:30px;">
			  <td class = "report-id-field">
			  	(<?php echo $this->_vars['response_id']; ?>
)
			  </td>
			  <td>
				<?php if ($this->_vars['answer_text'] == '0'): ?>
					<?php if ($this->_run_modifier($this->_vars['properties']['opt_out'], 'count_characters', 'plugin', 1, true) > 0): ?>
						<?php echo $this->_vars['properties']['opt_out']; ?>

					<?php else: ?>
						-
					<?php endif; ?>
				<?php else: ?>
					<?php echo $this->_vars['answer_text']; ?>

				<?php endif; ?>
			  </td>
			 
		</tr>
		 <?php endforeach; endif; ?>
	<?php endforeach; endif; ?>
      </table>
<?php endif; ?>