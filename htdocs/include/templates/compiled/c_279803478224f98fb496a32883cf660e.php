<?php /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-05-12 11:46:47 MDT */ ?>

    <form method = 'post' action = '/gains/'>
      <table class = "section-table" style = "margin-left:auto;margin-right:auto;width:auto;">
	<tr>
	  <td colspan = "5" style = "border-bottom:1px solid #ccc;text-align:center;">
	    Parameter set 1
	  </td>
	  <td style = "vertical-align:middle;text-align:left;" rowspan = "6">
	    <input type = "submit" class = "submit" name = "generate" value = "Generate" />
	    <br />
	    <input type = "submit" class = "submit" name = "generate-csv" value = "Generate CSV" />
	  </td>
	</tr>
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
	</tr>
	<tr>
	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_template1[]" multiple="multiple" size = "5" class = "small">
	      <?php if (count((array)$this->_vars['template_list'])): foreach ((array)$this->_vars['template_list'] as $this->_vars['curr_template']): ?>
	      <option value="<?php echo $this->_vars['curr_template']['id']; ?>
" <?php if (in_array ( $this->_vars['curr_template']['id'] , $this->_vars['chosen_templates1'] )): ?>selected="selected"<?php endif; ?> class = "clickable"><?php if ($this->_vars['curr_template']['id'] != 0): ?>[<?php echo $this->_vars['curr_template']['id'];  endif; ?> <?php echo $this->_vars['curr_template']['name']; ?>
</option>
	    <?php endforeach; endif; ?>
	  </select>
	    <?php if (count ( $this->_vars['chosen_templates1'] ) > 0): ?>
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      <?php if (count((array)$this->_vars['template_list'])): foreach ((array)$this->_vars['template_list'] as $this->_vars['curr_template']): ?>
		<?php if (in_array ( $this->_vars['curr_template']['id'] , $this->_vars['chosen_templates1'] )): ?>
	      <li>
		(<?php echo $this->_vars['curr_template']['id']; ?>
) <?php echo $this->_vars['curr_template']['name']; ?>

	      </li>
	    <?php endif; ?>
	    <?php endforeach; endif; ?>
	  </ul>
	    <?php endif; ?>
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_course1[]" multiple="multiple" size = "5" class = "small">
	      <?php if (count((array)$this->_vars['course_list'])): foreach ((array)$this->_vars['course_list'] as $this->_vars['curr_course']): ?>
		<option value="<?php echo $this->_vars['curr_course']['id']; ?>
" <?php if (in_array ( $this->_vars['curr_course']['id'] , $this->_vars['chosen_courses1'] )): ?>selected="selected"<?php endif; ?> class = "clickable"><?php if ($this->_vars['curr_course']['id'] != 0): ?>[<?php echo $this->_vars['curr_course']['id']; ?>
]<?php endif; ?> <?php echo $this->_vars['curr_course']['number']; ?>
</option>
	    <?php endforeach; endif; ?>
	    </select>
	    <?php if (count ( $this->_vars['chosen_courses1'] ) > 0): ?>
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      <?php if (count((array)$this->_vars['course_list'])): foreach ((array)$this->_vars['course_list'] as $this->_vars['curr_course']): ?>
		<?php if (in_array ( $this->_vars['curr_course']['id'] , $this->_vars['chosen_courses1'] )): ?>
		<li>
		(<?php echo $this->_vars['curr_course']['id']; ?>
) <?php echo $this->_vars['curr_course']['number']; ?>

	      </li>
	    <?php endif; ?>
	    <?php endforeach; endif; ?>
	  </ul>
	    <?php endif; ?>
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_year1[]" multiple="multiple" size = "5" class = "small">
	      <?php if (count((array)$this->_vars['year_list'])): foreach ((array)$this->_vars['year_list'] as $this->_vars['curr_year']): ?>
		<option value="<?php echo $this->_vars['curr_year']; ?>
