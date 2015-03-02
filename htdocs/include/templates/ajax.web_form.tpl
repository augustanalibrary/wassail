{if count($forms)}
	<ul>
		{foreach from=$forms value=form}
			<li>
				<a href = "#" class = "edit-web-form" rel = "{$form.id}">{if strlen($form.name)}{$form.name}{else}{$form.id}{/if}</a>
			</li>
		{/foreach}
	</ul>
{else}
	No web forms have been generated for this template.
{/if}