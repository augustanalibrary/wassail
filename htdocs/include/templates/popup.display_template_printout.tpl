{include file="head.popup.tpl"}
<h2 style = "text-align:center;">
      {$header}
</h2>
{if isset($questions)}
      <table class = "list">
	{counter print=false assign="counter"}
	{foreach from=$questions value=question}
	<tr class = "{if $counter is odd}odd{else}even{/if}">
	  <td style = "text-align:left;vertical-align:top;width:20px;"">
	    {$counter})
	  </td>
	  <td style = "text-align:left;vertical-align:top;width:66%;">
	    {$question.text}
	  </td>
	  <td style = "text-align:left;vertical-align:top;">
	    {if isset($question.answers)}
			{if $question.answers}
				{foreach from=$question.answers value=answer}
					[      ]   {$answer}<br />
				{/foreach}
			{else}
				<div style = "border:1px solid #ccc;width:250px;height:100px;"></div>
				{ if strlen($question.opt_out) }
					<br />
					<br />
				
					[      ]   { $question.opt_out }
				{ /if }
			{/if}
	      
	    {/if}
	  </td>
	</tr>
	{counter}
	{/foreach}
      </table>
      {/if}
<h4 style = "text-align:center;">
      {$footer}
</h4>
{include file="foot.popup.tpl"}