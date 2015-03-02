{include file="head.popup.tpl"}
<div class = "notice">
Note: Click on the question to choose it.  <input type = "submit" class = "submit" onclick = "window.close()" value = "Close" /> to cancel.
</div>
<br />
{if count($list) gt 0}
      {if $order_dir == 'asc'}
        {assign var = "dir" value = "asc"}
        {assign var = "dir_other" value = "desc"}
        {assign var = "dir_arrow" value = "<img src = '/include/templates/images/arrow_down.png' alt = 'Sort descending' />"}
      {else}
        {assign var = "dir" value = "desc"}
        {assign var = "dir_other" value = "asc"}
        {assign var = "dir_arrow" value = "<img src = '/include/templates/images/arrow_up.png' alt = 'Sort ascending' />"}
      {/if}
      <table class = "list">
	<tr>
	  <th style = "width:40px;"><a href = "popup.question_list.php?return={$templatelite.GET.return}&amp;o=id&amp;d={if $order_column == 'id'}{$dir_other}{else}{$dir}{/if}">ID{if $order_column == 'id'}{$dir_arrow}{/if}</a></th>
	  <th><a href = "popup.question_list.php?return={$templatelite.GET.return}&amp;o=text&amp;d={if $order_column == 'text'}{$dir_other}{else}{$dir}{/if}">Text{if $order_column == 'text'}{$dir_arrow}{/if}</a></th>
	  <th>Categories</th>
	  <th><a href = "popup.question_list.php?return={$templatelite.GET.return}&amp;o=tags&amp;d={if $order_column == 'tags'}{$dir_other}{else}{$dir}{/if}">Tags{if $order_column == 'tags'}{$dir_arrow}{/if}</a></th>
	</tr>
	{counter print=false assign="counter"}
	{foreach from=$list key=id value=properties}
	{counter}
	<tr class = "{if $counter is odd}odd{else}even{/if} clickable question-row" style = "vertical-align:top;" id = "id_{$id}">
	  <td>
	    {$id}
	  </td>
	  <td style = "text-align:left;">
	    {$properties.text}
	  </td>
	  <td>
	    {if isset($properties.categories)}
	    {foreach from=$properties.categories value=category_text}
	    {$category_text}<br />
	    {/foreach}
	    {/if}
	  </td>
	  <td>
	    {if count($properties.tags) gt 0}
	    {foreach from=$properties.tags value=tag_text}
	    {$tag_text}<br />
	    {/foreach}
	    {/if}
	  </td>
	</tr>
	{/foreach}
      </table>
{else}
<div style = "text-align:center;">
There are no questions.  Go to the Questions page to add some.
<br />
<input type = "submit" class = "submit" value = "Close window..." onclick = "window.close();" />
</div>
{/if}

<script type = "text/javascript">
var parentWindowElement = "{$id}";

{literal}
/* Add the hovering events */
$(".question-row").hover(function(){
	$(this).addClass("hover")},
	function(){
	$(this).removeClass("hover")});

$(".question-row").click(function(){
	var id = $(this).attr("id").substr(3);
	window.opener.$("#add").attr('value',id);
	window.opener.$("#add-form").submit();
	window.close();
});

{/literal}
</script>
</div>
</body>
</html>
