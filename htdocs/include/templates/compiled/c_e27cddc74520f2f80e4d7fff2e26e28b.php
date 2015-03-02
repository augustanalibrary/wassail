<?php require_once('/var/www/htdocs/include/template_lite/plugins/modifier.abs.php'); $this->register_modifier("abs", "tpl_modifier_abs");  require_once('/var/www/htdocs/include/template_lite/plugins/function.cycle.php'); $this->register_function("cycle", "tpl_function_cycle");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-30 16:28:42 MDT */ ?>

<table class = "report-table small gains-analysis">
  <?php if (count((array)$this->_vars['data'])): foreach ((array)$this->_vars['data'] as $this->_vars['question_id'] => $this->_vars['question_properties']): ?>
  <tr class = "report-question-row">
    <th class = "report-id-field">
      (<?php echo $this->_vars['question_id']; ?>
)
    </th>
    <th colspan = "4" class = "report-text-field">
      <?php echo $this->_vars['question_properties']['text']; ?>

    </th>
    <th class = "report-count-field">
      Set 1 count: <?php echo $this->_vars['question_properties']['count1']; ?>

    </th>
    <th>
    </th>
    <th>
    </th>
    <th class = "report-count-field">
      Set 2 count: <?php echo $this->_vars['question_properties']['count2']; ?>

    </th>
    <th colspan = "4">
      Difference
    </th>     
  </tr>
  <?php if (count((array)$this->_vars['question_properties']['answers'])): foreach ((array)$this->_vars['question_properties']['answers'] as $this->_vars['answer_id'] => $this->_vars['answer_properties']): ?>
  <tr class = "<?php if ($this->_vars['answer_properties']['correct']): ?>correct<?php endif; ?> <?php echo tpl_function_cycle(array('values' => "even,odd"), $this);?>">
    <td class = "report-id-field">
    </td>
    <td class = "report-id-field">
      (<?php echo $this->_vars['answer_id']; ?>
)
    </td>
    <td class = "border-right">
      <?php echo $this->_vars['answer_properties']['text']; ?>

    </td>
    <td class = "report-bar-field">
      <?php if ($this->_vars['answer_properties']['percentage1'] != 0): ?>
      <div class = "report-bar-blue" style = "width:<?php echo $this->_vars['answer_properties']['percentage1']; ?>
%;">
      </div>
      <?php endif; ?>
    </td>
    <td class = "report-percentage-field">
      <?php echo $this->_vars['answer_properties']['percentage1']; ?>
%
    </td>
    <td class = "report-count-field border-right">
      <?php echo $this->_vars['answer_properties']['count1']; ?>

    </td>
    <td class = "report-bar-field">
      <?php if ($this->_vars['answer_properties']['percentage2'] != 0): ?>
      <div class = "report-bar-blue" style = "width:<?php echo $this->_vars['answer_properties']['percentage2']; ?>
%;">
      </div>
      <?php endif; ?>
    </td>
    <td class = "report-percentage-field">
      <?php echo $this->_vars['answer_properties']['percentage2']; ?>
%
    </td>
    <td class = "report-count-field border-right">
      <?php echo $this->_vars['answer_properties']['count2']; ?>

    </td>
    <td class = "report-bar-field">
      <?php if ($this->_vars['answer_properties']['percentage_diff'] < 0): ?>
      <div class = "report-bar-red" style = "width:<?php echo $this->_run_modifier($this->_vars['answer_properties']['percentage_diff'], 'abs', 'plugin', 1); ?>
%;float:right;">
      </div>
      <?php endif; ?>
    </td>
    <td class = "report-bar-field">
      <?php if ($this->_vars['answer_properties']['percentage_diff'] > 0): ?>
      <div class = "report-bar-green" style = "width:<?php echo $this->_vars['answer_properties']['percentage_diff']; ?>
%;">
      </div>
      <?php endif; ?>
    </td>
    <td class = "report-percentage-field">
      <?php echo $this->_vars['answer_properties']['percentage_diff']; ?>
%
    </td>
    <td class = "report-count-field">
      <?php echo $this->_vars['answer_properties']['count_diff']; ?>

    </td>
  </tr>
  <?php endforeach; endif; ?>
  <?php endforeach; endif; ?>
</table>