<?php require_once('/var/www/htdocs/include/template_lite/plugins/modifier.escape.php'); $this->register_modifier("escape", "tpl_modifier_escape");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2014-05-02 08:57:00 MDT */ ?>

<?php $this->assign('load_editor', "TRUE");  $this->assign('load_calendar', "TRUE");  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div id = "calendarDiv"><!-- necessary for inline calendar--></div>
  <?php if (isset ( $this->_vars['success'] )): ?>
<div class = "<?php if ($this->_vars['success']): ?>success<?php else: ?>error<?php endif; ?>">
  <?php echo $this->_vars['message']; ?>

</div>
<?php endif;  if (isset ( $this->_vars['error'] )): ?>
	<div class = "error">
		<?php echo $this->_vars['error']; ?>

	</div>
<?php endif; ?>
      <form method = 'post' action = '<?php if (isset ( $this->_vars['editing'] )): ?>popup.edit_web_form.php?id=<?php echo $this->_vars['id'];  else: ?>popup.add_web_form.php<?php endif; ?>' id = 'form'>
      <table>
	<tr>
	  <th style = "text-align:right;">
	    Template:
	  </th>
	  <td>
	  	<?php if (count ( $this->_vars['templates'] ) > 0): ?>
			<select name = "template" class = "clickable small">
			  <?php if (count((array)$this->_vars['templates'])): foreach ((array)$this->_vars['templates'] as $this->_vars['template']): ?>
			<option value = "<?php echo $this->_vars['template']['id']; ?>
" <?php if ($this->_vars['selected_template'] == $this->_vars['template']['id']): ?>selected="selected"<?php endif; ?> >[<?php echo $this->_vars['template']['id']; ?>
] <?php echo $this->_vars['template']['name']; ?>
</option>
			  <?php endforeach; endif; ?>
			</select>
		<?php else: ?>
			There are no templates.  Please create one before making a web form.
		<?php endif; ?>
	  </td>
	</tr>
	<tr>
	  <th style = "text-align:right;vertical-align:top;">
	    Course:
	  </th>
	  <td>
	  	<?php $this->assign('selected_course_found', "FALSE"); ?>
	  	<?php if (count ( $this->_vars['courses'] ) > 0): ?>
			<select name = "course" class = "clickable small">
			  <?php if (count((array)$this->_vars['courses'])): foreach ((array)$this->_vars['courses'] as $this->_vars['course']): ?>
			<option value = "<?php echo $this->_vars['course']['id']; ?>
" <?php if ($this->_vars['selected_course'] == $this->_vars['course']['id']): ?>selected="selected"<?php $this->assign('selected_course_found', "TRUE");  endif; ?>>[<?php echo $this->_vars['course']['id']; ?>
] <?php echo $this->_vars['course']['name']; ?>
</option>
			<?php endforeach; endif; ?>
			</select>
		<?php else: ?>
			There are no courses.  Please create one before making a web form.
		<?php endif; ?>
		<?php if ($this->_vars['selected_course_found'] == "FALSE" && isset ( $this->_vars['editing'] )): ?>
			<div class = "error small">
				The course for which this online questionnaire was initially created, no longer exists.  Please choose a new course.
			</div>
		<?php endif; ?>
		<?php if (! isset ( $this->_vars['editing'] )): ?>
			<div class = "notice small">
				As online questionnaires/surveys/tests are created, a course will be required in the setup of the questionnaire/survey/test. As a result, you are advised to create a course at this point. A course can be literally a course (eg. PSY 200) or anything you would like to describe (eg. The name of a survey).
			</div>
		<?php endif; ?>
	  </td>
	</tr>
	<tr>
	  <th style = "text-align:right;">
	    Year:
	  </th>
	  <td>
	    <select name = "school_year" class = "clickable small">
	      <?php if (count((array)$this->_vars['years'])): foreach ((array)$this->_vars['years'] as $this->_vars['year']): ?>
		<option value = "<?php echo $this->_vars['year']; ?>