" <?php if (in_array ( $this->_vars['curr_year'] , $this->_vars['chosen_years1'] )): ?>selected="selected"<?php endif; ?> class = "clickable"><?php echo $this->_vars['curr_year']; ?>
</option>
	    <?php endforeach; endif; ?>
	    </select>
	    <?php if (count ( $this->_vars['chosen_years1'] ) > 0): ?>
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      <?php if (count((array)$this->_vars['year_list'])): foreach ((array)$this->_vars['year_list'] as $this->_vars['curr_year']): ?>
		<?php if (in_array ( $this->_vars['curr_year'] , $this->_vars['chosen_years1'] )): ?>
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
				name = "param_term1[]"
				id = "param_term_1_2"
				value = "2" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 2 , $this->_vars['chosen_terms1'] )): ?>checked="checked"<?php endif; ?> id = "term_2" />
		<label for="param_term_1_2" class = "clickable" style = "vertical-align:middle;">Fall</label><br />
		<input 	type = "checkbox" 
				name = "param_term1[]"
				id = "param_term_1_3"
				value = "3" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 3 , $this->_vars['chosen_terms1'] )): ?>checked="checked"<?php endif; ?> id = "term_3" />
		<label for="param_term_1_3" class = "clickable" style = "vertical-align:middle;">Winter</label><br />
		<input 	type = "checkbox" 
				name = "param_term1[]"
				id = "param_term_1_0"
				value = "0" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 0 , $this->_vars['chosen_terms1'] )): ?>checked="checked"<?php endif; ?> id = "term_0" />
		<label for="param_term_1_0" class = "clickable" style = "vertical-align:middle;">Spring</label><br />
		<input 	type = "checkbox" 
				name = "param_term1[]"
				id = "param_term_1_1"
				value = "1" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 1 , $this->_vars['chosen_terms1'] )): ?>checked="checked"<?php endif; ?> id = "term_1" />
		<label for="param_term_1_1" class = "clickable" style = "vertical-align:middle;">Summer</label>
	  </td>

	  <td class = "small" style = "vertical-align:top;">
		 <?php if (count((array)$this->_vars['types_list'])): foreach ((array)$this->_vars['types_list'] as $this->_vars['curr_type_id'] => $this->_vars['curr_type_text']): ?>
			<?php if ($this->_vars['curr_type_text'] != 'One shot' && $this->_vars['curr_type_text'] != 'Survey'): ?>
				<input type = "checkbox"
				  name="param_type1[]"
				  id="param_type_1_<?php echo $this->_vars['curr_type_id']; ?>
"
				  value = "<?php echo $this->_vars['curr_type_id']; ?>
"
				  class = "clickable radio"
				  style = "vertical-align:middle;"
				  <?php if ($this->_vars['curr_type_text'] == 'Pre-test'): ?>checked="checked"<?php endif; ?>/><label for = "param_type_1_<?php echo $this->_vars['curr_type_id']; ?>
" class = "clickable" style = "vertical-align:middle;"><?php echo $this->_vars['curr_type_text']; ?>
</label>
				<br />
			<?php endif; ?>
	    <?php endforeach; endif; ?>
	  </td>
	</tr>
	<tr>
	  <td colspan = "5" style = "border-bottom:1px solid #ccc;padding-top:20px;text-align:center;">
	    Parameter set 2
	  </td>
	</tr>
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
	</tr>
	<tr>
	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_template2[]" multiple="multiple" size = "5" class = "small">
	      <?php if (count((array)$this->_vars['template_list'])): foreach ((array)$this->_vars['template_list'] as $this->_vars['curr_template']): ?>
	      <option value="<?php echo $this->_vars['curr_template']['id']; ?>
" <?php if (in_array ( $this->_vars['curr_template']['id'] , $this->_vars['chosen_templates2'] )): ?>selected="selected"<?php endif; ?> class = "clickable"><?php if ($this->_vars['curr_template']['id'] != 0): ?>[<?php echo $this->_vars['curr_template']['id'];  endif; ?> <?php echo $this->_vars['curr_template']['name']; ?>
</option>
	    <?php endforeach; endif; ?>
	  </select>
	    <?php if (count ( $this->_vars['chosen_templates2'] ) > 0): ?>
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      <?php if (count((array)$this->_vars['template_list'])): foreach ((array)$this->_vars['template_list'] as $this->_vars['curr_template']): ?>
		<?php if (in_array ( $this->_vars['curr_template']['id'] , $this->_vars['chosen_templates2'] )): ?>
	      <li>
		(<?php echo $this->_vars['curr_template']['id']; ?>
) <?php echo $this->_vars['curr_template']['name']; ?>

	      </li>
	    <?php endif; ?>
	    <?php endforeach; endif; ?>
	  </ul>
	    <?php endif; ?>
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_course2[]" multiple="multiple" size = "5" class = "small">
	      <?php if (count((array)$this->_vars['course_list'])): foreach ((array)$this->_vars['course_list'] as $this->_vars['curr_course']): ?>
		<option value="<?php echo $this->_vars['curr_course']['id']; ?>
