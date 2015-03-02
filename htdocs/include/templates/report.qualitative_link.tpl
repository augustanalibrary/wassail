<div style = "margin:10px 0px;">
Qualitative data exists for these parameters:
<form method = 'post' action = 'reports/'>
{* Duplicate the data of the parameter form so it stays populated *}
<div style = "display:inline;">
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
<input type = "submit" name = "generate-qualitative" value = "View qualitative data" class = "submit" />
</div>
</form>
</div>
