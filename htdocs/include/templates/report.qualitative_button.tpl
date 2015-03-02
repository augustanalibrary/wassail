{* This file shows the only the "View qualitative report" button, and is only used if report parameters result in only qualitative answers *}

<form method = 'post' action = 'reports/'>

{* Duplicate the data of the parameter form so it stays populated *}
<div>
{foreach from=$chosen_templates value=template_id}
      <input type = "hidden" name = "param_template[]" value = "{$template_id}" />
{/foreach}
{foreach from=$chosen_courses value=course_id}
      <input type = "hidden" name = "param_course[]" value = "{$course_id}" />
{/foreach}
{foreach from=$chosen_years value=year}
      <input type = "hidden" name = "param_year[]" value = "{$year}" />
{/foreach}
{foreach from=$chosen_terms value=term_id}
      <input type = "hidden" name = "param_term[]" value = "{$term_id}" />
{/foreach}
{foreach from=$chosen_types value=type_id}
      <input type = "hidden" name = "param_type[]" value = "{$type_id}" />
{/foreach}
</div>
<table class = "small list">
	<tr class = "plain-header">
		<th colspan = "5">
			<input type = "submit" name = "generate-qualitative" value = "View qualitative report" class = "submit" />
		</th>
	</tr>
</table>
</form>