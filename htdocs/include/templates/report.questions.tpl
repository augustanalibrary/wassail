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

    {counter start=0 print=false assign="counter"}
      <table class = "small list">
	<tr class = "plain-header">
	  <th colspan = "5">
	    { if isset($qualitative_exists) }
	      <input type = "submit" name = "generate-qualitative" value = "View qualitative report" class = "submit" />
	      <input type = "submit" name = "generate-with-qualitative" value = "View quantitative and qualitative report" class = "submit" />
	    { /if }
	    <input type = "submit" class = "submit" name = "generate" value = "View quantitative report" />
	    <input type = "submit" class = "submit" name = "generate-csv" value = "View CSV of quantitative data" />
	  </th>
	</tr>
	{foreach from=$questions value=question}

	{* Show the header row every 25 questions *}
	{if ($counter mod 25) eq 0}
	<tr class = "plain-header">
	  <th style = "width:40px;">
	    ID
	  </th>
	  <th style = "width:50%;">
	    Question
	  </th>
	  <th>
	    Answers
	  </th>
	  <th style = "width:70px;">
	    Show<br />
	    <small>
	      <label for = "show-all-{$counter}" class = "clickable">
		All
		<input type = "checkbox" class = "show-all radio clickable" style = "vertical-align:middle;" id = "show-all-{$counter}"/>
	      </label>
	    </small>
	  </th>
	  <th style = "width:70px;">
	    Ignore
	  </th>
	</tr>
	{/if}
	{counter}


	{* Show the question *}
	<tr class = "{if $counter is odd}odd{else}even{/if}" style = "border-bottom:2px solid #777;">
	  <td style = "vertical-align:top;text-align:center;">
	    {* This input is used for easier parsing through $_POST when this form is handled *}
	    <input type = "hidden" name = "questions[]" value = "{$question.id}" />
	    {$question.id}
	  </td>
	  <td style = "vertical-align:top;text-align:left;">
	    {$question.text}
	  </td>
	  <td style = "vertical-align:top;text-align:left;">
	    {foreach from=$question.answers key=answer_id value=answer_text}
	      <input type = "checkbox" name = "required_{$question.id}[]" value = "{$answer_id}" id = "qa_{$question.id}_{$answer_id}" style = "vertical-align:middle;float:left;" class = "radio answer answer_{$question.id}" onclick = "cleanBoxes({$question.id},'answer');" />
	    <label for = "qa_{$question.id}_{$answer_id}" class = "clickable" style = "margin-left:0px;">
	      {$answer_text}
	    </label>
<div style = "clear:both;height:0.2em;"></div>
	    {/foreach}
	  </td>
	  <td style = "vertical-align:middle;text-align:center;border-left:1px solid #aaa;">
	    <input type = "checkbox" name = "show[]" class = "radio show show_{$question.id}" value = "{$question.id}" onclick = "cleanBoxes({$question.id},'show');"/>
	  </td>
	  <td style = "vertical-align:middle;text-align:center;">
	    <input type = "checkbox" name = "ignore[]" value = "{$question.id}" class = "radio ignore ignore_{$question.id}" onclick = "cleanBoxes({$question.id},'ignore');"/>
	  </td>
	</tr>
	{/foreach}
	<tr class = "plain-header">
	  <th colspan = "5">
	    { if isset($qualitative_exists) }
	      <input type = "submit" name = "generate-qualitative" value = "View qualitative report" class = "submit" />
	      <input type = "submit" name = "generate-with-qualitative" value = "View quantitative and qualitative report" class = "submit" />
	    { /if }
	    <input type = "submit" class = "submit" name = "generate" value = "View quantitative report" />
	    <input type = "submit" class = "submit" name = "generate-csv" value = "View CSV of quantitative data" />
	  </th>
	</tr>
      </table>
      </form>
<script type = "text/javascript">
{literal}
$(".show-all").click(function(){
		       if($(this).attr('checked'))
		       {
			 $(".show").attr('checked',true);
			 $(".answer").attr('checked',false);
		       }
		       else
			 $(".show").attr('checked',false);
		     });

/* This function makes sure all the checkboxes for a single question make sense 
 * 'from' (valued either 'answer','show', or 'ignore') describes which was intentionally checked.  
 * This prevents desired checkboxes from being unchecked,
 */
function cleanBoxes(id,from)
{
  /* If it wasn't the show button clicked, uncheck it */
  if(from != 'show')
    $(".show_"+id).attr('checked',false);

  /* If it wasn't the ignore button clicked, uncheck it */
  if(from != 'ignore')
    $(".ignore_"+id).attr('checked',false);

  /* If it wasn't an answer button clicked, uncheck them
   * Note that multiple checkboxes have the same class - this allows them to act like checkboxes
   * respective to each other, but like radio button respective to the show & ignore boxes
   */
  if(from != 'answer')
    $(".answer_"+id).attr('checked',false);
}
 
{/literal}
</script>
