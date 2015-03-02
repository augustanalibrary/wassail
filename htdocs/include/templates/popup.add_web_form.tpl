{ assign var="load_editor" value = "TRUE" }
{ assign var="load_calendar" value = "TRUE" }
{include file="head.popup.tpl"}
<div id = "calendarDiv"><!-- necessary for inline calendar--></div>
  {if isset($success)}
<div class = "{if $success}success{else}error{/if}">
  {$message}
</div>
{/if}
{if isset($error)}
	<div class = "error">
		{ $error }
	</div>
{ /if }
      <form method = 'post' action = '{if isset($editing)}popup.edit_web_form.php?id={$id}{else}popup.add_web_form.php{/if}' id = 'form'>
      <table>
	<tr>
	  <th style = "text-align:right;">
	    Template:
	  </th>
	  <td>
	  	{ if count($templates) gt 0 }
			<select name = "template" class = "clickable small">
			  {foreach from=$templates value=template}
			<option value = "{$template.id}" {if $selected_template eq $template.id}selected="selected"{/if} >[{$template.id}] {$template.name}</option>
			  {/foreach}
			</select>
		{else}
			There are no templates.  Please create one before making a web form.
		{/if}
	  </td>
	</tr>
	<tr>
	  <th style = "text-align:right;vertical-align:top;">
	    Course:
	  </th>
	  <td>
	  	{ assign var="selected_course_found" value = "FALSE" }
	  	{ if count($courses) gt 0 }
			<select name = "course" class = "clickable small">
			  {foreach from=$courses value=course}
			<option value = "{$course.id}" {if $selected_course eq $course.id}selected="selected"{ assign var="selected_course_found" value = "TRUE" }{/if}>[{$course.id}] {$course.name}</option>
			{/foreach}
			</select>
		{else}
			There are no courses.  Please create one before making a web form.
		{/if}
		{if $selected_course_found == "FALSE" && isset($editing)}
			<div class = "error small">
				The course for which this online questionnaire was initially created, no longer exists.  Please choose a new course.
			</div>
		{ /if }
		{if !isset($editing) }
			<div class = "notice small">
				As online questionnaires/surveys/tests are created, a course will be required in the setup of the questionnaire/survey/test. As a result, you are advised to create a course at this point. A course can be literally a course (eg. PSY 200) or anything you would like to describe (eg. The name of a survey).
			</div>
		{/if}
	  </td>
	</tr>
	<tr>
	  <th style = "text-align:right;">
	    Year:
	  </th>
	  <td>
	    <select name = "school_year" class = "clickable small">
	      {foreach from=$years value=year}
		<option value = "{$year}" {if $selected_school_year eq $year}selected="selected"{/if}>{$year}</option>
	    {/foreach}
	    </select>
	  </td>
	</tr>
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
	    Term:
	  </th>
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
	  <th style = "vertical-align:top;text-align:right;">
	    Type:
	  </th>
	  <td>
	    {foreach from=$types key=type_id value=type}
	    <input type = "radio" name = "type" value = "{$type_id}" class = "radio" {if $checked_type eq $type_id}checked = "checked"{/if} id = "type_{$type_id}" />
	    <label for="type_{$type_id}" class = "clickable">
	      {$type}
	    </label><br />
	    {/foreach}
	  </td>
	</tr>
	{if !isset($editing) }
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
	    Name:
	  </th>
	  <td>
	    <input type = "text" name = "name" id = "name" value = "{if isset($name)}{ $name }{/if}" size = "20" /><br />
	    <small>* [Optional] Choose a unique name for this web questionnaire.  If entered, this name will be used in the URL to the form, rather than the web form ID #. <strong>Can only contain characters a-z, 0-9, and underscores.</strong>
	  </td>
	</tr>
	{ /if }
	<tr>
	  <th style = "text-align:right;width:140px;vertical-align:top;">
	  	{if !isset($editing) }
	    	# of respondents:
		{else}
			Add respondents:
		{/if}
	  </th>
	  <td>
	    <input type = "text" size = "3" maxlength = "4" name = "respondents" id = "respondents"  value = "{$respondents}" />
		{if isset($editing)}
			<br />
			<small>
				To add more respondents to this questionnaire, provide a number above.<br />"0" will leave the number of respondents unchanged.
			</small>
		{/if}
	  </td>
	</tr>
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
	    Expiry date:
	  </th>
	  <td>
	    <input type = "text" class = "input-field calendarSelectDate" name = "expiry_date" id = "expiry-date" value = "{$expiry_date}" size = "10" readonly = "readonly" title = "Click to choose date"/><br /><small>* The automatic passwords generated for this questionnaire will expire at <strong>11:59:59 PM</strong> on this date.</small>
	  </td>
	</tr>
	{ if !isset($editing) }
		<tr>
		  <th style = "vertical-align:top;text-align:right;">
			Public:
		  </th>
		  <td>
			<input type = "checkbox" name = "public" { if isset($public) and $public }checked="checked"{ /if } />
			<br />
			<small>
			  'Public' questionnaires do not require a password, which allows absolutely anyone to login.  The number of respondents is still limited.
			</small>
		  </td>
		</tr>
	{/if}
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
	    Intro:
	  </th>
	  <td>
	    <small>
	      [Optional] If you want, you can write a small introductory paragraph that will be shown to users on the login page.
	    </small>
	    <textarea rows = "10" cols = "50" style = "width:100%;" name = "intro">{ if isset($intro) }{ $intro }{ /if }</textarea>
	  </td>
	</tr>
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
		File request:
	  </th>
	  <td>
		<input type = "text" name = "file_request" value = "{ if isset($file_request) }{ $file_request|escape:"html" }{ /if }" /><br />
		<small>
		  [Optional] You may have respondents upload a file with their response.  To do so, please provide the comment that you would like to preface this request:
		</small>
		<div class="notice small">
			The maximum allowed file upload size allowed by the server is { $upload_max_filesize }.  If a respondent tries to upload a file greater than { $upload_max_filesize }, they will get an error.
		</div>
	  </td>
	</tr>
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
		Number of files:
	  </th>
	  <td>
	  	<select name = "file_count">
	  		<option value = "1" { if $file_count == 1 }selected{ /if }>1</option>
	  		<option value = "2" { if $file_count == 2 }selected{ /if }>2</option>
	  		<option value = "3" { if $file_count == 3 }selected{ /if }>3</option>
	  		<option value = "4" { if $file_count == 4 }selected{ /if }>4</option>
	  		<option value = "5" { if $file_count == 5 }selected{ /if }>5</option>
		</select><br />
		<small>
		  [Optional] If respondents are to upload a file, you can specify the number of files they may upload.  Each uploaded file cannot exceed the { $upload_max_filesize } limit.
		</small>
	  </td>
	</tr>
	<tr>
		<th style = "vertical-align:top;text-align:right;">
	    Confirmation message:
	  </th>
	  <td>
	    <textarea rows = "10" cols = "50" style = "width:100%;" name = "confirmation">{ if isset($confirmation) }{ $confirmation }{ /if }</textarea>
	    <small>
	    	[Optional].This message will appear on the screen after the questionnaire has been submitted. If not provided, the default thank you message will appear.
	    </small>
	  </td>
	</tr>
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
		Email notification:
	  </th>
	  <td>
		<input type = "text" name = "email" value = "{ if isset($email) }{ $email|escape:"html" }{ /if }" />
		<br />
		<small>
		  [Optional] If you would like to receive email notification when a response is submitted, provide your email here.  Separate addresses with a comma.
		</small>
		
	  </td>
	</tr>
	<tr>
	  <td colspan = "2" style = "text-align:center;">
	  	{ if isset($editing) }
	    	<input type = "submit" class = "submit" name = "save" value = "Save..." />
		{ else }
			<input type = "submit" class = "submit" name = "generate" value = "Generate..." />
		{ /if }
	  </td>
	</tr>
      </table>
    </form>
<script type = "text/javascript">
var editing = {if isset($editing)}true{else}false{/if};
{literal}
$("#form").submit(function(){
     var $respondents = $("#respondents");
	 
	 if($respondents.val().length == 0)
      {
		if(editing)
			$respondents.val(0);
		else
		{
			alert('You must enter the number of respondents for this questionnaire.');
			$respondents.addClass('input-highlight');
	return false;
      }
      else if($respondents.val() == 0 && !editing)
      {
		alert('Number of respondents must be greater than zero.');
		$respondents.addClass('input-highlight');
	return false;
      }
      else
	$respondents.removeClass('input-highlight');



      if($("#expiry-date").val().length == 0)
      {
	alert('You must enter the date this questionnaire expires.');
	$("#expiry-date").addClass('input-highlight');
	return false;
      }
      else
	$("#expiry-date").removeClass('input-highlight');


      return true;
		  });
{/literal}
</script>
{include file="foot.popup.tpl"}
