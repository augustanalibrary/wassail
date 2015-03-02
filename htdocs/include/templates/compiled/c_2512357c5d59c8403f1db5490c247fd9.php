<?php require_once('/var/www/htdocs/include/template_lite/plugins/function.count.php'); $this->register_function("count", "tpl_function_count");  require_once('/var/www/htdocs/include/template_lite/plugins/modifier.escape.php'); $this->register_modifier("escape", "tpl_modifier_escape");  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2015-01-19 12:53:10 MST */ ?>

<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("head.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div style = "min-width:795px;">
      <div id = "tabs">
	<div style = "float:left;width:50%;">
	<ul>
	  <li class = "active">
	    <a href = "#" id = "tab-type">1. Type</a>
	  </li>
	  <li>
	    <a href = "#" id = "tab-text">2. Text</a>
	  </li>
	  <li>
	    <a href = "#" id = "tab-categories">3. Categories</a>
	  </li>
	  <li>
	    <a href = "#" id = "tab-tags">4. Tags</a>
	  </li>
	  <li>
	    <a href = "#" id = "tab-answers">5. Answers</a>
	  </li>
	</ul>
	</div>
	<ul id = "summary" style = "float:left;margin-left:11px;">
	  <li style = "border:1px solid #000;padding:5px;">
	    Summary/Save
	  </li>
	</ul>
      </div>
      <form method = 'post' action = "popup.edit_question.php?id=<?php echo $this->_vars['id']; ?>
" id = "form">
      <div id = "panel-type" class = "panel">
	Choose which type of question you want:
	<br />
	<br />
	<div class = "odd question">
	  <input type = "radio" name = "type" value = "single" <?php if ($this->_vars['question_type'] == 'single'): ?>checked="checked"<?php endif; ?>/>
	  <div>
	    Single Answer
	    <label>
	      Users will be able to select only one response from the provided answers.
	    </label>
	  </div>
	</div>
	<div class = "even question">
	  <input type = "radio" name = "type" value = "multiple" <?php if ($this->_vars['question_type'] == 'multiple'): ?>checked="checked"<?php endif; ?>/>
	  <div>
	    Multiple Answer
	    <label>
	      Users will be able to select more than one response from the provided answers.
	    </label>
	  </div>
	</div>
	<div class = "odd question">
	  <input type = "radio" name = "type" value = "qualitative_short" <?php if ($this->_vars['question_type'] == 'qualitative' && $this->_vars['question_qualitative_type'] == 'short'): ?>checked="checked"<?php endif; ?> />
	  <div>
	    Qualitative (Short)
	    <label>
	      A single line text field will be provided for users to enter their responses.
	    </label>
	  </div>
	</div>
	<div class = "even question">
	  <input type = "radio" name = "type" value = "qualitative_long"  <?php if ($this->_vars['question_type'] == 'qualitative' && $this->_vars['question_qualitative_type'] == 'long'): ?>checked="checked"<?php endif; ?> />
	  <div>
	    Qualitative (Long)
	    <label>
	      A multiple line text field will be provided for users to enter their responses.
	    </label>
	  </div>	  
	</div>
	<div class = "button-holder">
	  <a href = "#" class = "next">Next</a>
	</div>
      </div>


      <div id = "panel-text" class = "panel hidden">
	<textarea name = "content" cols="100" rows = "20" style = "width:100%;" id = "editor-area"><?php echo $this->_vars['text']; ?>
</textarea>
	<div class = "button-holder">
	  <a href = "#" class = "previous">Previous</a> | <a href = "#" class = "next">Next</a>
	</div>
      </div>

      <div id = "panel-categories" class = "panel hidden">
	Hold Ctrl while clicking to select multiple categories
	<br />
	<br />
	<select multiple="multiple" name = "categories[]" size = "28" id = "categories">
	  <?php if (count((array)$this->_vars['categories'])): foreach ((array)$this->_vars['categories'] as $this->_vars['category_id'] => $this->_vars['properties']): ?>
	  <option value = "<?php echo $this->_vars['category_id']; ?>
" <?php if ($this->_vars['properties']['selected'] === TRUE): ?>selected="selected"<?php endif; ?> id = "category-<?php echo $this->_vars['category_id']; ?>
"><?php if (in_array ( $this->_vars['category_id'] , $this->_vars['indent_categories'] )): ?>&nbsp;&nbsp;<?php endif;  echo $this->_vars['properties']['text']; ?>
</option>
	<?php endforeach; endif; ?>
      </select>
	<div class = "button-holder">
	  <a href = "#" class = "previous">Previous</a> | <a href = "#" class = "next">Next</a>
	</div>
      </div>




      <div id = "panel-tags" class = "panel hidden">
	Separate tags with commas.  All tags will be converted to lowercase.
	<br />
	<input type = "text" class = "input-field" name = "tags" id = "tags" value = "<?php echo $this->_run_modifier($this->_vars['tags'], 'escape', 'plugin', 1); ?>
" style = "width:100%; margin-right:5px;"/>
	<div class = "button-holder">
	  <a href = "#" class = "previous">Previous</a> | <a href = "#" class = "next">Next</a>
	</div>
      </div>


      <div id = "panel-answers" class = "panel hidden">
	<div id = "panel-answers-inside">
	  <div style = "vertical-align:middle;">
	    <?php if (isset ( $this->_vars['likert'] )): ?>
			<select name = "likert" id = "likert" style = "vertical-align:middle;cursor:pointer;">
			  <option value = "-1">Add scaled answers...</option>
			<?php if (count((array)$this->_vars['likert'])): foreach ((array)$this->_vars['likert'] as $this->_vars['index'] => $this->_vars['answer']): ?>
			<option value = "<?php echo $this->_vars['index']; ?>
"><?php echo $this->_vars['answer']['title']; ?>
</option>
			<?php endforeach; endif; ?>
		  </select>
	    <?php endif; ?>
	    <?php if (isset ( $this->_vars['common_answers'] )): ?>
			<select name = "common_answers" id = "common_answers" style = "vertical-align:middle;cursor:pointer;">
			  <option value = "-1">Add commonly used responses</option>
			  <?php if (count((array)$this->_vars['common_answers'])): foreach ((array)$this->_vars['common_answers'] as $this->_vars['index'] => $this->_vars['answer']): ?>
			<option value = "<?php echo $this->_vars['index']; ?>
 "><?php echo $this->_vars['answer']; ?>
</option>
			<?php endforeach; endif; ?>
			</select>
	    <?php endif; ?>

	    <br />
	    <input type = "text" id = "new-answer-text" style = "vertical-align:middle;width:350px;" />&nbsp;<span style = "vertical-align:middle;cursor:pointer;" id = "add-answer"><img src = "include/templates/images/add.png" style = "vertical-align:top;margin-top:2px;" alt = "Add answer" />Add new answer</span>
	  </div>
	  
	  <ol type = "a" id = "answer-list-clone-original" style = "display:none;">
	    <li id = "answer-clone-original">
	      <img src = "include/templates/images/arrow-up-down.png" style = "vertical-align:middle;cursor:n-resize;" alt = "Re-order" class = "re-order"/>
	      <img src = "include/templates/images/check-grey.png" alt = "Set answer as correct" title = "Set answer as correct" style = "vertical-align:middle;" class = "status incorrect clickable" />
	      <input type = "hidden" class = "answer-id"/>
	      <input type = "text" value = "" class = "input-field notooltip" size = "60"/>
	      <img src = "include/templates/images/bin.png" alt = "Delete" title = "Delete" style = "vertical-align:middle;" class = "answer-delete clickable" />
	    </li>
	  </ol>
	  <div id = "answer-list-wrapper">
	    <?php if (isset ( $this->_vars['answers'] ) && count ( $this->_vars['answers'] ) > 0): ?>
	    <ol type = "a" id = "answer-list">
	      <?php if (count((array)$this->_vars['answers'])): foreach ((array)$this->_vars['answers'] as $this->_vars['answer_id'] => $this->_vars['answer']): ?>
		<li>
		<img src = "include/templates/images/arrow-up-down.png" style = "vertical-align:middle;cursor:n-resize;" alt = "Re-order" class = "re-order"/>
		<?php if ($this->_vars['answer']['correct'] == 0): ?>
		<img src = "include/templates/images/check-grey.png" alt = "Set answer as correct" title = "Set answer as correct" style = "vertical-align:middle;" class = "status incorrect clickable" />
		<?php else: ?>
		<img src = "include/templates/images/check.png" alt = "Set answer as incorrect" title = "Set answer as incorrect" style = "vertical-align:middle;" class = "status correct clickable" />
		<?php $this->assign('correct', $this->_vars['answer_id']); ?>
		<?php endif; ?>
		<input type = "hidden" name = "answer_ids[]" value = "<?php echo $this->_vars['answer_id']; ?>
"/>
		&nbsp;|&nbsp;
		<input type = "text" name = "answers[]" value = "<?php echo $this->_run_modifier($this->_vars['answer']['text'], 'escape', 'plugin', 1); ?>
" class = "input-field" size = "60" />
		<img src = "include/templates/images/bin.png" alt = "Delete" title = "Delete" style = "vertical-align:middle;" class = "answer-delete clickable" />

	      </li>
	    <?php endforeach; endif; ?>
	  </ol>
	    <?php endif; ?>
	  </div>
	  
	<input type = "hidden" name = "correct" value = "<?php if (isset ( $this->_vars['correct'] )):  echo $this->_vars['correct'];  endif; ?>" id = "correct"/>	    


	  <div class = "button-holder">
	    <a href = "#" class = "previous">Previous</a>
	  </div>
	</div>





	<div id = "panel-answers-qualitative-text" class = "hidden">
	Choose the text to accompany the checkbox users can click if they don't want to or can't answer the question.
	<br />
	<br />
	If left blank, the opt out checkbox will not be shown and the question will become required.
	<br />
	<br />
	
	 <?php if (isset ( $this->_vars['common_answers'] )): ?>
	 	
		<input type = "text" id = "qualitative-opt-out-text" name = "qualitative_opt_out" value = "<?php if ($this->_vars['id'] != 0):  echo $this->_run_modifier($this->_vars['opt_out'], 'escape', 'plugin', 1, "html");  else: ?>I prefer not to answer or not applicable<?php endif; ?>" size = "60"/>
		<select id = "qualitative-opt-out" style = "vertical-align:middle;cursor:pointer;">
			<option value = "-1">&larr; Add commonly used options</option>
			<?php if (count((array)$this->_vars['common_answers'])): foreach ((array)$this->_vars['common_answers'] as $this->_vars['index'] => $this->_vars['answer']): ?>
				<option value = "<?php echo $this->_vars['index']; ?>
"><?php echo $this->_vars['answer']; ?>
</option>
			<?php endforeach; endif; ?>
		</select>
	    <?php endif; ?>
	</div>
      </div>
      <div id = "panel-summary" class = "summary-panel">
	<div id = "type-error-holder" class = "hidden">
	  <div class = "error">
	    <a href = "#" class = "no-type-fix">
	      Please choose a question type. 
	    </a>
	  </div>
	</div>
	<div id = "text-error-holder" class = "hidden">
	  <div class = "error">
	    <a href = "#" class = "no-text-fix">
	      Please enter some question text. 
	    </a>
	  </div>
	</div>
	<div id = "answer-error-holder" class = "hidden">
	  <div class = "error">
	    <a href = "#" class = "no-answer-fix">
	      Please enter some answers.  
	    </a>
	  </div>
	</div>
	<fieldset>
	  <legend>
	    Type
	  </legend>
	  <div id = "summary-type">	    
	  </div>
	</fieldset>
	<fieldset>
	  <legend>
	    Text
	  </legend>
	  <div id = "summary-text">
	  </div>
	</fieldset>
	<fieldset>
	  <legend>
	    Categories
	  </legend>
	  <div id = "summary-categories">
	  </div>
	</fieldset>
	<fieldset>
	  <legend>
	    Tags
	  </legend>
	  <div id = "summary-tags">
	  </div>
	</fieldset>
	<fieldset>
	  <legend>
	    Answers
	  </legend>
	  <div id = "summary-answers">
	  </div>
	</fieldset>
	<div id = "save" style = "text-align:right;">
	  <input type = "submit" class = "submit" value = "Save question &amp; close" name = "save_close"/>
	  <input type = "submit" class = "submit" value = "Save question &amp; enter another" name = "save_again"/>
	  <br />
	  <br />
	</div>
	<div style = "text-align:right;padding-right:4px;">
	  <input type = "submit" class = "submit" value = "Cancel" id = "cancel" />
	</div>
      </div>
      </form>
</div>
<script type = "text/javascript">
// Build a JS array from the Likert answers
var likert = new Array(<?php echo tpl_function_count(array('target' => $this->_vars['likert']), $this);?>);
<?php if (count((array)$this->_vars['likert'])): foreach ((array)$this->_vars['likert'] as $this->_vars['key'] => $this->_vars['answers']): ?>
      likert[<?php echo $this->_vars['key']; ?>
] = new Array(<?php echo tpl_function_count(array('target' => $this->_vars['answers']['values']), $this);?>);
      <?php if (count((array)$this->_vars['answers']['values'])): foreach ((array)$this->_vars['answers']['values'] as $this->_vars['answer_key'] => $this->_vars['answer_text']): ?>
      likert[<?php echo $this->_vars['key']; ?>
][<?php echo $this->_vars['answer_key']; ?>
] = '<?php echo $this->_vars['answer_text']; ?>
';
      <?php endforeach; endif;  endforeach; endif; ?>
</script>
<script type = "text/javascript" src = "include/templates/js/edit_question.js"></script>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("foot.popup.tpl", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>