" <?php if ($this->_vars['selected_school_year'] == $this->_vars['year']): ?>selected="selected"<?php endif; ?>><?php echo $this->_vars['year']; ?>
</option>
	    <?php endforeach; endif; ?>
	    </select>
	  </td>
	</tr>
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
	    Term:
	  </th>
	  <td>
	  	<input type = "radio" name = "term" value = "2" class = "radio" <?php if ($this->_vars['checked_term'] == 2): ?>checked = "checked"<?php endif; ?> id = "term_2" />
		<label for="term_2" class = "clickable">
	      Fall
	    </label><br />
	    <input type = "radio" name = "term" value = "3" class = "radio" <?php if ($this->_vars['checked_term'] == 3): ?>checked = "checked"<?php endif; ?> id = "term_3" />
		<label for="term_3" class = "clickable">
	      Winter
	    </label><br />
	    <input type = "radio" name = "term" value = "0" class = "radio" <?php if ($this->_vars['checked_term'] == 0): ?>checked = "checked"<?php endif; ?> id = "term_0" />
		<label for="term_0" class = "clickable">
	      Spring
	    </label><br />
	    <input type = "radio" name = "term" value = "1" class = "radio" <?php if ($this->_vars['checked_term'] == 1): ?>checked = "checked"<?php endif; ?> id = "term_1" />
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
	    <?php if (count((array)$this->_vars['types'])): foreach ((array)$this->_vars['types'] as $this->_vars['type_id'] => $this->_vars['type']): ?>
	    <input type = "radio" name = "type" value = "<?php echo $this->_vars['type_id']; ?>
" class = "radio" <?php if ($this->_vars['checked_type'] == $this->_vars['type_id']): ?>checked = "checked"<?php endif; ?> id = "type_<?php echo $this->_vars['type_id']; ?>
" />
	    <label for="type_<?php echo $this->_vars['type_id']; ?>
" class = "clickable">
	      <?php echo $this->_vars['type']; ?>

	    </label><br />
	    <?php endforeach; endif; ?>
	  </td>
	</tr>
	<?php if (! isset ( $this->_vars['editing'] )): ?>
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
	    Name:
	  </th>
	  <td>
	    <input type = "text" name = "name" id = "name" value = "<?php if (isset ( $this->_vars['name'] )):  echo $this->_vars['name'];  endif; ?>" size = "20" /><br />
	    <small>* [Optional] Choose a unique name for this web questionnaire.  If entered, this name will be used in the URL to the form, rather than the web form ID #. <strong>Can only contain characters a-z, 0-9, and underscores.</strong>
	  </td>
	</tr>
	<?php endif; ?>
	<tr>
	  <th style = "text-align:right;width:140px;vertical-align:top;">
	  	<?php if (! isset ( $this->_vars['editing'] )): ?>
	    	# of respondents:
		<?php else: ?>
			Add respondents:
		<?php endif; ?>
	  </th>
	  <td>
	    <input type = "text" size = "3" maxlength = "4" name = "respondents" id = "respondents"  value = "<?php echo $this->_vars['respondents']; ?>
" />
		<?php if (isset ( $this->_vars['editing'] )): ?>
			<br />
			<small>
				To add more respondents to this questionnaire, provide a number above.<br />"0" will leave the number of respondents unchanged.
			</small>
		<?php endif; ?>
	  </td>
	</tr>
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
	    Expiry date:
	  </th>
	  <td>
	    <input type = "text" class = "input-field calendarSelectDate" name = "expiry_date" id = "expiry-date" value = "<?php echo $this->_vars['expiry_date']; ?>
" size = "10" readonly = "readonly" title = "Click to choose date"/><br /><small>* The automatic passwords generated for this questionnaire will expire at <strong>11:59:59 PM</strong> on this date.</small>
	  </td>
	</tr>
	<?php if (! isset ( $this->_vars['editing'] )): ?>
		<tr>
		  <th style = "vertical-align:top;text-align:right;">
			Public:
		  </th>
		  <td>
			<input type = "checkbox" name = "public" <?php if (isset ( $this->_vars['public'] ) && $this->_vars['public']): ?>checked="checked"<?php endif; ?> />
			<br />
			<small>
			  'Public' questionnaires do not require a password, which allows absolutely anyone to login.  The number of respondents is still limited.
			</small>
		  </td>
		</tr>
	<?php endif; ?>
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
	    Intro:
	  </th>
	  <td>
	    <small>
	      [Optional] If you want, you can write a small introductory paragraph that will be shown to users on the login page.
	    </small>
	    <textarea rows = "10" cols = "50" style = "width:100%;" name = "intro"><?php if (isset ( $this->_vars['intro'] )):  echo $this->_vars['intro'];  endif; ?></textarea>
	  </td>
	</tr>
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
		File request:
	  </th>
	  <td>
		<input type = "text" name = "file_request" value = "<?php if (isset ( $this->_vars['file_request'] )):  echo $this->_run_modifier($this->_vars['file_request'], 'escape', 'plugin', 1, "html");  endif; ?>" /><br />
		<small>
		  [Optional] You may have respondents upload a file with their response.  To do so, please provide the comment that you would like to preface this request:
		</small>
		<div class="notice small">
			The maximum allowed file upload size allowed by the server is <?php echo $this->_vars['upload_max_filesize']; ?>
