<?php require_once('/var/www/htdocs/include/template_lite/plugins/function.counter.php'); $this->register_function("counter", "tpl_function_counter");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-04-20 14:20:32 MDT */ ?>

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

    <?php echo tpl_function_counter(array('start' => 0,'print' => false,'assign' => "counter"), $this);?>
      <table class = "small list">
	<tr class = "plain-header">
	  <th colspan = "5">
	    <?php if (isset ( $this->_vars['qualitative_exists'] )): ?>
	      <input type = "submit" name = "generate-qualitative" value = "View qualitative report" class = "submit" />
	      <input type = "submit" name = "generate-with-qualitative" value = "View quantitative and qualitative report" class = "submit" />
	    <?php endif; ?>
	    <input type = "submit" class = "submit" name = "generate" value = "View quantitative report" />
	    <input type = "submit" class = "submit" name = "generate-csv" value = "View CSV of quantitative data" />
	  </th>
	</tr>
	<?php if (count((array)$this->_vars['questions'])): foreach ((array)$this->_vars['questions'] as $this->_vars['question']): ?>

	
	<?php if (( $this->_vars['counter'] % 25 ) == 0): ?>
	<tr class = "plain-header">
	  <th style = "width:40px;">
	    ID
	  </th>
	  <th style = "width:50%;">
	    Question
	  </th>
	  <th>
	    Answers
	  </th>
	  <th style = "width:70px;">
	    Show<br />
	    <small>
	      <label for = "show-all-<?php echo $this->_vars['counter']; ?>
" class = "clickable">
		All
		<input type = "checkbox" class = "show-all radio clickable" style = "vertical-align:middle;" id = "show-all-<?php echo $this->_vars['counter']; ?>
"/>
	      </label>
	    </small>
	  </th>
	  <th style = "width:70px;">
	    Ignore
	  </th>
	</tr>
	<?php endif; ?>
	<?php echo tpl_function_counter(array(), $this);?>


	
	<tr class = "<?php if ((1 & $this->_vars['counter'])): ?>odd<?php else: ?>even<?php endif; ?>" style = "border-bottom:2px solid #777;">
	  <td style = "vertical-align:top;text-align:center;">
	    
	    <input type = "hidden" name = "questions[]" value = "<?php echo $this->_vars['question']['id']; ?>
" />
	    <?php echo $this->_vars['question']['id']; ?>

	  </td>
	  <td style = "vertical-align:top;text-align:left;">
	    <?php echo $this->_vars['question']['text']; ?>

	  </td>
	  <td style = "vertical-align:top;text-align:left;">
	    <?php if (count((array)$this->_vars['question']['answers'])): foreach ((array)$this->_vars['question']['answers'] as $this->_vars['answer_id'] => $this->_vars['answer_text']): ?>
	      <input type = "checkbox" name = "required_<?php echo $this->_vars['question']['id']; ?>
[]" value = "<?php echo $this->_vars['answer_id']; ?>
" id = "qa_<?php echo $this->_vars['question']['id']; ?>
_<?php echo $this->_vars['answer_id']; ?>
" style = "vertical-align:middle;float:left;" class = "radio answer answer_<?php echo $this->_vars['question']['id']; ?>
" onclick = "cleanBoxes(<?php echo $this->_vars['question']['id']; ?>
,'answer');" />
	    <label for = "qa_<?php echo $this->_vars['question']['id']; ?>
_<?php echo $this->_vars['answer_id']; ?>
" class = "clickable" style = "margin-left:0px;">
	      <?php echo $this->_vars['answer_text']; ?>

	    </label>
<div style = "clear:both;height:0.2em;"></div>
	    <?php endforeach; endif; ?>
	  </td>
	  <td style = "vertical-align:middle;text-align:center;border-left:1px solid #aaa;">
	    <input type = "checkbox" name = "show[]" class = "radio show show_<?php echo $this->_vars['question']['id']; ?>
" value = "<?php echo $this->_vars['question']['id']; ?>
" onclick = "cleanBoxes(<?php echo $this->_vars['question']['id']; ?>
,'show');"/>
	  </td>
	  <td style = "vertical-align:middle;text-align:center;">
	    <input type = "checkbox" name = "ignore[]" value = "<?php echo $this->_vars['question']['id']; ?>
" class = "radio ignore ignore_<?php echo $this->_vars['question']['id']; ?>
" onclick = "cleanBoxes(<?php echo $this->_vars['question']['id']; ?>
,'ignore');"/>
	  </td>
	</tr>
	<?php endforeach; endif; ?>
	<tr class = "plain-header">
	  <th colspan = "5">
	    <?php if (isset ( $this->_vars['qualitative_exists'] )): ?>
	      <input type = "submit" name = "generate-qualitative" value = "View qualitative report" class = "submit" />
	      <input type = "submit" name = "generate-with-qualitative" value = "View quantitative and qualitative report" class = "submit" />
	    <?php endif; ?>
	    <input type = "submit" class = "submit" name = "generate" value = "View quantitative report" />
	    <input type = "submit" class = "submit" name = "generate-csv" value = "View CSV of quantitative data" />
	  </th>
	</tr>
      </table>
      </form>
<script type = "text/javascript">
<?php echo '
$(".show-all").click(function(){
		       if($(this).attr(\'checked\'))
		       {
			 $(".show").attr(\'checked\',true);
			 $(".answer").attr(\'checked\',false);
		       }
		       else
			 $(".show").attr(\'checked\',false);
		     });

/* This function makes sure all the checkboxes for a single question make sense 
 * \'from\' (valued either \'answer\',\'show\', or \'ignore\') describes which was intentionally checked.  
 * This prevents desired checkboxes from being unchecked,
 */
function cleanBoxes(id,from)
{
  /* If it wasn\'t the show button clicked, uncheck it */
  if(from != \'show\')
    $(".show_"+id).attr(\'checked\',false);

  /* If it wasn\'t the ignore button clicked, uncheck it */
  if(from != \'ignore\')
    $(".ignore_"+id).attr(\'checked\',false);

  /* If it wasn\'t an answer button clicked, uncheck them
   * Note that multiple checkboxes have the same class - this allows them to act like checkboxes
   * respective to each other, but like radio button respective to the show & ignore boxes
   */
  if(from != \'answer\')
    $(".answer_"+id).attr(\'checked\',false);
}
 
'; ?>

</script>
