{include file = "head.tpl"}
{* Note: the add form on this page is "submitted" by Javascript because XHTML1.1 strict doesn't allow for a "target" attribute.  Also, there's no way to remove toolbars & such if the form is posted to a new window w/o Javascript *}

<div class = "success hidden" id = "response-added-note">
Response(s) added/edited.  Please re-open the template to see the changes.
</div>




{if $rightWrite}
      <img src = "include/templates/images/page_white_go.png" alt = "Import CSV" title = "Click to import a CSV of report data" id = "csv-import" class = "clickable" />
      <img src = "include/templates/images/add.png" alt = "Toggle visibility of add form" title = "Click to start adding responses" id = "add-form-show" class = "clickable"/>
{/if}{* /if rightWrite *}
    {* ************************************************************************  *}
    {* Display the list of templates.  Note that this list gets modified by AJAX *}

    {if $responded_templates ne FALSE}
    {if $order_dir == 'asc'}
      {assign var = "dir" value = "asc"}
      {assign var = "dir_other" value = "desc"}
      {assign var = "dir_arrow" value = "<img src = 'include/templates/images/arrow_down.png' alt = 'Sort descending' />"}
    {else}
      {assign var = "dir" value = "desc"}
      {assign var = "dir_other" value = "asc"}
      {assign var = "dir_arrow" value = "<img src = 'include/templates/images/arrow_up.png' alt = 'Sort ascending' />"}
    {/if}
    <table class = "list" id = "master-table">
      <tr>
	<th style = "width:40px;"><a href = "responses/id/{if $order_column == 'id'}{$dir_other}{else}{$dir}{/if}/"><span title = "Click to sort by ID">ID{if $order_column == 'id'}{$dir_arrow}{/if}</span></a></th>
	<th><a href = "responses/name/{if $order_column == 'name'}{$dir_other}{else}{$dir}{/if}/"><span title = "Click to sort by name">Name{if $order_column == 'name'}{$dir_arrow}{/if}</span></a></th>
	<th><a href = "responses/date_added/{if $order_column == 'date_added'}{$dir_other}{else}{$dir}{/if}/"><span title = "Click to sorty by date">Date Added{if $order_column == 'date_added'}{$dir_arrow}{/if}</span></a></th>
	<th></th>
      </tr>
      {foreach from=$responded_templates value=properties}
      <tr class = "clickable real-row" id = "id_{$properties.id}">
	<td>
	  {$properties.id}
	</td>
	<td style = "text-align:left;">
	  {$properties.name}
	</td>
	<td>
		<?php 
	      /* The TemplateLite way of doing this was creating really wacky dates for no discernable reason.
	       * "1407440239" got rendered as 05/03/39 instead of 07/08/14.  So, raw PHP is used
	       */
	      echo date($this->_vars['date_format_short'],$this->_vars['properties']['date_added']);
	    ?>
	</td>
	<td>
{ if $rightWrite }
	    <img src = "include/templates/images/bin.png" alt = "Click to delete all responses for this template" title = "Click to delete all responses for this template" class = "delete-responses" id = "delete_{$properties.id}" />
{ else }
	  &nbsp;
{ /if }
	</td>
      </tr>
	<tr class = "hidden">
	<td colspan = "4" id = "child-{$properties.id}" class = "child" style = "text-align:left;">
	  <img src = "include/templates/images/loading.gif" class = "loading" alt = "Loading" title = "Please wait while entries load..." />
	</td>
	</tr>
      {/foreach}
	  </table>
      {/if}
    

