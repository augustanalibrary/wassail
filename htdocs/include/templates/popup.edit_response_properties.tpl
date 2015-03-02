{include file="head.popup.tpl"}
<p>
	Updating properties for {$id_count} response(s)
</p>
<br />
{ if $success }
	<div class = "success">
		Properties updated.  Close this popup and reload the main window to see the changes.
	</div>
{/if}
<form method = "post" action = "">
	<table>
		<thead>
			<tr>
				<th></th>
				<th>Existing</th>
				<th>New</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th style = "text-align:right">
					Template:
				</th>
				<td>
					{$template_name}
				</td>
				<td>
					<select name = "template_id">
						{foreach from=$all_templates key=index value=Template}
							<option value = "{$Template.id}" {if $Template.id eq $template_id}selected="selected"{/if}>{$Template.name}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<td colspan = "3">
					<div class="notice">
						<small>
							Changing the template could result in <strong>lost or incomplete data</strong>.  To ensure this doesn't happen, only change the template to one with identical questions.
						</small>
					</div>
				</td>
			</tr>
			<tr>
				<th style = "text-align:right">
					Course:
				</th>
				<td>
					{$course_name}
				</td>
				<td>
					<select name = "course_id">
						{foreach from=$all_courses key=index value=Course}
							<option value = "{$Course.id}" {if $Course.id eq $course_id}selected="selected"{/if}>{$Course.name}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<th style = "text-align:right">
					Term:
				</th>
				<td>
					{$term}
				</td>
				<td>
					<select name = "term_id">
						{foreach from=$all_terms key=index value=term_name}
							<option value = "{$index}" {if $index eq $term_id}selected="selected"{/if}>{$term_name}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<th style = "text-align:right">
					Type:
				</th>
				<td>
					{$type}
				</td>
				<td>
					<select name = "type_id">
						{foreach from=$all_types key=index value=type_name}
							<option value = "{$index}" {if $index eq $type_id}selected="selected"{/if}>{$type_name}</option>
						{/foreach}
					</select>
				</td>
			</tr>
			<tr>
				<th style = "text-align:right">
					Year:
				</th>
				<td>
					{$year}
				</td>
				<td>
					<select name = "year">
						{foreach from=$years key=index value=curr_year}
							<option value = "{$curr_year}" {if $curr_year eq $year}selected="selected"{/if}>{$curr_year}</option>
						{/foreach}
					</select>
				</td>
			</tr>
		</tbody>
	</table>
	<input type = "submit" class = "submit" name = "submit" value = "Update properties" />
	<input type = "reset" class = "submit" name = "cancel" value = "Cancel" onclick = "window.close()" />
</form>
{include file="foot.popup.tpl"}