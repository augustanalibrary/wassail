{*  Note: this file doesn't include the header or footer because it's output is
 *    being injected into an existing page 
 *}

{if is_array($entries)}
      <table class = "list" style = "margin-left:40px;margin-bottom:20px;width:auto;">
	<tr class = "sub-header">
	  <td>
	    Course Name
	  </td>
	  <td>
	    Term
	  </td>
	  <td>
	    Type
	  </td>
	  <td>
	    Year
	  </td>
	  <td>
	    Responses
	  </td>
	</tr>
	{foreach from=$entries value=entry key=entry_index}
	<tr>
	  <td style = "vertical-align:top;text-align:left;">
	    [{ $entry.course_id }] {$entry.course_name}
	  </td>
	  <td style = "vertical-align:top;">
	    {$entry.term}
	  </td>
	  <td style = "vertical-align:top;">
	    {$entry.questionnaire_type}
	  </td>
	  <td style = "vertical-align:top;">
	    {$entry.school_year}
	  </td>
	  <td style = "text-align:right;">
	  	<img src = "include/templates/images/printer.png" title = "Print all responses" alt = "Print all responses" class = "clickable responses_print" id = "print_{ $entry.template_id }_{ $entry.course_id }_{ $entry.term_id }_{ $entry.questionnaire_type_id }_{$entry.school_year}" />
	    <img src = "include/templates/images/eye.png" alt = "Click to show responses" title = "Click to show responses" onclick = "$('#numbers-{$id}-{$entry_index}').toggle();" class = "clickable"/>
	    { if $right_write }
	    	<img src = "include/templates/images/bin.png" alt = "Click to delete responses" title = "Click to delete responses" onclick = "if(confirm('Are you sure you want to delete all the responses for this template/course/term/type/year combination?\n\nThis is not undo-able.'))deleteResponses(this,{ $entry.template_id },{ $entry.course_id },{ $entry.term_id },{ $entry.questionnaire_type_id },'{ $entry.school_year }')" class = "clickable" />
	    { /if }
	    { if $right_write_unconditional }
	    	<img src = "include/templates/images/arrow-switch.png" alt = "Click to edit properties of all responses (course, term, etc.)" title = "Click to edit properties of all responses (course, term, etc.)" class = "clickable edit_response_properties" id = "edit_response_properties{foreach from=$entry.individual key=number value=response_id}-{$response_id}{/foreach}" />
	    {/if}
	    <div id = "numbers-{$id}-{$entry_index}" style = "display:none;">
	      {foreach from=$entry.individual key=number value=response_id}
	      <div id = "response-{$response_id}" style = "vertical-align:middle;">
		{$number}
		{if $right_write}
		<img src = "include/templates/images/pencil.png" title = "Edit response..." alt = "Edit response..." id = "edit_response_{$response_id}" class = "response_edit clickable" style = "vertical-align:middle;"/>
		<img src = "include/templates/images/bin.png" title = "Delete response" alt = "Delete response" id = "delete-response-{$response_id}" class = "response_delete clickable" style = "vertical-align:middle;" />
	      
	      {/if}
	      { if $right_write_unconditional }
	    	<img src = "include/templates/images/arrow-switch.png" alt = "Click to edit properties of this response (course, term, etc.)" title = "Click to edit properties of this response (course, term, etc.)" class = "clickable edit_response_properties" style = "vertical-align:middle" id = "edit_response_properties-{$response_id}"/>
	    	{/if}
	      </div>
	      
	      {/foreach}
	    </div>
	  </td>
	  {/foreach}
      </table>
<script type = "text/javascript">
addAJAXListeners();
</script>
{/if}