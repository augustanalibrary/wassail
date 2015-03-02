{* Required questions *}
      {if $required and count($required) gt 0}
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

    <br />


    <table class = "report-table small">
	{foreach from=$data key=question_id value=question_properties}
	<tr class = "report-question-row">
	  <th class = "report-id-field">
	    ({$question_id})
	  </th>
	  <th colspan = "{if isset($question_properties.qualitative)}5{else}3{/if}" class = "report-text-field">
  	    {$question_properties.question_text}
	  </th>
	  {if isset($question_properties.quantitative)}
	<th colspan = "2" class = "report-count-field">
	  Responders: {$responders}<br />
	  Responses: {$question_properties.count}
	  </th>
	{ /if }
	</tr>
      {* Looping through the answers *}
      {foreach from=$question_properties.answers key=answer_id value=answer_properties}
      <tr class = "{cycle values="even,odd"} {if isset($question_properties.quantitative) and isset($answer_properties.correct) and $answer_properties.correct}correct{/if}">
	<td class = "report-id-field">
		({$answer_id})
	</td>
	<td {if isset($question_properties.qualitative)}colspan = "5"{ /if }>

	  { if isset($question_properties.qualitative) }
		{ if $answer_properties eq '0' }
			{ if $question_properties.opt_out|count_characters:true gt 0 }
				{ $question_properties.opt_out }
			{ else }
				-
			{ /if }
		{ else }
		   {$answer_properties} 
		{ /if } 
	  { else}
	    {$answer_properties.text}
	  { /if }
	</td>
	{ if isset($question_properties.quantitative) }
	<td class = "report-bar-field">
	  {if $answer_properties.percentage neq 0}
	  <div class = "report-bar-blue" style = "width:{$answer_properties.percentage}%;">
	  </div>
	  {/if}
	</td>
	<td class = "report-percentage-field">
	  {$answer_properties.percentage}%
	</td>
	<td class = "report-count-field">
	  {$answer_properties.count}
	  </td>
	{ /if }
      </tr>
      {/foreach}
      {/foreach}
    </table>
