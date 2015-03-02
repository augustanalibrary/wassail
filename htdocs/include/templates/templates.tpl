{include file="head.tpl"}
{* New template form  *}
{* Output any messages *}
{if isset($success)}
      <div {if $success eq TRUE}class = "success" id = "success-message"{else}class = "error"{/if}>
	{$message}
      </div>
{/if}
      {if $order_dir == 'asc'}
        {assign var = "dir" value = "asc"}
        {assign var = "dir_other" value = "desc"}
        {assign var = "dir_arrow" value = "<img src = 'include/templates/images/arrow_down.png' alt = 'Sort descending' />"}
      {else}
        {assign var = "dir" value = "desc"}
        {assign var = "dir_other" value = "asc"}
        {assign var = "dir_arrow" value = "<img src = 'include/templates/images/arrow_up.png' alt = 'Sort ascending' />"}
      {/if}


    {if $right_write or $right_write_unconditional}
      <img src = "include/templates/images/add.png" alt = "Add new Template" title = "Click to add a new Template..." id = "add-template" class = "clickable" />
    {/if}
{if count($list) ne 0}
    <form method = "post" action = "templates/{$order_column}/{$order_dir}/">
      {* These will get populated & modified ('unset' will be removed from name & value will be filled in) by JS *}
      {* This is because IE7 doesn't sent $_POST['save'] if 'save' is an image input. '*}
      <div style = "display:none;">
	<input type = "hidden" name = "unsetsave" id = "hidden-save" value = "0" />
	<input type = "hidden" name = "unsetcopy" id = "hidden-copy" value = "0" />
	<input type = "hidden" name = "unsetprint" id = "hidden-print" value = "0" />
	<input type = "hidden" name = "unsetdelete" id = "hidden-delete" value = "0" />
      </div>
      <table class = "list">
	<tr>
	  <th style = "width:40px;"><span title = "Click to sort by ID"><a href = "templates/id/{if $order_column == 'id'}{$dir_other}{else}{$dir}{/if}/">ID{if $order_column == 'id'}{$dir_arrow}{/if}</a></span></th>
	  <th style = "width:300px;"><span title = "Click to sort by Template name"><a href = "templates/name/{if $order_column == 'name'}{$dir_other}{else}{$dir}{/if}/" id = "name-link"><span id = "filter-title">Name{if $order_column == 'name'}{$dir_arrow}{/if}</span><span id = "filter-field-wrapper" class = "hidden"><input type = "text" class = "input-field small" id = "filter-field" title = "Enter any number of filter words.&lt;br /&gt;Only rows matching ALL seach terms will be visible.&lt;br /&gt;Search terms are case sensitive." /></span><img src = "include/templates/images/filter.png" title = "Filter on Name..." alt = "Filter" style = "vertical-align:top;" id = "filter" /></a></span></th>
	  <th>Questions</th>
	<th style = "width:120px;"><span title = "Click to sort by date"><a href = "templates/date/{if $order_column == 'date'}{$dir_other}{else}{$dir}{/if}/">Date added{if $order_column == 'date'}{$dir_arrow}{/if}</a></span></th>
	  <th style = "width:110px;"></th>
	</tr>
	{counter print=false assign="counter"}
	{foreach from=$list value=template}
	{counter}
	<tr class = "{if $counter is odd}odd{else}even{/if}" style = "vertical-align:top;">
	  <td style = "width:40px;">
	    {$template.id}
	  </td>
	  <td style = "text-align:left;width:300px;">
	    <input type = "text" class = "input-field small" value = "{$template.name}" name = "name_{$template.id}" size = "50" />
	    <!-- Used for filtering -->
	  <div class = "filter hidden">{$template.name}</div>
	  </td>
	  <td style = "text-align:left;">
	    {if (not $template.asked and $right_write) || $right_write_unconditional}
	    <img src = "include/templates/images/pencil.png" class = "clickable" alt = "Edit questions" title = "Modify Template content" onclick = "newWindow('{$template.id}');" />
	    {/if}
	    <img src = "include/templates/images/eye.png" class = "question-show clickable" alt = "Show questions" title = "Show questions" id = "show-{$template.id}" />
	    <img src = "include/templates/images/eye-closed.png" class = "question-hide clickable" alt = "Hide questions" title = "Hide questions" style = "display:none;" id = "hide-{$template.id}"/>
	    <div class = "question-list hidden" id = "questions-{$template.id}">
	    </div>
	  </td>
	<td>
	  {$template.date_added|date:$date_format_short}
	</td>
	  <td style = "text-align:left;width:125px;">
	    {if $right_write or $right_write_unconditional}
	    <input type = "image" src = "include/templates/images/disk.png" title = "Save changes" class = "image save-icon clickable" name = "save" value = "{$template.id}"/>
	    <input type = "image" src = "include/templates/images/page_copy.png" title = "Copy..." class = "image copy-icon" name = "copy" value = "{$template.id}"/>
	    <input type = "image" src = "include/templates/images/application_form_add.png" alt = "Make this template an online questionnaire..." title = "Make this template an online questionnaire..." class = "form-icon clickable image" value = "{$template.id}" />
		{if $right_write_unconditional}
			<input type = "image" src = "include/templates/images/application_form_edit.png" alt = "Edit online questionnaire for this template" title = "Edit online questionnaire for this template" class = "form-edit-icon clickable image" value = "{$template.id}" />
		{/if}
	    <img src = "include/templates/images/printer.png" title = "Print" class = "image print-icon clickable" id = "print-{$template.id}" alt = "Print"/>

	      {if !$template.asked}
	        <input type = "image" src = "include/templates/images/bin.png" title = "Delete" class = "image delete-icon clickable" name = "delete" value = "{$template.id}"/>
	      {/if}
	    {/if}
	  </td>
	</tr>
	{/foreach}
      </table>
    </form>
      {/if}
    {if $right_write or $right_write_unconditional}
    <div class = "modal-div action" id = "add-template-wrapper">
      <div class = "dialog modal-dialog">
	<h1>
	  Add a new Template
	</h1>
	<form method = "post" action = "templates/{$order_column}/{$order_dir}/" id = "add-form">
	<div style = "text-align:center;">
	  Name: <input type = "text" value = "{if isset($add_name)}{$add_name:escape}{/if}" name = "name" {if isset($add_error)}class = "input-highlight"{/if} id = "new-template-name"/>
	  <br />
	  <br />
	  <input type = "submit" value = "Add new Template" class = "submit" name = "add" id = "add-submit"/>
	  <input type = "reset" value = "Cancel" class = "submit" id = "add-cancel"/>
	</div>
      </form>
      </div>
    </div>
    {/if}
	
	{if $right_write_unconditional}
		<div class = "modal-div action" id = "web_form_list_wrapper">
      		<div class = "dialog modal-dialog">
				<h1>
	  				Edit web forms
				</h1>
				<div id = "web_form_list">
				</div>
				<p style = "text-align:center;">
					<input type = "submit" value = "Cancel" class = "submit" id = "edit-cancel"/>
				</p>
			</div>
		</div>
    {/if}
<script type = "text/javascript" src = "include/templates/js/templates.js"></script>
{include file="foot.tpl"}
