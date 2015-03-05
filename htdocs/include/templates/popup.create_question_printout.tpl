{include file="head.popup.tpl"}
{if count($list) gt 0}
      <table class = "list" style = "margin:0;">
	<tr class = "plain-header">
	  <th>
	    ID
	  </th>
	  <th>
	    Question
	  </th>
	  <th>
	    Date Added
	  </th>
	  <th>
	    Categories
	  </th>
	  <th>
	    Tags
	  </th>
	  <th>
	    Answers
	  </th>
	</tr>
	{counter print=false assign="counter"}
	{foreach from=$list value=row}
	{counter}
	<tr class = "{if $counter is odd}odd{else}even{/if}" style = "vertical-align:top;">
	  <td>
	    {$row.id}
	  </td>
	  <td style = "text-align:left;vertical-align:top">
	    {$row.text}
	  </td>
	  <td>
	  	<?php 
	      /* The TemplateLite way of doing this was creating really wacky dates for no discernable reason.
	       * "1407440239" got rendered as 05/03/39 instead of 07/08/14.  So, raw PHP is used
	       */
	      echo date($this->_vars['date_format_short'],$this->_vars['row']['date_added']);
	    ?>
	  </td>
	  <td>
	    {if isset($row.categories)}
	    {foreach from=$row.categories value=category_text}
	    {$category_text}<br />
	    {/foreach}
	    {/if}
	  </td>
	  <td>
	    {if count($row.tags) gt 0}
	    {foreach from=$row.tags value = tag_text}
	    {$tag_text}<br />
	    {/foreach}
	    {/if}
	  </td>
	  <td style = "text-align:left;">
	    {if (isset($row.answers))}
	    {foreach from=$row.answers value=text}
	    {$text}<br />
	    {/foreach}
	    {/if}
	  </td>
	</tr>
	{/foreach}
      </table>
{else}
      No questions exist
{/if}

{include file="foot.popup.tpl"}