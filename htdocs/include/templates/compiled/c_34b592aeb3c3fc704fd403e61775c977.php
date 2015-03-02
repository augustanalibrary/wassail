<?php require_once('/var/www/htdocs/include/template_lite/plugins/modifier.count_characters.php'); $this->register_modifier("count_characters", "tpl_modifier_count_characters");  require_once('/var/www/htdocs/include/template_lite/plugins/function.cycle.php'); $this->register_function("cycle", "tpl_function_cycle");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-05-14 13:05:20 MDT */ ?>


      <?php if ($this->_vars['required'] && count ( $this->_vars['required'] ) > 0): ?>
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
    <?php endif; ?>

    <br />


    <table class = "report-table small">
	<?php if (count((array)$this->_vars['data'])): foreach ((array)$this->_vars['data'] as $this->_vars['question_id'] => $this->_vars['question_properties']): ?>
	<tr class = "report-question-row">
	  <th class = "report-id-field">
	    (<?php echo $this->_vars['question_id']; ?>
)
	  </th>
	  <th colspan = "<?php if (isset ( $this->_vars['question_properties']['qualitative'] )): ?>5<?php else: ?>3<?php endif; ?>" class = "report-text-field">
  	    <?php echo $this->_vars['question_properties']['question_text']; ?>

	  </th>
	  <?php if (isset ( $this->_vars['question_properties']['quantitative'] )): ?>
	<th colspan = "2" class = "report-count-field">
	  Responders: <?php echo $this->_vars['responders']; ?>
<br />
	  Responses: <?php echo $this->_vars['question_properties']['count']; ?>

	  </th>
	<?php endif; ?>
	</tr>
      
      <?php if (count((array)$this->_vars['question_properties']['answers'])): foreach ((array)$this->_vars['question_properties']['answers'] as $this->_vars['answer_id'] => $this->_vars['answer_properties']): ?>
      <tr class = "<?php echo tpl_function_cycle(array('values' => "even,odd"), $this);?> <?php if (isset ( $this->_vars['question_properties']['quantitative'] ) && isset ( $this->_vars['answer_properties']['correct'] ) && $this->_vars['answer_properties']['correct']): ?>correct<?php endif; ?>">
	<td class = "report-id-field">
		(<?php echo $this->_vars['answer_id']; ?>
)
	</td>
	<td <?php if (isset ( $this->_vars['question_properties']['qualitative'] )): ?>colspan = "5"<?php endif; ?>>

	  <?php if (isset ( $this->_vars['question_properties']['qualitative'] )): ?>
		<?php if ($this->_vars['answer_properties'] == '0'): ?>
			<?php if ($this->_run_modifier($this->_vars['question_properties']['opt_out'], 'count_characters', 'plugin', 1, true) > 0): ?>
				<?php echo $this->_vars['question_properties']['opt_out']; ?>

			<?php else: ?>
				-
			<?php endif; ?>
		<?php else: ?>
		   <?php echo $this->_vars['answer_properties']; ?>
 
		<?php endif; ?> 
	  <?php else: ?>
	    <?php echo $this->_vars['answer_properties']['text']; ?>

	  <?php endif; ?>
	</td>
	<?php if (isset ( $this->_vars['question_properties']['quantitative'] )): ?>
	<td class = "report-bar-field">
	  <?php if ($this->_vars['answer_properties']['percentage'] != 0): ?>
	  <div class = "report-bar-blue" style = "width:<?php echo $this->_vars['answer_properties']['percentage']; ?>
%;">
	  </div>
	  <?php endif; ?>
	</td>
	<td class = "report-percentage-field">
	  <?php echo $this->_vars['answer_properties']['percentage']; ?>
%
	</td>
	<td class = "report-count-field">
	  <?php echo $this->_vars['answer_properties']['count']; ?>

	  </td>
	<?php endif; ?>
      </tr>
      <?php endforeach; endif; ?>
      <?php endforeach; endif; ?>
    </table>
