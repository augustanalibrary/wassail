{if isset($required) and $required and count($required) gt 0}
    <br />
    <table class = "section-table small">
      <caption>
		Required answers
      </caption>
      {foreach from=$required value=properties}
		  <tr class = "{cycle values="odd,even"}">
			<td style = "vertical-align:top;">
			  {$properties.text}
			</td>
			<td>
			  {foreach from=$properties.answers value=answer_text}
				{$answer_text}<br />
			  {/foreach}
			</td>
		  </tr>
      {/foreach}
    </table>
{/if}
{if isset($qualitative_data) and is_array($qualitative_data)}
      <br />
      <table class = "report-table small" style = "border-width:0px 1px 1px 1px;">
	{foreach from=$qualitative_data key=question_id value=properties}
		<tr class = "report-question-row">
		  <th class = "report-id-field">
			({$question_id})
		  </th>
		  <th class = "report-text-field">
			{$properties.question_text}
		  </th>
		</tr>
		{foreach from=$properties.answers key=response_id value=answer_text}
			<tr class = "{cycle values="even,odd"}" style = "padding-left:30px;">
			  <td class = "report-id-field">
			  	({$response_id})
			  </td>
			  <td>
				{ if $answer_text eq '0' }
					{ if $properties.opt_out|count_characters:true gt 0 }
						{ $properties.opt_out }
					{ else }
						-
					{ /if }
				{ else }
					{$answer_text}
				{ /if }
			  </td>
			 
		</tr>
		 {/foreach}
	{/foreach}
      </table>
{/if}