.  If a respondent tries to upload a file greater than <?php echo $this->_vars['upload_max_filesize']; ?>
, they will get an error.
		</div>
	  </td>
	</tr>
	<tr>
	  <th style = "vertical-align:top;text-align:right;">
		Number of files:
	  </th>
	  <td>
	  	<select name = "file_count">
	  		<option value = "1" <?php if ($this->_vars['file_count'] == 1): ?>selected<?php endif; ?>>1</option>
	  		<option value = "2" <?php if ($this->_vars['file_count'] == 2): ?>selected<?php endif; ?>>2</option>
	  		<option value = "3" <?php if ($this->_vars['file_count'] == 3): ?>selected<?php endif; ?>>3</option>
	  		<option value = "4" <?php if ($this->_vars['file_count'] == 4): ?>selected<?php endif; ?>>4</option>
	  		<option value = "5" <?php if ($this->_vars['file_count'] == 5): ?>selected<?php endif; ?>>5</option>
		</select><br />
		<small>
		  [Optional] If respondents are to upload a file, you can specify the number of files they may upload.  Each uploaded file cannot exceed the <?php echo $this->_vars['upload_max_filesize']; ?>
 limit.
		</small>
	  </td>
	</tr>
	<tr>
		<th style = "vertical-align:top;text-align:right;">
	    Confirmation message:
	  </th>
	  <td>
	    <textarea rows = "10" cols = "50" style = "width:100%;" name = "confirmation"><?php if (isset ( $this->_vars['confirmation'] )):  echo $this->_vars['confirmation'];  endif; ?></textarea>
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
		<input type = "text" name = "email" value = "<?php if (isset ( $this->_vars['email'] )):  echo $this->_run_modifier($this->_vars['email'], 'escape', 'plugin', 1, "html");  endif; ?>" />
		<br />
		<small>
		  [Optional] If you would like to receive email notification when a response is submitted, provide your email here.  Separate addresses with a comma.
		</small>
		
	  </td>
	</tr>
	<tr>
	  <td colspan = "2" style = "text-align:center;">
	  	<?php if (isset ( $this->_vars['editing'] )): ?>
	    	<input type = "submit" class = "submit" name = "save" value = "Save..." />
		<?php else: ?>
			<input type = "submit" class = "submit" name = "generate" value = "Generate..." />
		<?php endif; ?>
	  </td>
	</tr>
      </table>
    </form>
<script type = "text/javascript">
var editing = <?php if (isset ( $this->_vars['editing'] )): ?>true<?php else: ?>false<?php endif; ?>;
<?php echo '
$("#form").submit(function(){
     var $respondents = $("#respondents");
	 
	 if($respondents.val().length == 0)
      {
		if(editing)
			$respondents.val(0);
		else
		{
			alert(\'You must enter the number of respondents for this questionnaire.\');
			$respondents.addClass(\'input-highlight\');
	return false;
      }
      else if($respondents.val() == 0 && !editing)
      {
		alert(\'Number of respondents must be greater than zero.\');
		$respondents.addClass(\'input-highlight\');
	return false;
      }
      else
	$respondents.removeClass(\'input-highlight\');



      if($("#expiry-date").val().length == 0)
      {
	alert(\'You must enter the date this questionnaire expires.\');
	$("#expiry-date").addClass(\'input-highlight\');
	return false;
      }
      else
	$("#expiry-date").removeClass(\'input-highlight\');


      return true;
		  });
'; ?>

</script>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