{if $rightWrite}
    {* no <form> here - it's mimiced by JS *}
    <div class = "modal-div action" id = "add-response">
      <div class = "dialog modal-dialog" style = "width:500px;">
	  <h1>
	    Add responses
	  </h1>
	  <table id = "add-form">
	    <tr>
	      <td style = "text-align:right;">
		Template:
	      </td>
	      <td style = "text-align:left;">
		{if count($templates) gt 0}
		<select name = "template" class = "clickable small" id = "add-template">
		  {foreach from=$templates value="template"}
		  <option value="{$template.id}" {if $selected_template eq $template.id}selected="selected"{/if}>[{$template.id}] {$template.name}</option>
		{/foreach}
	      </select>
		{else}
		There are no templates created.  Please create one before adding responses.
		{/if}
	      </td>
	    </tr>
	    <tr>
	      <td style = "text-align:right;vertical-align:top;">
		Course:
	      </td>
	      <td>				
		{if count($courses) gt 0}
		<select name = "course" class = "clickable small" id = "add-course">
		  {foreach from=$courses value="course"}
		  <option value = "{$course.id}" {if $selected_course eq $course.id}selected="selected"{/if}>[{$course.id}] {$course.name}</option>
		{/foreach}
	      </select>
		{else}
		There are no courses.  Please create one before adding responses.
		{/if}
		<div class = "notice small">
				As online questionnaires/surveys/tests are created, a course will be required in the setup of the questionnaire/survey/test. As a result, you are advised to create a course at this point. A course can be literally a course (eg. PSY 200) or anything you would like to describe (eg. The name of a survey).
			</div>
	      </td>
	    </tr>
	    <tr>
	      <td style = "text-align:right;vertical-align:top;">
		Term:
	      </td>
	      <td>
	      	<input type = "radio" name = "term" value = "2" class = "radio" {if $checked_term eq 2}checked = "checked"{/if} id = "term_2" />
			<label for="term_2" class = "clickable">
		      Fall
		    </label><br />
		    <input type = "radio" name = "term" value = "3" class = "radio" {if $checked_term eq 3}checked = "checked"{/if} id = "term_3" />
			<label for="term_3" class = "clickable">
		      Winter
		    </label><br />
		    <input type = "radio" name = "term" value = "0" class = "radio" {if $checked_term eq 0}checked = "checked"{/if} id = "term_0" />
			<label for="term_0" class = "clickable">
		      Spring
		    </label><br />
		    <input type = "radio" name = "term" value = "1" class = "radio" {if $checked_term eq 1}checked = "checked"{/if} id = "term_1" />
			<label for="term_1" class = "clickable">
		      Summer
		    </label>
		
	      </td>
	    </tr>
	    <tr>
	      <td style = "text-align:right;vertical-align:top;">
		Type:
	      </td>
	      <td style = "text-align:left;">
		{foreach from=$types key=type_id value=type}
		<input type = "radio" class = "radio" name = "type" value = "{$type_id}" {if $checked_type eq $type_id}checked = "checked"{/if} id = "type_{$type_id}"/>
		<label for="type_{$type_id}" class = "clickable">{$type}</label><br />
		{/foreach}
	      </td>
	    </tr>
	    <tr>
	      <td>
		School Year:
	      </td> 
	      <td>
		<select name = "school_year" class = "clickable small" id = "add-school-year">
		  {* 
		   * Ideally, $years would be calculated here, but it appears TemplateLite has a bug with 
		   * decrementing values rather than incrementing them, so PHP must generate the years 
		   *}
		    {foreach from=$years value=curr_year}
		  <option value = "{$curr_year}" {if $selected_school_year eq $curr_year}selected="selected"{/if}>{$curr_year}</option>
		{/foreach}
	      </select>
	      </td>
	    </tr>
	    <tr>
	      <td colspan = "2" style = "text-align:center;">
		{if count($templates) gt 0 and count($courses) gt 0}
		<input type = "submit" name = "add" value = "Add new response(s)..." class = "submit" id = "add-submit"/>
		{/if}
		<input type = "reset" class = "submit" id = "add-cancel" value = "Cancel" />
	      </td>
	    </tr>
	  </table>
	</div>
      </div>
{/if}{* if $rightWrite *}

<script type = "text/javascript" src = "include/templates/js/responses.js"></script>
{include file = "foot.tpl"}
