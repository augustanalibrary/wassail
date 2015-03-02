{include file="head.tpl"}

{if isset($success)}
      <div class = "{if $success}success{else}error{/if}">
	{$message}
      </div>
{/if}

{include file="gains_analysis.parameters.tpl"}

{if isset($data)}
      {if $data}
        {include file="gains_analysis.data.tpl"}
      {else}
      <div class = "error">
        Those two parameter sets have no questions in common.
      </div>
      {/if}
{/if}

{include file="foot.tpl"}