" <?php if (in_array ( $this->_vars['curr_course']['id'] , $this->_vars['chosen_courses2'] )): ?>selected="selected"<?php endif; ?> class = "clickable"><?php if ($this->_vars['curr_course']['id'] != 0): ?>[<?php echo $this->_vars['curr_course']['id']; ?>
]<?php endif; ?> <?php echo $this->_vars['curr_course']['number']; ?>
</option>
	    <?php endforeach; endif; ?>
	    </select>
	    <?php if (count ( $this->_vars['chosen_courses2'] ) > 0): ?>
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      <?php if (count((array)$this->_vars['course_list'])): foreach ((array)$this->_vars['course_list'] as $this->_vars['curr_course']): ?>
		<?php if (in_array ( $this->_vars['curr_course']['id'] , $this->_vars['chosen_courses2'] )): ?>
		<li>
		(<?php echo $this->_vars['curr_course']['id']; ?>
) <?php echo $this->_vars['curr_course']['number']; ?>

	      </li>
	    <?php endif; ?>
	    <?php endforeach; endif; ?>
	  </ul>
	    <?php endif; ?>
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_year2[]" multiple="multiple" size = "5" class = "small">
	      <?php if (count((array)$this->_vars['year_list'])): foreach ((array)$this->_vars['year_list'] as $this->_vars['curr_year']): ?>
		<option value="<?php echo $this->_vars['curr_year']; ?>
" <?php if (in_array ( $this->_vars['curr_year'] , $this->_vars['chosen_years2'] )): ?>selected="selected"<?php endif; ?> class = "clickable"><?php echo $this->_vars['curr_year']; ?>
</option>
	    <?php endforeach; endif; ?>
	    </select>
	    <?php if (count ( $this->_vars['chosen_years2'] ) > 0): ?>
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      <?php if (count((array)$this->_vars['year_list'])): foreach ((array)$this->_vars['year_list'] as $this->_vars['curr_year']): ?>
		<?php if (in_array ( $this->_vars['curr_year'] , $this->_vars['chosen_years2'] )): ?>
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
				name = "param_term2[]"
				id = "param_term_2_2"
				value = "2" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 2 , $this->_vars['chosen_terms2'] )): ?>checked="checked"<?php endif; ?> id = "term_2" />
		<label for="param_term_2_2" class = "clickable" style = "vertical-align:middle;">Fall</label><br />
		<input 	type = "checkbox" 
				name = "param_term2[]"
				id = "param_term_2_3"
				value = "3" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 3 , $this->_vars['chosen_terms2'] )): ?>checked="checked"<?php endif; ?> id = "term_3" />
		<label for="param_term_2_3" class = "clickable" style = "vertical-align:middle;">Winter</label><br />
		<input 	type = "checkbox" 
				name = "param_term2[]"
				id = "param_term_2_0"
				value = "0" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 0 , $this->_vars['chosen_terms2'] )): ?>checked="checked"<?php endif; ?> id = "term_0" />
		<label for="param_term_2_0" class = "clickable" style = "vertical-align:middle;">Spring</label><br />
		<input 	type = "checkbox" 
				name = "param_term2[]"
				id = "param_term_2_1"
				value = "1" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				<?php if (in_array ( 1 , $this->_vars['chosen_terms2'] )): ?>checked="checked"<?php endif; ?> id = "term_1" />
		<label for="param_term_2_1" class = "clickable" style = "vertical-align:middle;">Summer</label>
	  </td>

	  <td class = "small" style = "vertical-align:top;">
	    <?php if (count((array)$this->_vars['types_list'])): foreach ((array)$this->_vars['types_list'] as $this->_vars['curr_type_id'] => $this->_vars['curr_type_text']): ?>
			<?php if ($this->_vars['curr_type_text'] != 'One shot' && $this->_vars['curr_type_text'] != 'Survey'): ?>
				<input type = "checkbox"
				  name="param_type2[]"
				  id="param_type_2_<?php echo $this->_vars['curr_type_id']; ?>
"
				  value = "<?php echo $this->_vars['curr_type_id']; ?>
"
				  class = "clickable radio"
				  style = "vertical-align:middle;"
				  <?php if ($this->_vars['curr_type_text'] == 'Post-test'): ?>checked="checked"<?php endif; ?> /><label for = "param_type_2_<?php echo $this->_vars['curr_type_id']; ?>
" class = "clickable" style = "vertical-align:middle;"><?php echo $this->_vars['curr_type_text']; ?>
</label>
				<br />
			<?php endif; ?>
	    <?php endforeach; endif; ?>
	  </td>
	</tr>
      </table>
    </form>