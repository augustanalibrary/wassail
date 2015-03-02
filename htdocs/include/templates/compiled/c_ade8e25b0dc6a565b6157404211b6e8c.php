<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-05-14 10:41:04 MDT */ ?>

    <form method = 'post' action = 'reports/'>
      <table class = "section-table">
	<tr>
	  <th>
	    Template(s)
	  </th>
	  <th>
	    Course(s)
	  </th>
	  <th>
	    Year(s)
	  </th>
	  <th style = "width:75px;">
	    Term(s)
	  </th>
	  <th style = "width:80px;">
	    Type(s)
	  </th>
	    
	  <th>
	  </th>
	</tr>
	<tr>
	  <td colspan = "3">
	    <div id = "expand-selects" style = "font-size:8pt;line-height:20px;padding-left:20px;background:transparent url(<?php echo constant('WEB_PATH'); ?>
include/templates/images/arrow_out.png) no-repeat left center;" class = "clickable">
	      Expand Template/Course/Year boxes
	    </div>
	  </td>
	</tr>
	<tr>
	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_template[]" multiple="multiple" size = "5" class = "small" id = "param_template">
	      <?php if (count((array)$this->_vars['template_list'])): foreach ((array)$this->_vars['template_list'] as $this->_vars['curr_template']): ?>
	      <option value="<?php echo $this->_vars['curr_template']['id']; ?>
" <?php if (in_array ( $this->_vars['curr_template']['id'] , $this->_vars['chosen_templates'] )): ?>selected="selected"<?php endif; ?> class = "clickable"><?php if ($this->_vars['curr_template']['id'] != 0): ?>[<?php echo $this->_vars['curr_template']['id']; ?>
]<?php endif; ?> <?php echo $this->_vars['curr_template']['name']; ?>
</option>
	    <?php endforeach; endif; ?>
	  </select>
	    <?php if (count ( $this->_vars['chosen_templates'] ) > 0): ?>
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      <?php if (count((array)$this->_vars['template_list'])): foreach ((array)$this->_vars['template_list'] as $this->_vars['curr_template']): ?>
		<?php if (in_array ( $this->_vars['curr_template']['id'] , $this->_vars['chosen_templates'] )): ?>
	      <li>
		<?php echo $this->_vars['curr_template']['name']; ?>

	      </li>
	    <?php endif; ?>
	    <?php endforeach; endif; ?>
	  </ul>
	    <?php endif; ?>
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_course[]" multiple="multiple" size = "5" class = "small" id = "param_course">
	      <?php if (count((array)$this->_vars['course_list'])): foreach ((array)$this->_vars['course_list'] as $this->_vars['curr_course']): ?>
		<option value="<?php echo $this->_vars['curr_course']['id']; ?>
" <?php if (in_array ( $this->_vars['curr_course']['id'] , $this->_vars['chosen_courses'] )): ?>selected="selected"<?php endif; ?> class = "clickable"><?php if ($this->_vars['curr_course']['id'] != 0): ?>[<?php echo $this->_vars['curr_course']['id']; ?>
]<?php endif; ?> <?php echo $this->_vars['curr_course']['number']; ?>
</option>
	    <?php endforeach; endif; ?>
	    </select>
	    <?php if (count ( $this->_vars['chosen_courses'] ) > 0): ?>
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      <?php if (count((array)$this->_vars['course_list'])): foreach ((array)$this->_vars['course_list'] as $this->_vars['curr_course']): ?>
		<?php if (in_array ( $this->_vars['curr_course']['id'] , $this->_vars['chosen_courses'] )): ?>
		<li>
		<?php echo $this->_vars['curr_course']['number']; ?>

	      </li>
	    <?php endif; ?>
	    <?php endforeach; endif; ?>
	  </ul>
	    <?php endif; ?>
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_year[]" multiple="multiple" size = "5" class = "small" id = "param_year">
	      <?php if (count((array)$this->_vars['year_list'])): foreach ((array)$this->_vars['year_list'] as $this->_vars['curr_year']): ?>
		<option value="<?php echo $this->_vars['curr_year']; ?>
