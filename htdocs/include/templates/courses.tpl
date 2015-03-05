{include file="head.tpl"}
      {if isset($success)}
      <div {if $success}class = "success" id = "success-message"{else}class = "error"{/if}>
	{$message}
      </div>
      {/if}
      {if $right_write}
    <img src = "include/templates/images/add.png" alt = "Add new Course" title = "Click to add a new Course..." id = "add-course" class = "clickable"/>
    {/if}

    {* Course list table *}
      {if isset($list) && count($list)}
      {if $order_dir == 'asc'}
        {assign var = "dir" value = "asc"}
        {assign var = "dir_other" value = "desc"}
        {assign var = "dir_arrow" value = "<img src = 'include/templates/images/arrow_down.png' alt = 'Sort descending' />"}
      {else}
        {assign var = "dir" value = "desc"}
        {assign var = "dir_other" value = "asc"}
        {assign var = "dir_arrow" value = "<img src = 'include/templates/images/arrow_up.png' alt = 'Sort ascending' />"}
      {/if}
    <form method = "post" action = "courses/{$order_column}/{$order_dir}/">
      <div>
	{* These fields are populated by JS because IE doesn't set $_POST['edit'] if 'edit' is an image button *}
	<input type = "hidden" name = "unsetedit" id = "hidden-edit" value = "0" />
	<input type = "hidden" name = "unsetdelete" id = "hidden-delete" value = "0" />
	
	<table class = "list">
	  <tr>
	    <th style = "width:40px;">
	      <span title = "Click to sort by ID">
		<a href = "courses/id/{if $order_column == 'id'}{$dir_other}{else}{$dir}{/if}/">
		  ID{if $order_column == 'id'}{$dir_arrow}{/if}
		</a>
	      </span>
	    </th>
	    <th style = "width:120px;">
	      <span title = "Click to sort by Course number">
		<a href = "courses/number/{if $order_column == 'number'}{$dir_other}{else}{$dir}{/if}/">
		  Course number{if $order_column == 'number'}{$dir_arrow}{/if}
		</a>
	      </span>
	    </th>
	    <th>
	      <span title = "Click to sort by Course name">
		<a href = "courses/name/{if $order_column == 'name'}{$dir_other}{else}{$dir}{/if}/">
		  Course name{if $order_column == 'name'}{$dir_arrow}{/if}
		</a>
	      </span>
	    </th>
	    <th style = "width:220px;">
	      <span title = "Click to sort by Course instructor">
		<a href = "courses/instructor/{if $order_column == 'instructor'}{$dir_other}{else}{$dir}{/if}/">
		  Course instructor{if $order_column == 'instructor'}{$dir_arrow}{/if}
		</a>
	      </span>
	    </th>
	    <th style = "width:110px;">
	      <span title = "Click to sort by date">
		<a href = "courses/date/{if $order_column == 'date'}{$dir_other}{else}{$dir}{/if}/">
		  Date added{if $order_column == 'date'}{$dir_arrow}{/if}
		</a>
	      </span>
	    </th>
	    <th style = "width:50px;">
	    </th>
	  </tr>
	  {counter print=false assign="counter"}
	  {foreach from=$list key=row_id value=row}
	  {counter}
	  <tr class = "{if $counter is odd}odd{else}even{/if}">
	    <td>
	      {$row.id}
	    </td>
	    <td>
	      <input name = "number_{$row.id}" type = "text" value = "{$row.number|escape}" class = "input-field small" size = "15"/>
	    </td>
	    <td>
	      <input name = "name_{$row.id}" type = "text" value = "{$row.name|escape}" class = "input-field small" size = "62"/>
	    </td>
	    <td>
	      <input name = "instructor_{$row.id}" type = "text" value = "{$row.instructor|escape}" class = "input-field small" size = "33"/>
	    </td>
	    <td>
	    	<?php 
		      /* The TemplateLite way of doing this was creating really wacky dates for no discernable reason.
		       * "1407440239" got rendered as 05/03/39 instead of 07/08/14.  So, raw PHP is used
		       */
		      echo date($this->_vars['date_format_short'],$this->_vars['row']['date_added']);
		    ?>
	    </td>
	    <td style = "text-align:left;">
	      {if $right_write or $right_write_unconditional}
	      <input type = "image" src = "include/templates/images/disk.png" title = "Save changes" class = "image edit-submitter" name = "edit" value = "{$row.id}"/>
	      {if $row.asked == 0}
	      <input type = "image" src = "include/templates/images/bin.png" title = "Delete" class = "image delete-submitter" name = "delete" value = "{$row.id}" />
	      {/if}
	      {/if}
	    </td>
	  </tr>
	  {/foreach}
	</table>
      </div>
    </form>
    {/if}
    {* /If there are courses to list *}
    
    {if $right_write}
    <div id = "add-course-wrapper" class = "action modal-div">
      <div class = "dialog modal-dialog" style = "width:1000px;">
	<h1>
	  Add a new Course/Event:
	</h1>
	<form id = "add-form" method = "post" action = "courses/{$order_column}/{$order_dir}/">
	<table>
	  <tr>
	    <th style = "text-align:right;vertical-align:top;">
	      Course number / Event name:
	    </th>
	    <td>
	      <input type = "text" name = "number" id = "new-number" size = "7" class = "input-field{if (isset($add_error.number))} input-highlight{/if}"/>
	      <img src = "include/templates/images/bullet_red.png" id = "new-number-status" class = "invalid" title = "Enter a new course number.  When this light turns green, the number is acceptable" alt = "Course number status"/><br />
	      (eg PSY 200 / Photo Contest)<br /><br />
	      </td>
	    </tr>
	    <tr>
	      <th style = "text-align:right;vertical-align:top;">
		Course / Event name:
	      </th>
	      <td>
			<input type = "text" name = "name" id = "new-name" size = "40" class = "input-field{if (isset($add_error.name))} input-highlight{/if}"/>
	      	<img src = "include/templates/images/bullet_red.png" id = "new-name-status" class = "invalid" title = "Enter a new course name.  When this light turns green, the name is acceptable" alt = "Course name status"/> <br />
	      	(eg Intro to Psychology / Photo Contest 2014)<br /><br />
	      </td>
	    </tr>
	    <tr>
	      <th style = "text-align:right;vertical-align:top;">
			Course instructor / Other info:
	      </th>
	      <td>
			<input type = "text" name = "instructor" id = "new-instructor" size = "30" class = "input-field{if (isset($add_error.instructor))} input-highlight{/if}"/><br />
			(eg Professor G. Smith / Used for gather info about photographer, submissions and upload photo entry)<br /><br />
	      </td>
	    </tr>
	    <tr>
	      <td colspan = "2" style = "text-align:center;">
		<input type = "submit" name = "save" value = "Add new course" style = "visibility:hidden;" class = "submit" id = "add-course-submit"/>
		<input type = "reset" name = "reset" value = "Cancel" class = "submit" id = "add-course-cancel" />
	      </td>
	    </tr>
	  </table>
	</form>
	</div>
      </div>
      {/if} {* only include the form if the user has appropriate write rights *}



    <script type = "text/javascript" src = "include/templates/js/courses.js"></script>
    {include file="foot.tpl"}
