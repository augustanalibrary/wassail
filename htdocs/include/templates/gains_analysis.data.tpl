<table class = "report-table small gains-analysis">
  {foreach from=$data key=question_id value=question_properties}
  <tr class = "report-question-row">
    <th class = "report-id-field">
      ({$question_id})
    </th>
    <th colspan = "4" class = "report-text-field">
      {$question_properties.text}
    </th>
    <th class = "report-count-field">
      Set 1 count: {$question_properties.count1}
    </th>
    <th>
    </th>
    <th>
    </th>
    <th class = "report-count-field">
      Set 2 count: {$question_properties.count2}
    </th>
    <th colspan = "4">
      Difference
    </th>     
  </tr>
  {foreach from=$question_properties.answers key=answer_id value=answer_properties}
  <tr class = "{if $answer_properties.correct}correct{/if} {cycle values="even,odd"}">
    <td class = "report-id-field">
    </td>
    <td class = "report-id-field">
      ({$answer_id})
    </td>
    <td class = "border-right">
      {$answer_properties.text}
    </td>
    <td class = "report-bar-field">
      {if $answer_properties.percentage1 neq 0}
      <div class = "report-bar-blue" style = "width:{$answer_properties.percentage1}%;">
      </div>
      {/if}
    </td>
    <td class = "report-percentage-field">
      {$answer_properties.percentage1}%
    </td>
    <td class = "report-count-field border-right">
      {$answer_properties.count1}
    </td>
    <td class = "report-bar-field">
      {if $answer_properties.percentage2 neq 0}
      <div class = "report-bar-blue" style = "width:{$answer_properties.percentage2}%;">
      </div>
      {/if}
    </td>
    <td class = "report-percentage-field">
      {$answer_properties.percentage2}%
    </td>
    <td class = "report-count-field border-right">
      {$answer_properties.count2}
    </td>
    <td class = "report-bar-field">
      {if $answer_properties.percentage_diff lt 0}
      <div class = "report-bar-red" style = "width:{$answer_properties.percentage_diff|abs}%;float:right;">
      </div>
      {/if}
    </td>
    <td class = "report-bar-field">
      {if $answer_properties.percentage_diff gt 0}
      <div class = "report-bar-green" style = "width:{$answer_properties.percentage_diff}%;">
      </div>
      {/if}
    </td>
    <td class = "report-percentage-field">
      {$answer_properties.percentage_diff}%
    </td>
    <td class = "report-count-field">
      {$answer_properties.count_diff}
    </td>
  </tr>
  {/foreach}
  {/foreach}
</table>