" <?php if (in_array ( $this->_vars['curr_year'] , $this->_vars['chosen_years'] )): ?>selected="selected"<?php endif; ?> class = "clickable"><?php echo $this->_vars['curr_year']; ?>
</option>
	    <?php endforeach; endif; ?>
	    </select>
	    <?php if (count ( $this->_vars['chosen_years'] ) > 0): ?>
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      <?php if (count((array)$this->_vars['year_list'])): foreach ((array)$this->_vars['year_list'] as $this->_vars['curr_year']): ?>
		<?php if (in_array ( $this->_vars['curr_year'] , $this->_vars['chosen_years'] )): ?>
		<li>
		<?php echo $this->_vars['curr_year']; ?>

	      </li>
	    <?php endif; ?>
	    <?php endforeach; endif; ?>
	  </ul>
	    <?php endif; ?>
	  </td>


	  <td class = "small" style = "vertical-align:top;">
	  	<input 	type = "checkbox" 
				name = "param_term[]"
				id = "param_term_2"
				value = "2" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 2 , $this->_vars['chosen_terms'] )): ?>checked="checked"<?php endif; ?> id = "term_2" />
		<label for="param_term_2" class = "clickable" style = "vertical-align:middle;">Fall</label>
		<br />
		<input 	type = "checkbox" 
				name = "param_term[]"
				id = "param_term_3"
				value = "3" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 3 , $this->_vars['chosen_terms'] )): ?>checked="checked"<?php endif; ?> id = "term_3" />
		<label for="param_term_3" class = "clickable" style = "vertical-align:middle;">Winter</label>
		<br />
		<input 	type = "checkbox" 
				name = "param_term[]"
				id = "param_term_0"
				value = "0" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 0 , $this->_vars['chosen_terms'] )): ?>checked="checked"<?php endif; ?> id = "term_0" />
		<label for="param_term_0" class = "clickable" style = "vertical-align:middle;">Spring</label>
		<br />
		<input 	type = "checkbox" 
				name = "param_term[]"
				id = "param_term_1"
				value = "1" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 1 , $this->_vars['chosen_terms'] )): ?>checked="checked"<?php endif; ?> id = "term_1" />
		<label for="param_term_1" class = "clickable" style = "vertical-align:middle;">Summer</label>
		<br />
	  </td>

	  <td class = "small" style = "vertical-align:top;">
	    <?php if (count((array)$this->_vars['types_list'])): foreach ((array)$this->_vars['types_list'] as $this->_vars['curr_type_id'] => $this->_vars['curr_type_text']): ?>
	    <input type = "checkbox"
	      name="param_type[]"
	      id="param_type_<?php echo $this->_vars['curr_type_id']; ?>
"
	      value = "<?php echo $this->_vars['curr_type_id']; ?>
"
	      class = "clickable radio"
	      style = "vertical-align:middle;"
	      <?php if (in_array ( $this->_vars['curr_type_id'] , $this->_vars['chosen_types'] )): ?>checked="checked"<?php endif; ?> />
	      <label for = "param_type_<?php echo $this->_vars['curr_type_id']; ?>
" class = "clickable" style = "vertical-align:middle;"><?php echo $this->_vars['curr_type_text']; ?>
</label>
	    <br />
	    <?php endforeach; endif; ?>
	  </td>
	  <td style = "vertical-align:middle;text-align:center;">
	    <input type = "submit" class = "submit" name = "set_parameters" value = "Show questions..." class = "no_print"/>
	  </td>
	</tr>
      </table>
    </form>


<script type = "text/javascript">
<?php echo '
$(document).ready(function(){
		    $("#expand-selects").toggle(
						function(){
						  $(this)
						    .css({backgroundImage:\'url(';  echo constant('WEB_PATH');  echo 'include/templates/images/arrow_in.png)\'})
						    .text(\'Shrink Template/Course/Year boxes\');
						  $("#param_template,#param_course,#param_year").attr(\'size\',30);
						},
						function(){
						  $(this)
						    .css({backgroundImage:\'url(';  echo constant('WEB_PATH');  echo 'include/templates/images/arrow_out.png)\'})
						    .text(\'Expand Template/Course/Year boxes\');
						  $("#param_template,#param_course,#param_year").attr(\'size\',5);
						}
						);
		  });
'; ?>

</script>
