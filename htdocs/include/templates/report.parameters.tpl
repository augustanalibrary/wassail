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
	    <div id = "expand-selects" style = "font-size:8pt;line-height:20px;padding-left:20px;background:transparent url({ $templatelite.CONST.WEB_PATH }include/templates/images/arrow_out.png) no-repeat left center;" class = "clickable">
	      Expand Template/Course/Year boxes
	    </div>
	  </td>
	</tr>
	<tr>
	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_template[]" multiple="multiple" size = "5" class = "small" id = "param_template">
	      {foreach from=$template_list value=curr_template}
	      <option value="{$curr_template.id}" {if in_array($curr_template.id,$chosen_templates)}selected="selected"{/if} class = "clickable">{ if $curr_template.id != 0}[{$curr_template.id}]{/if} {$curr_template.name}</option>
	    {/foreach}
	  </select>
	    {if count($chosen_templates) gt 0}
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      {foreach from=$template_list value=curr_template}
		{if in_array($curr_template.id,$chosen_templates)}
	      <li>
		{$curr_template.name}
	      </li>
	    {/if}
	    {/foreach}
	  </ul>
	    {/if}
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_course[]" multiple="multiple" size = "5" class = "small" id = "param_course">
	      {foreach from=$course_list value=curr_course}
		<option value="{$curr_course.id}" {if in_array($curr_course.id,$chosen_courses)}selected="selected"{/if} class = "clickable">{if $curr_course.id != 0}[{$curr_course.id}]{/if} {$curr_course.number}</option>
	    {/foreach}
	    </select>
	    {if count($chosen_courses) gt 0}
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      {foreach from=$course_list value=curr_course}
		{if in_array($curr_course.id,$chosen_courses)}
		<li>
		{$curr_course.number}
	      </li>
	    {/if}
	    {/foreach}
	  </ul>
	    {/if}
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_year[]" multiple="multiple" size = "5" class = "small" id = "param_year">
	      {foreach from=$year_list value=curr_year}
		<option value="{$curr_year}" {if in_array($curr_year,$chosen_years)}selected="selected"{/if} class = "clickable">{$curr_year}</option>
	    {/foreach}
	    </select>
	    {if count($chosen_years) gt 0}
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      {foreach from=$year_list value=curr_year}
		{if in_array($curr_year,$chosen_years)}
		<li>
		{$curr_year}
	      </li>
	    {/if}
	    {/foreach}
	  </ul>
	    {/if}
	  </td>


	  <td class = "small" style = "vertical-align:top;">
	  	<input 	type = "checkbox" 
				name = "param_term[]"
				id = "param_term_2"
				value = "2" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(2,$chosen_terms)}checked="checked"{/if} id = "term_2" />
		<label for="param_term_2" class = "clickable" style = "vertical-align:middle;">Fall</label>
		<br />
		<input 	type = "checkbox" 
				name = "param_term[]"
				id = "param_term_3"
				value = "3" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(3,$chosen_terms)}checked="checked"{/if} id = "term_3" />
		<label for="param_term_3" class = "clickable" style = "vertical-align:middle;">Winter</label>
		<br />
		<input 	type = "checkbox" 
				name = "param_term[]"
				id = "param_term_0"
				value = "0" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(0,$chosen_terms)}checked="checked"{/if} id = "term_0" />
		<label for="param_term_0" class = "clickable" style = "vertical-align:middle;">Spring</label>
		<br />
		<input 	type = "checkbox" 
				name = "param_term[]"
				id = "param_term_1"
				value = "1" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(1,$chosen_terms)}checked="checked"{/if} id = "term_1" />
		<label for="param_term_1" class = "clickable" style = "vertical-align:middle;">Summer</label>
		<br />
	  </td>

	  <td class = "small" style = "vertical-align:top;">
	    {foreach from=$types_list key=curr_type_id value=curr_type_text}
	    <input type = "checkbox"
	      name="param_type[]"
	      id="param_type_{$curr_type_id}"
	      value = "{$curr_type_id}"
	      class = "clickable radio"
	      style = "vertical-align:middle;"
	      {if in_array($curr_type_id,$chosen_types)}checked="checked"{/if} />
	      <label for = "param_type_{$curr_type_id}" class = "clickable" style = "vertical-align:middle;">{$curr_type_text}</label>
	    <br />
	    {/foreach}
	  </td>
	  <td style = "vertical-align:middle;text-align:center;">
	    <input type = "submit" class = "submit" name = "set_parameters" value = "Show questions..." class = "no_print"/>
	  </td>
	</tr>
      </table>
    </form>


<script type = "text/javascript">
{literal}
$(document).ready(function(){
		    $("#expand-selects").toggle(
						function(){
						  $(this)
						    .css({backgroundImage:'url({ /literal }{ $templatelite.CONST.WEB_PATH }{ literal }include/templates/images/arrow_in.png)'})
						    .text('Shrink Template/Course/Year boxes');
						  $("#param_template,#param_course,#param_year").attr('size',30);
						},
						function(){
						  $(this)
						    .css({backgroundImage:'url({ /literal }{ $templatelite.CONST.WEB_PATH }{ literal }include/templates/images/arrow_out.png)'})
						    .text('Expand Template/Course/Year boxes');
						  $("#param_template,#param_course,#param_year").attr('size',5);
						}
						);
		  });
{/literal}
</script>
