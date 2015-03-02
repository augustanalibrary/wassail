{include file="head.tpl"}
{ if $confirmation }
	{ $confirmation }
{ else }
    <h3 style = "text-align:center;">
Finished...thank you!</h3>
{ /if }
<h3 style = "text-align:center;">
  Please close the browser window to log out.
</h3>
<hr />
<h3>
	Your responses
</h3>
{ foreach from=$answers value=question }
	<p>
		<strong>#{$question.position}: { $question.question_text}</strong><br />
		{ $question.answer_text}
	</p><br />
{ /foreach }

{include file="foot.tpl"}