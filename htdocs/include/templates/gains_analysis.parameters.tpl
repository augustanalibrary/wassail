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
	      {foreach from=$template_list value=curr_template}
	      <option value="{$curr_template.id}" {if in_array($curr_template.id,$chosen_templates1)}selected="selected"{/if} class = "clickable">{if $curr_template.id != 0}[{$curr_template.id}{/if} {$curr_template.name}</option>
	    {/foreach}
	  </select>
	    {if count($chosen_templates1) gt 0}
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      {foreach from=$template_list value=curr_template}
		{if in_array($curr_template.id,$chosen_templates1)}
	      <li>
		({$curr_template.id}) {$curr_template.name}
	      </li>
	    {/if}
	    {/foreach}
	  </ul>
	    {/if}
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_course1[]" multiple="multiple" size = "5" class = "small">
	      {foreach from=$course_list value=curr_course}
		<option value="{$curr_course.id}" {if in_array($curr_course.id,$chosen_courses1)}selected="selected"{/if} class = "clickable">{if $curr_course.id != 0}[{$curr_course.id}]{/if} {$curr_course.number}</option>
	    {/foreach}
	    </select>
	    {if count($chosen_courses1) gt 0}
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      {foreach from=$course_list value=curr_course}
		{if in_array($curr_course.id,$chosen_courses1)}
		<li>
		({$curr_course.id}) {$curr_course.number}
	      </li>
	    {/if}
	    {/foreach}
	  </ul>
	    {/if}
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_year1[]" multiple="multiple" size = "5" class = "small">
	      {foreach from=$year_list value=curr_year}
		<option value="{$curr_year}" {if in_array($curr_year,$chosen_years1)}selected="selected"{/if} class = "clickable">{$curr_year}</option>
	    {/foreach}
	    </select>
	    {if count($chosen_years1) gt 0}
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      {foreach from=$year_list value=curr_year}
		{if in_array($curr_year,$chosen_years1)}
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
				name = "param_term1[]"
				id = "param_term_1_2"
				value = "2" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(2,$chosen_terms1)}checked="checked"{/if} id = "term_2" />
		<label for="param_term_1_2" class = "clickable" style = "vertical-align:middle;">Fall</label><br />
		<input 	type = "checkbox" 
				name = "param_term1[]"
				id = "param_term_1_3"
				value = "3" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(3,$chosen_terms1)}checked="checked"{/if} id = "term_3" />
		<label for="param_term_1_3" class = "clickable" style = "vertical-align:middle;">Winter</label><br />
		<input 	type = "checkbox" 
				name = "param_term1[]"
				id = "param_term_1_0"
				value = "0" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(0,$chosen_terms1)}checked="checked"{/if} id = "term_0" />
		<label for="param_term_1_0" class = "clickable" style = "vertical-align:middle;">Spring</label><br />
		<input 	type = "checkbox" 
				name = "param_term1[]"
				id = "param_term_1_1"
				value = "1" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(1,$chosen_terms1)}checked="checked"{/if} id = "term_1" />
		<label for="param_term_1_1" class = "clickable" style = "vertical-align:middle;">Summer</label>
	  </td>

	  <td class = "small" style = "vertical-align:top;">
		 {foreach from=$types_list key=curr_type_id value=curr_type_text}
			{ if $curr_type_text ne 'One shot' and $curr_type_text ne 'Survey' }
				<input type = "checkbox"
				  name="param_type1[]"
				  id="param_type_1_{$curr_type_id}"
				  value = "{$curr_type_id}"
				  class = "clickable radio"
				  style = "vertical-align:middle;"
				  {if $curr_type_text eq 'Pre-test'}checked="checked"{/if}/><label for = "param_type_1_{$curr_type_id}" class = "clickable" style = "vertical-align:middle;">{$curr_type_text}</label>
				<br />
			{ /if }
	    {/foreach}
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
	      {foreach from=$template_list value=curr_template}
	      <option value="{$curr_template.id}" {if in_array($curr_template.id,$chosen_templates2)}selected="selected"{/if} class = "clickable">{if $curr_template.id != 0}[{$curr_template.id}{/if} {$curr_template.name}</option>
	    {/foreach}
	  </select>
	    {if count($chosen_templates2) gt 0}
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      {foreach from=$template_list value=curr_template}
		{if in_array($curr_template.id,$chosen_templates2)}
	      <li>
		({$curr_template.id}) {$curr_template.name}
	      </li>
	    {/if}
	    {/foreach}
	  </ul>
	    {/if}
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_course2[]" multiple="multiple" size = "5" class = "small">
	      {foreach from=$course_list value=curr_course}
		<option value="{$curr_course.id}" {if in_array($curr_course.id,$chosen_courses2)}selected="selected"{/if} class = "clickable">{if $curr_course.id != 0}[{$curr_course.id}]{/if} {$curr_course.number}</option>
	    {/foreach}
	    </select>
	    {if count($chosen_courses2) gt 0}
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      {foreach from=$course_list value=curr_course}
		{if in_array($curr_course.id,$chosen_courses2)}
		<li>
		({$curr_course.id}) {$curr_course.number}
	      </li>
	    {/if}
	    {/foreach}
	  </ul>
	    {/if}
	  </td>

	  <td style = "vertical-align:top;" class = "small">
	    <select name = "param_year2[]" multiple="multiple" size = "5" class = "small">
	      {foreach from=$year_list value=curr_year}
		<option value="{$curr_year}" {if in_array($curr_year,$chosen_years2)}selected="selected"{/if} class = "clickable">{$curr_year}</option>
	    {/foreach}
	    </select>
	    {if count($chosen_years2) gt 0}
	    <br />
	    <br />
	    <strong>
	      Chosen:
	    </strong>
	    <ul style = "list-style-type:none;margin-top:0;padding-left:20px;">
	      {foreach from=$year_list value=curr_year}
		{if in_array($curr_year,$chosen_years2)}
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
				name = "param_term2[]"
				id = "param_term_2_2"
				value = "2" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(2,$chosen_terms2)}checked="checked"{/if} id = "term_2" />
		<label for="param_term_2_2" class = "clickable" style = "vertical-align:middle;">Fall</label><br />
		<input 	type = "checkbox" 
				name = "param_term2[]"
				id = "param_term_2_3"
				value = "3" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(3,$chosen_terms2)}checked="checked"{/if} id = "term_3" />
		<label for="param_term_2_3" class = "clickable" style = "vertical-align:middle;">Winter</label><br />
		<input 	type = "checkbox" 
				name = "param_term2[]"
				id = "param_term_2_0"
				value = "0" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(0,$chosen_terms2)}checked="checked"{/if} id = "term_0" />
		<label for="param_term_2_0" class = "clickable" style = "vertical-align:middle;">Spring</label><br />
		<input 	type = "checkbox" 
				name = "param_term2[]"
				id = "param_term_2_1"
				value = "1" 
				class = "clickable radio"
				style = "vertical-align:middle;"
				{if in_array(1,$chosen_terms2)}checked="checked"{/if} id = "term_1" />
		<label for="param_term_2_1" class = "clickable" style = "vertical-align:middle;">Summer</label>
	  </td>

	  <td class = "small" style = "vertical-align:top;">
	    {foreach from=$types_list key=curr_type_id value=curr_type_text}
			{ if $curr_type_text ne 'One shot' and $curr_type_text ne 'Survey' }
				<input type = "checkbox"
				  name="param_type2[]"
				  id="param_type_2_{$curr_type_id}"
				  value = "{$curr_type_id}"
				  class = "clickable radio"
				  style = "vertical-align:middle;"
				  {if $curr_type_text eq 'Post-test'}checked="checked"{/if} /><label for = "param_type_2_{$curr_type_id}" class = "clickable" style = "vertical-align:middle;">{$curr_type_text}</label>
				<br />
			{ /if }
	    {/foreach}
	  </td>
	</tr>
      </table>
    </form>