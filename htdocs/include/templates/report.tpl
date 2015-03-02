{include file = "head.tpl"}

{if isset($success)}
      <div class = "{if $success}success{else}error{/if}">
	{$message}
      </div>
{/if}

{include file = "report.parameters.tpl"}
<br />
{ if isset($single_template) }
	<p class = "notice">
		{if $single_template}
			Questions are sorted in the order they appear in the template chosen.
		{else}
			Questions are sorted by question id because multiple templates were used to generate the data.
		{/if}
	</p>
{ /if }

{if isset($questions)}
      {include file = "report.questions.tpl"}
{elseif isset($data)}
      {include file = "report.data.tpl"}
{elseif isset($qualitative_data)}
      {include file="report.qualitative.tpl"}
{* If no quantitative questions exist, but qualitative data does, show only the button to run the qualitatve report *}
{elseif isset($qualitative_exists)}
	{include file="report.qualitative_button.tpl"}
{/if}
{include file="foot.tpl"}	    